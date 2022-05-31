<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Model\SignUpRequest;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpService
{
    public function __construct(private UserPasswordHasherInterface $hasher,
                                private UserRepository $userRepository,
                                private EntityManagerInterface $em,
                                private AuthenticationSuccessHandler $successHandler)
    {
    }

    public function signUp(SignUpRequest $signUpRequest): Response
    {
        if ($this->userRepository->existsByEmail($signUpRequest->getEmail())) {
            throw new UserAlreadyExistsException();
        }
        $user_id = $signUpRequest->getUserId();
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

        return $this->successHandler->handleAuthenticationSuccess($user);
    }

}
