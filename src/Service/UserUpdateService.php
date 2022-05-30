<?php

namespace App\Service;

use App\Entity\User;
use App\Model\SignUpRequest;
use App\Model\UserUpdateRequest;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;

class UserUpdateService
{
    public function __construct(private UserPasswordHasherInterface $hasher,
                                private UserRepository $userRepository,
                                private EntityManagerInterface $em,
                                private AuthenticationSuccessHandler $successHandler)
    {
    }

    public function userUpdate($entityManager,UserUpdateRequest $userUpdateRequest,$id): Response
    {
        if ($this->userRepository->existsByEmail($userUpdateRequest->getEmail())) {
            throw new UserAlreadyExistsException();
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        if(null !== $userUpdateRequest->getRoles()){
            $role = [$userUpdateRequest->getRoles()];
            $user -> setRoles($role);
        }
        
        $user -> setFirstName($userUpdateRequest->getFirstName());
        $user -> setLastName($userUpdateRequest->getLastName());
        $user -> setEmail($userUpdateRequest->getEmail());

        if(null !== $userUpdateRequest->getRoles()){
            $user->setPassword($this->hasher->hashPassword($user, $userUpdateRequest->getPassword()));
        }
        $this->em->persist($user);
        $this->em->flush();

        //return $this->successHandler->handleAuthenticationSuccess($user);
        return $user;
    }
}
