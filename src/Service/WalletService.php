<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\Wallet;
use App\Entity\TokenRate;
use App\Entity\TablePakage;
use App\Model\WalletRequest;
use App\Security\UserService;
use App\Service\MailerService;
//use App\Service\SignUpService;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Model\PakageAllListResponse;
use App\Model\PakegeAllListResponse;
use App\Model\Wallet as WalletModel;
use App\Model\WalletReviewPage;
use App\Model\WalletAllListResponse;
use App\Repository\PakegeRepository;
use App\Repository\WalletRepository;
use App\Exception\UserNotFoundException;
use App\Service\TransactionTableService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TablePakageRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\WalletNotExistsException;
use Symfony\Component\Security\Core\Security;
use App\Exception\TypeTokenNotExistsException;
use Symfony\Component\HttpFoundation\Response;
use App\Exception\PakegeUserNotExistsException;
use App\Model\WalletReview as WalletReviewModel;
use App\Exception\ReferralLinkNotExistsException;
use App\Exception\TablePakageIdNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\TablePakageAlreadyExistsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WalletService extends AbstractController
{
    private const PAGE_LIMIT = 5;

    /** @var  TokenStorageInterface */
    private $tokenStorage;
    /**
     * @param TokenStorageInterface  $storage
     */
    

    public function __construct(private UserRepository $userRepository,
                                private WalletRepository $walletRepository,
                                private ManagerRegistry $doctrine,
                                private EntityManagerInterface $entityManager, 
                                //private SignUpService $signUpService,
                                private EntityManagerInterface $em,
                                private TransactionTableService $transactionTableService,
                                private MailerService $mailerService,
                                private UserService $userService,
                                )
    {
    
    }

    public function walletAdd($walletRequest,$doctrine,$current_user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $entityManager = $doctrine->getManager(); 
        if (null === $this->userRepository->findOneBy(['user_id' => $walletRequest->getUserId()])) {
            throw new UserNotFoundException();
        }
        
        $user_id = $current_user->getId();
        $parent_user_id = $walletRequest->getUserId();
        $wallet = $this->walletRepository->getExsistsByWallet($user_id);
        
        if ($wallet->getParentUserId() != $walletRequest->getUserId()) {
            //throw new WalletNotExistsException();
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        $type = trim($walletRequest->getType(), '/.*:;,)([]$%');
        
        $type_token = [
                        '1' => 'usdt',
                        '2' => 'bitcoin',
                        '3' => 'etherium',
                        '4' => 'cometapoin',
                      ];
                      
        // if (!in_array($type, $type_token)) {
        //     throw new TypeTokenNotExistsException();
        // }              

        //запись нового баланса в кошелек пользователя
        $current_bitcoin = $wallet -> getBitcoin();
        $current_etherium = $wallet -> getEtherium();
        $current_cometapoin = $wallet -> getCometapoin();
        $current_usdt = $wallet -> getUsdt();
        if($walletRequest->getType() == '1'){
            $wallet -> setUsdt($current_usdt + $walletRequest->getSumm());
        }
        elseif($walletRequest->getType() == '2'){
            $wallet -> setBitcoin($current_bitcoin + $walletRequest->getSumm());
        }
        elseif($walletRequest->getType() == '3'){
            $wallet -> setEtherium($current_etherium + $walletRequest->getSumm());
        }
        elseif($walletRequest->getType() == '4'){
            $wallet -> setCometapoin($current_cometapoin + $walletRequest->getSumm());
        }
        $wallet -> setCreatedAt((new \DateTimeImmutable()));
        $wallet -> setUpdatedAt((new \DateTimeImmutable()));
        $this->em->persist($wallet);
        $this->em->flush();

        //запись в таблицу тразакций
        $wallet_id = $entityManager->getRepository(Wallet::class)->findOneBy(['user_id' => $user_id])->getId();
        $type_opation = $type_token[$walletRequest->getType()]; 
        $summ = $walletRequest->getSumm();
        $this->transactionTableService->walletAdd($summ,$user_id,$wallet_id,$type_opation,$parent_user_id);

        //отправка электронного письма с подтверждением
        $notice_mailer = $this->mailerService->sendEmailAddWallet($user_id,$current_user->getEmail(),$summ,$type_opation);

        $notice = [
                    'success' =>'Congratulations! You have successfully replenished your wallet.'
                  ]; 
        $addSumm = [
                    'Last deposit amount' => $walletRequest->getSumm()
                  ];           
        $wallet_new = [$wallet, $notice, $notice_mailer, $addSumm];
        return $wallet_new;
    }

    public function walletCreate($new_user,$user_id,$doctrine)
    {
        //создание кошелька пользователя
        $wallet = new Wallet();
        $wallet -> setUserId($new_user->getId());
        $wallet -> setParentUserId($user_id);
        $wallet -> setUsdt(0.00);
        $wallet -> setBitcoin(0.00);
        $wallet -> setEtherium(0.00);
        $wallet -> setCometapoin(0.00);
        $wallet -> setCreatedAt((new \DateTimeImmutable()));
        $wallet -> setUpdatedAt((new \DateTimeImmutable()));
        $this->em->persist($wallet);
        $this->em->flush();

        return $wallet;
    }


    public function walletAll(): WalletAllListResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $wallet = $this->walletRepository->findByAllTWallet();

        $items = array_map(
            fn (Wallet $wallet) => new WalletModel(
                $wallet->getId(), $wallet->getUserId(), $wallet->getUsdt(), $wallet->getBitcoin(),$wallet->getEtherium(),
                $wallet->getCometapoin(), $wallet->getUpdatedAt()
            ),
            $wallet
        );

        return new WalletAllListResponse($items);
    }

    // public function walletUser($current_user): WalletAllListResponse
    // {
    //     $this->denyAccessUnlessGranted('ROLE_ADMIN');
    //     $user_id = $current_user -> getId();
    //     $this->walletRepository->getExsistsByWallet($user_id); 
    //     $wallet = $this->walletRepository->findByWalletUser($user_id);
    //     if (null === $current_user) {
    //         throw new UserNotFoundException();
    //     }
        
    //     $items = array_map(
    //         fn (Wallet $wallet) => new WalletModel(
    //             $wallet->getId(), $wallet->getUserId(), $wallet->getUsdt(), $wallet->getBitcoin(),$wallet->getEtherium(),
    //             $wallet->getCometapoin(), $wallet->getUpdatedAt()
    //         ),
    //         $wallet
    //     );

    //     return new WalletAllListResponse($items);
    // }


    public function walletReviewUser(int $wallet_id): WalletAllListResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $this->walletRepository->getExsistsByWalletId($wallet_id); 
        $wallet = $this->walletRepository->findByWalletId($wallet_id);
        
        $items = array_map(
            fn (Wallet $wallet) => new WalletModel(
                $wallet->getId(), $wallet->getUserId(), $wallet->getUsdt(), $wallet->getBitcoin(),$wallet->getEtherium(),
                $wallet->getCometapoin(), $wallet->getUpdatedAt()
            ),
            $wallet
        );

        return new WalletAllListResponse($items);
    }

    public function walletReviewUserId(int $user_id): WalletAllListResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $this->walletRepository->getExsistsByWallet($user_id); 
        $wallet = $this->walletRepository->findByWalletUserId($user_id);
        
        $items = array_map(
            fn (Wallet $wallet) => new WalletModel(
                $wallet->getId(), $wallet->getUserId(), $wallet->getUsdt(), $wallet->getBitcoin(),$wallet->getEtherium(),
                $wallet->getCometapoin(), $wallet->getUpdatedAt()
            ),
            $wallet
        );

        return new WalletAllListResponse($items);
    }

    public function wallet($current_user): WalletAllListResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        if (null === $current_user) {
            throw new UserNotFoundException();
        }
        $user_id = $current_user->getId();
        
        $this->walletRepository->getExsistsByWallet($user_id); 
        $wallet = $this->walletRepository->findByWalletUserId($user_id);
        
        $items = array_map(
            fn (Wallet $wallet) => new WalletModel(
                $wallet->getId(), $wallet->getUserId(), $wallet->getUsdt(), $wallet->getBitcoin(),$wallet->getEtherium(),
                $wallet->getCometapoin(), $wallet->getUpdatedAt()
            ),
            $wallet
        );

        return new WalletAllListResponse($items);
    }


    public function getReviewPageBy(int $page): WalletReviewPage
    {
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;
        $paginator = $this->walletRepository->getPageBy($offset, self::PAGE_LIMIT);
        $items = [];

        $total_wallet = count($this->walletRepository->findByAllWallet());
        $total_usdt = $this->walletRepository->getWalletTotalUsdt();
        $total_bitcoin = $this->walletRepository->getWalletTotalBitcoin();
        $total_etherium = $this->walletRepository->getWalletTotalEtherium();
        $total_cometapoin = $this->walletRepository->getWalletTotalCometapoin();


        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }


        return (new WalletReviewPage())
            ->setPage($page)
            ->setTotalWallet($total_wallet)
            ->setTotalUsdt($total_usdt)
            ->setTotalBitcoin($total_bitcoin)
            ->setTotalEtherium($total_etherium)
            ->setTotalCometapoin($total_cometapoin)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total_wallet / self::PAGE_LIMIT))
            ->setItems($items);
    }


    public function map(Wallet $wallet): WalletReviewModel
    {
        return (new WalletReviewModel())
            ->setId($wallet->getId())
            ->setUserId($wallet->getUserId())
            ->setUsdt($wallet->getUsdt())
            ->setBitcoin($wallet->getBitcoin())
            ->setEtherium($wallet->getEtherium())
            ->setCometapoin($wallet->getCometapoin())
            ->setCreatedAt($wallet->getUpdatedAt()->getTimestamp());
    }

}
