<?php

namespace App\Controller;

use App\Service\PakagesCategoryService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\PakageAllListResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TablePakagesAllController extends AbstractController
{
    public function __construct(private PakagesCategoryService $pakagesCategoryService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns pakages",
     *     @Model(type=PakageAllListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/pakages/all', methods: ['GET'])]
    public function pakages(): Response
    {
        return $this->json($this->pakagesCategoryService->getPakages());
    }

    #[Route(path: '/api/v1/user/me', methods: ['GET'])]
    public function me(#[CurrentUser] UserInterface $user): Response
    {
        return $this->json($user);
    }
}
