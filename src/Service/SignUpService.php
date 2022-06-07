<?php

namespace App\Service;

use App\Entity\User;
use App\Model\PakegeRequest;
use App\Model\SignUpRequest;
use App\Service\WalletService;
use App\Model\WalletRequest;
use App\Model\SignUpCreateRequest;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class SignUpService
{
    public function __construct(private UserPasswordHasherInterface $hasher,
                                private UserRepository $userRepository,
                                private EntityManagerInterface $em,
                                private AuthenticationSuccessHandler $successHandler,
                                private ManagerRegistry $doctrine,
                                private EntityManagerInterface $entityManager,
                                private WalletService $walletService )
    {
    }

    public function signUp(SignUpRequest $signUpRequest): Response
    {
        if ($this->userRepository->existsByEmail($signUpRequest->getEmail())) {
            throw new UserAlreadyExistsException();
        }
        $user_id = $signUpRequest->getUserId();
        $roles = $signUpRequest->getRoles();
        $random_code = 'CP'.mt_rand();
        $client_code = $user_id.$random_code;
        $secret_code = mt_rand().'-'.mt_rand();
        while($this->userRepository->existsByPesonalCode($client_code)){
            $client_code = $user_id.$random_code;
        }
        while($this->userRepository->existsBySecretCode($secret_code)){
            $secret_code = mt_rand().'-'.mt_rand();
        }
        $user = (new User())
            ->setRoles([$roles])
            ->setFirstName($signUpRequest->getFirstName())
            ->setUserId($user_id)
            ->setReferralLink($signUpRequest->getReferralLink())
            ->setPesonalCode($client_code)
            ->setSecretCode($secret_code)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setEmail($signUpRequest->getEmail());

        $user->setPassword($this->hasher->hashPassword($user, $signUpRequest->getPassword()));

        $this->em->persist($user);
        $this->em->flush();

        $entityManager = $this->doctrine->getManager(); 
        $new_user = $this->userRepository->findOneBy(['user_id' => $user_id]);
        $user_create = [];
        $name = $new_user->getFirstName();
        $email = $new_user->getEmail();
        $referral_link = $new_user->getReferralLink();
        $personal_code = $new_user->getPesonalCode();
        $user_create = ['name' => $name, 'email' => $email, 'referral_link' => $referral_link, 'personal_code' => $personal_code];

        $this -> walletService -> walletCreate($new_user,$user_id,$this->doctrine);

        return $this->successHandler->handleAuthenticationSuccess($user);
    }

    public function signUserNew(PakegeRequest $pakegeRequest)
    {
        if ($this->userRepository->existsByEmail($pakegeRequest->getEmail())) {
            throw new UserAlreadyExistsException();
        }

        $user_id = $pakegeRequest->getUserId();
        $random_code = 'CP'.mt_rand();
        $client_code = $user_id.$random_code;
        $secret_code = mt_rand().'-'.mt_rand();
        while($this->userRepository->existsByPesonalCode($client_code)){
            $client_code = $user_id.$random_code;
        }
        while($this->userRepository->existsBySecretCode($secret_code)){
            $secret_code = mt_rand().'-'.mt_rand();
        }
        $user = (new User())
            ->setRoles(['ROLE_USER'])
            ->setFirstName('User number - '.$user_id)
            ->setUserId($user_id)
            ->setReferralLink($pakegeRequest->getReferralLink())
            ->setPesonalCode($client_code)
            ->setSecretCode($secret_code)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setEmail($pakegeRequest->getEmail());

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function signUserWalletNew(WalletRequest $walletRequest)
    {
        if ($this->userRepository->existsByEmail($walletRequest->getEmail())) {
            throw new UserAlreadyExistsException();
        }

        $user_id = $walletRequest->getUserId();
        $random_code = 'CP'.mt_rand();
        $client_code = $user_id.$random_code;
        $secret_code = mt_rand().'-'.mt_rand();
        while($this->userRepository->existsByPesonalCode($client_code)){
            $client_code = $user_id.$random_code;
        }
        while($this->userRepository->existsBySecretCode($secret_code)){
            $secret_code = mt_rand().'-'.mt_rand();
        }
        $user = (new User())
            ->setRoles(['ROLE_USER'])
            ->setFirstName('User number - '.$user_id)
            ->setUserId($user_id)
            ->setReferralLink($walletRequest->getReferralLink())
            ->setPesonalCode($client_code)
            ->setSecretCode($secret_code)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setEmail($walletRequest->getEmail());

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function signUserCreate(SignUpCreateRequest $signUpCreateRequest)
    {
        // if ($this->userRepository->existsByEmail($signUpCreateRequest->getReferralLink())) {
        //     throw new ExistsException();
        // }

        $user_id = $signUpCreateRequest->getUserId();
        $roles = $signUpCreateRequest->getRoles();
        $random_code = 'CP'.mt_rand();
        $client_code = $user_id.$random_code;
        $secret_code = mt_rand().'-'.mt_rand();
        $password = 'asd42536FGHlaks8755Xcvkjghfgq39847bv65MC85';
        while($this->userRepository->existsByPesonalCode($client_code)){
            $client_code = $user_id.$random_code;
        }
        while($this->userRepository->existsBySecretCode($secret_code)){
            $secret_code = mt_rand().'-'.mt_rand();
        }
        $user = (new User())
            ->setRoles([$roles])
            ->setFirstName($signUpCreateRequest->getFirstName())
            ->setUserId($user_id)
            ->setReferralLink($signUpCreateRequest->getReferralLink())
            ->setPesonalCode($client_code)
            ->setSecretCode($secret_code)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setEmail($signUpCreateRequest->getEmail());

            $user->setPassword($this->hasher->hashPassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        $entityManager = $this->doctrine->getManager(); 
        $new_user = $this->userRepository->findOneBy(['user_id' => $user_id]);
        $user_create = [];
        $name = $new_user->getFirstName();
        $email = $new_user->getEmail();
        $referral_link = $new_user->getReferralLink();
        $personal_code = $new_user->getPesonalCode();
        $user_create = ['name' => $name, 'email' => $email, 'referral_link' => $referral_link, 'personal_code' => $personal_code];

        $this -> walletService -> walletCreate($new_user,$user_id,$this->doctrine);

        return $user_create;
    }


}
