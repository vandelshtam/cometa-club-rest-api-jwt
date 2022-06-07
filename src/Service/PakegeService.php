<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\Pakege;
use App\Entity\TokenRate;
use App\Entity\TablePakage;
use App\Model\PakegeRequest;
use App\Service\MailerService;
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
use App\Exception\WalletSommNotExistsException;
use App\Model\PakegeReview as PakegeReviewModel;
use App\Exception\ReferralLinkNotExistsException;
use App\Exception\TablePakageIdNotFoundException;
use App\Exception\TablePakageAlreadyExistsException;

class PakegeService
{
    private const PAGE_LIMIT = 5;

    public function __construct(private UserRepository $userRepository,
                                private PakegeRepository $pakegeRepository,
                                private WalletRepository $walletRepository,
                                private TablePakageRepository $tablePakageRepository,
                                private ManagerRegistry $doctrine,
                                private EntityManagerInterface $entityManager, 
                                private SignUpService $signUpService,
                                private EntityManagerInterface $em,
                                private TransactionTableService $transactionTableService,
                                private MailerService $mailerService
                                )
    {
    }

    public function pakegeNew($pakegeRequest,$doctrine,$current_user)
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // if (!$this->userRepository->existsByName($pakegeRequest->getReferralLink())) {
        //     throw new ReferralLinkNotExistsException();
        // }

        $entityManager = $doctrine->getManager(); 
        // if (null === $this->userRepository->findOneBy(['user_id' => $pakegeRequest->getUserId()])) {
        //     $user = $this->signUpService->signUserNew($pakegeRequest);
        // }
        // else{
        //     $user = $this->userRepository->findOneBy(['user_id' => $pakegeRequest->getUserId()]);
        // }
        $user = $this->userRepository->getUserId($pakegeRequest->getUserId());
        $user_id = $current_user->getId();
        $client_code = $current_user->getPesonalCode();
        $referral_link = $current_user->getReferralLink();
        //dd($client_code);
        
        if (!$this->tablePakageRepository->existsByPakageId($pakegeRequest->getPakageId())) {
            throw new TablePakageIdNotFoundException();
        }

        $unique_code1 = $this->random_string(10);
        $unique_code2 = $this->random_string(10);
        $unique_code = $unique_code1.$unique_code2;
        
        $token_rate =  $entityManager->getRepository(TokenRate::class)->findOneBy(['id' => 1]) -> getExchangeRate();
        $pakage_table = $entityManager->getRepository(TablePakage::class)->findOneBy(['id' => $pakegeRequest->getPakageId()]);
        $wallet = $this->walletRepository->getExsistsByWallet($current_user -> getId());
        $pakage_name_table = $pakage_table -> getName();
        $pakage_user_price = $pakage_table -> getPricePakage();
        $type_token = [
            '1' => 'usdt',
            '2' => 'bitcoin',
            '3' => 'etherium',
            '4' => 'cometapoin',
          ];
          
        //$token = $type_token[$pakegeRequest->getPakageId()];

        if($pakegeRequest->getTypeToken() == '1'){
            $current_token = $wallet -> getUsdt();
        }
        elseif($pakegeRequest->getTypeToken() == '2'){
            $current_token = $wallet -> getBitcoin();
        }
        elseif($pakegeRequest->getTypeToken() == '3'){
            $current_token = $wallet -> getEtherium();
        }
        elseif($pakegeRequest->getTypeToken() == '4'){
            $current_token = $wallet -> getCometapoin();
        }
        
        if ($pakage_user_price > $current_token) {
            throw new WalletSommNotExistsException();
        }

        $price_token = $pakage_user_price * $token_rate;
        $client_code = $user -> getPesonalCode();
        $price_usdt = $pakage_table -> getPricePakage();
        
        //запись в таблицу пакетов нового пакета пользователя
        $pakege = new Pakege();
            $pakege ->setName($pakage_name_table);
            $pakege ->setPrice($pakage_user_price);
            $pakege ->setUserId($user_id);
            //dd($current_user->getPesonalCode());
            $pakege ->setClientCode($current_user->getPesonalCode());
            $pakege ->setUniqueCode($unique_code);
            $pakege ->setActivation(0);//код активации пакета
            $pakege ->setAction(0);//код нового пакета приобретенного без акции акции
            $pakege ->setToken($price_token);
            $pakege ->setReferralLink($referral_link);
            $pakege ->setCreatedAt((new \DateTimeImmutable()));
            $pakege ->setUpdatedAt((new \DateTimeImmutable()));
            ;
        if($pakegeRequest->getTypeToken() == '1'){
            $wallet -> setUsdt($current_token - $pakage_user_price);
        }
        elseif($pakegeRequest->getTypeToken() == '2'){
            $wallet -> setBitcoin($current_token - $pakage_user_price);
        }
        elseif($pakegeRequest->getTypeToken() == '3'){
            $wallet -> setEtherium($current_token - $pakage_user_price);
        }
        elseif($pakegeRequest->getTypeToken() == '4'){
            $wallet -> setCometapoin($current_token - $pakage_user_price);
        }
    
        $this->em->persist($pakege);
        $this->em->flush();

        //запись в таблицу тразакций
        $pakage_id = $entityManager->getRepository(Pakege::class)->findOneBy(['unique_code' => $unique_code])->getId(); 
        $this->transactionTableService->pakegeNew($pakage_user_price,$user->getUserId(),$pakage_id);

        //отправка электронного письма с подтверждением
        $notice_mailer = $this->mailerService->sendEmail($user->getUserId(),$user->getEmail());

        $notice = [
                    'success' =>'Congratulations! You have successfully purchased a new package.',
                    'info' => 'In order for the package to start working for you, you must activate the package. Activate the package!'
                  ]; 

        $pakege_new = [$pakege, $notice, $notice_mailer];
        return $pakege_new;
    }

    public function pakegesUser($pakegeUserRequest,$current_user): PakegeAllListResponse
    {
        $user_id = $current_user -> getId();
        if (!$this->pakegeRepository->existsByPakegeUserId($user_id)) {
            throw new PakegeUserNotExistsException();
        }
        
        $user = $this->userRepository->getUserId($pakegeUserRequest->getUserId($pakegeUserRequest->getUserId()));
        
        $pakeges = $this->pakegeRepository->findByExampleField($user_id);
        //dd($user_id);

        $items = array_map(
            fn (Pakege $pakege) => new PakegeModel(
                $pakege->getId(), $pakege->getUserId(), $pakege->getName(), $pakege->getPrice(),$pakege->getToken(),
                $pakege->getClientCode(), $pakege->getReferralLink(), $pakege->getActivation(),$pakege->getAction(),$pakege->getCreatedAt(),$pakege->getUpdatedAt()
            ),
            $pakeges
        );
        
        $info = $this->getReviewPageByUserId($user_id);
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
    
    private function random_string ($str_length)
    {
    $str_characters = array (0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	// Функция может генерировать случайную строку и с использованием кириллицы
    //$str_characters = array (0,1,2,3,4,5,6,7,8,9,'а','б','в','г','д','е','ж','з','и','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','э','ю','я');

    // Возвращаем ложь, если первый параметр равен нулю или не является целым числом
    if (!is_int($str_length) || $str_length < 0)
    {
        return false;
    }

    // Подсчитываем реальное количество символов, участвующих в формировании случайной строки и вычитаем 1
    $characters_length = count($str_characters) - 1;

    // Объявляем переменную для хранения итогового результата
    $string = '';

    // Формируем случайную строку в цикле
    for ($i = $str_length; $i > 0; $i--)
    {
        $string .= $str_characters[mt_rand(0, $characters_length)];
    }

    // Возвращаем результат
    return $string;
    }

}
