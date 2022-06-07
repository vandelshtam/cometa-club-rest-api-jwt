<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Shared\Domain\Security\AuthUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserService extends AbstractController
{
    private $jwtEncoder;
    private $em;
    
    public function __construct(JWTEncoderInterface $jwtEncoder, EntityManagerInterface $em,Security $security)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->em = $em;
        $this->security = $security;
        
    }
    // public function getUser($credentials)
    // {
    //     $data = $this->jwtEncoder->decode($credentials);
    //     $id = $data['id'];
    //     return $this->em
    //         ->getRepository('AppBundle:User')
    //         ->findOneBy(['id' => $id]);
    // }

    public function getAuthUser()
    {
        /** @var AuthUserInterface $user */
        $user = $this->security->getUser();

        //Assert::notNull($user, 'Current user not found check security access list');
        //Assert::isInstanceOf($user, AuthUserInterface::class, sprintf('Invalid user type %s', \get_class($user)));

        dd($user);
    }

    public function index()
    {
        return $this->user;
    }
}