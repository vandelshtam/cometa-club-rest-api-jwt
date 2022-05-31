<?php

namespace App\Service;

use App\Entity\User;
use App\Model\UserUpdateRequest;
use App\Repository\UserRepository;
use App\Model\UserUpdateListResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\UserUpdate as UserUpdateModel;
use App\Exception\RoleUserNotExistsException;
use App\Exception\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function userUpdate($entityManager,UserUpdateRequest $userUpdateRequest,$user_id): UserUpdateListResponse
    {
        if($this->userRepository->existsByEmail($userUpdateRequest->getEmail()) != $userUpdateRequest->getEmail()){
            if ($this->userRepository->existsByEmail($userUpdateRequest->getEmail())) {
            throw new UserAlreadyExistsException();
            }
        }
        
        //$update_user = $entityManager->getRepository(User::class)->findOneBy(['user_id' => $user_id]);
        $update_user = $this->userRepository->getUser($user_id);
        
        $array_roles = ['ROLE_SUPERADMIN', 'ROLE_ADMIN', 'ROLE_USER'];
        if(!in_array($userUpdateRequest->getRoles(),$array_roles)){
            throw new RoleUserNotExistsException();
        }

        $role = [$userUpdateRequest->getRoles()];
        $update_user -> setFirstName($userUpdateRequest->getFirstName());
        $update_user -> setRoles($role);
        $update_user -> setUpdatedAt(new \DateTime());
        $update_user -> setEmail($userUpdateRequest->getEmail());

        if(null !== $userUpdateRequest->getRoles()){
            $update_user->setPassword($this->hasher->hashPassword($update_user, $userUpdateRequest->getPassword()));
        }
        $this->em->persist($update_user);
        $this->em->flush();
        $user = $this->userRepository->getByUser($user_id);
       
        $items = array_map(
            fn (User $user) => new UserUpdateModel(
                $user->getId(), $user->getFirstName(), $user->getReferralLink(),$user->getEmail(),$user->getRoles(),$user->getUserId(),$user->getPesonalCode(),$user->getSecretCode(),
            ),
            $user
        );

        return new UserUpdateListResponse($items);
    }
}
