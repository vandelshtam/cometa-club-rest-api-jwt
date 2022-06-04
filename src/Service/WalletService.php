<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\Wallet;
use App\Entity\TokenRate;
use App\Entity\TablePakage;
use App\Model\WalletRequest;
use App\Service\MailerService;
use App\Security\GetMeUser;
use App\Service\SignUpService;
use App\Model\PakegeReviewPage;
use App\Repository\UserRepository;
use App\Model\PakageAllListResponse;
use App\Model\Pakege as PakegeModel;
use App\Model\PakegeAllListResponse;
use App\Repository\PakegeRepository;
use App\Repository\WalletRepository;
use App\Service\TransactionTableService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TablePakageRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\PakegeUserNotExistsException;
use App\Model\PakegeReview as PakegeReviewModel;
use App\Exception\ReferralLinkNotExistsException;
use App\Exception\TablePakageIdNotFoundException;
use App\Exception\TablePakageAlreadyExistsException;

class WalletService
{
    private const PAGE_LIMIT = 5;

    public function __construct(private UserRepository $userRepository,
                                private WalletRepository $walletRepository,
                                private ManagerRegistry $doctrine,
                                private EntityManagerInterface $entityManager, 
                                private SignUpService $signUpService,
                                private EntityManagerInterface $em,
                                private TransactionTableService $transactionTableService,
                                private MailerService $mailerService,
                                )
    {
    }

    public function walletAddCreate($walletRequest,$doctrine)
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // if (!$this->userRepository->existsByName($pakegeRequest->getReferralLink())) {
        //     throw new ReferralLinkNotExistsException();
        // }
        
        $entityManager = $doctrine->getManager(); 
        if (null === $this->userRepository->findOneBy(['user_id' => $walletRequest->getUserId()])) {
            $user = $this->signUpService->signUserWalletNew($walletRequest);
        }
        else{
            $user = $this->userRepository->findOneBy(['user_id' => $walletRequest->getUserId()]);
        }

        // if (!$this->tablePakageRepository->existsByPakageId($walletRequest->getPakageId())) {
        //     throw new TablePakageIdNotFoundException();
        // }
        $type_token = [
                        '1' => 'usdt',
                        '2' => 'bitcoin',
                        '3' => 'etherium',
                      ];
        
        //$token_rate =  $entityManager->getRepository(TokenRate::class)->findOneBy(['id' => 1]) -> getExchangeRate();
        // $pakage_table = $entityManager->getRepository(TablePakage::class)->findOneBy(['id' => $walletRequest->getPakageId()]);
        // $pakage_name_table = $pakage_table -> getName();
        // $pakage_user_price = $pakage_table -> getPricePakage();
        // $price_token = $pakage_user_price * $token_rate;
        // $client_code = $user -> getPesonalCode();
        // $price_usdt = $pakage_table -> getPricePakage();
        
        //создание кошелька пользователя
        $wallet = new Wallet();
        $wallet -> setUserId($user->getUserId());
        if($walletRequest->getType() == '1'){
            $wallet -> setUsdt($walletRequest->getSumm());
            $wallet -> setBitcoin(0.00);
            $wallet -> setEtherium(0.00);
            $wallet -> setCometapoin(0.00);
        }
        elseif($walletRequest->getType() == '2'){
            $wallet -> setUsdt(0.00);
            $wallet -> setBitcoin($walletRequest->getSumm());
            $wallet -> setEtherium(0.00);
            $wallet -> setCometapoin(0.00);
        }
        else{
            $wallet -> setUsdt(0.00);
            $wallet -> setBitcoin(0.00);
            $wallet -> setEtherium($walletRequest->getSumm());
            $wallet -> setCometapoin(0.00);
        }
        $wallet -> setCreatedAt((new \DateTimeImmutable()));
        $wallet -> setUpdatedAt((new \DateTimeImmutable()));
        $this->em->persist($wallet);
        $this->em->flush();

        //запись в таблицу тразакций
        $wallet_id = $entityManager->getRepository(Wallet::class)->findOneBy(['user_id' => $user->getUserId()])->getId();
        $type_opation = $type_token[$walletRequest->getType()]; 
        $summ = $walletRequest->getSumm();
        $this->transactionTableService->walletAddCreate($summ,$user->getUserId(),$wallet_id,$type_opation);

        //отправка электронного письма с подтверждением
        $notice_mailer = $this->mailerService->sendEmailAddWallet($user->getUserId(),$user->getEmail(),$summ,$type_opation);

        $notice = [
                    'success' =>'Congratulations! You have successfully replenished your wallet.'
                  ]; 
        $addSumm = [
                    'Last deposit amount' => $walletRequest->getSumm()
                  ];           
        $wallet_new = [$wallet, $notice, $notice_mailer, $addSumm];
        return $wallet_new;
    }

    public function pakegesUser($pakegeUserRequest): PakegeAllListResponse
    {
        if (!$this->pakegeRepository->existsByPakegeUserId($pakegeUserRequest->getUserId())) {
            throw new PakegeUserNotExistsException();
        }
        
        $user = $this->userRepository->getUserId($pakegeUserRequest->getUserId($pakegeUserRequest->getUserId()));

        $pakeges = $this->pakegeRepository->findByExampleField($pakegeUserRequest->getUserId());

        $items = array_map(
            fn (Pakege $pakege) => new PakegeModel(
                $pakege->getId(), $pakege->getUserId(), $pakege->getName(), $pakege->getPrice(),$pakege->getToken(),
                $pakege->getClientCode(), $pakege->getReferralLink(), $pakege->getActivation(),$pakege->getAction(),$pakege->getCreatedAt(),$pakege->getUpdatedAt()
            ),
            $pakeges
        );
        
        $info = $this->getReviewPageByUserId($pakegeUserRequest->getUserId());
        $items[] = $info;
        return new PakegeAllListResponse($items);
    }

    public function update($entityManager,$tablePakageRequest,$table_pakage_id): PakageAllListResponse
    {
        $update_pakage = $entityManager->getRepository(TablePakage::class)->findOneBy(['id' => $table_pakage_id]);
        $update_pakage -> setName($tablePakageRequest->getName());
        $update_pakage -> setPricePakage($tablePakageRequest->getPricePakage());
        $update_pakage -> setDescription($tablePakageRequest->getDescription());
        $update_pakage -> setUpdatedAt((new \DateTime()));

        $this->em->persist($update_pakage);
        $this->em->flush();

        $pakage = $this->tablePakageRepository->getByTokenPakageOne($table_pakage_id);
        $items = array_map(
            fn (TablePakage $tablePakage) => new PakageCategoryModel(
                $tablePakage->getId(), $tablePakage->getName(), $tablePakage->getPricePakage(),$tablePakage->getDescription()
            ),
            $pakage
        );

        return new PakageAllListResponse($items);
    }

    public function getReviewPageBy(int $page): PakegeReviewPage
    {
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->pakegeRepository->getPageBy($offset, self::PAGE_LIMIT);
        $items = [];

        $total_users_pakeges = count($this->pakegeRepository->findByAllPakege());
        $total_users_price_pakeges = $this->pakegeRepository->getPakegeAllTotalPriceSum();


        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }


        return (new PakegeReviewPage())
            ->setPage($page)
            ->setTotal($total_users_pakeges)
            ->setAllPrice($total_users_price_pakeges)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total_users_pakeges / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function getReviewPageByUserId(int $user_id): PakegeReviewPage
    {
    
        $total_users_pakeges = $this->pakegeRepository->countByUserId($user_id);
        $total_users_price_pakeges = $this->pakegeRepository->getPakegeTotalPriceSum($user_id);


        // foreach ($pakeges as $item) {
        //     $items[] = $this->map($item);
        // }


        return (new PakegeReviewPage())
            ->setTotal($total_users_pakeges)
            ->setAllPrice($total_users_price_pakeges)
            //->setItems($items)
            ;
    }



    public function map(Pakege $pakege): PakegeReviewModel
    {
        return (new PakegeReviewModel())
            ->setId($pakege->getId())
            ->setUserId($pakege->getUserId())
            ->setName($pakege->getName())
            ->setPrice($pakege->getPrice())
            ->setReferralLink($pakege->getReferralLink())
            ->setToken($pakege->getToken())
            ->setClientCode($pakege->getClientCode())
            ->setActivation($pakege->getActivation())
            ->setAction($pakege->getAction())
            ->setCreatedAt($pakege->getCreatedAt()->getTimestamp());
    }

}
