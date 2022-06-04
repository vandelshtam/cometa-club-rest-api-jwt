<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Shared\Domain\Security\AuthUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class GetMeController extends AbstractController
{
    #[Route(path: '/api/v1/get/me', methods: ['POST'])]
    public function getAuthUser(#[CurrentUser] UserInterface $user): Response
    {
        // /** @var AuthUserInterface $user */
        // $user = $this->security->getUser();

        //Assert::notNull($user, 'Current user not found check security access list');
        //Assert::isInstanceOf($user, AuthUserInterface::class, sprintf('Invalid user type %s', \get_class($user)));

        return $this->json($user);
    }
}
