<?php

namespace App\Controller;

use DateTime;
use App\Model\WalletReview;
use App\Model\ErrorResponse;
use App\Model\PakegeRequest;
use App\Model\WalletRequest;
use App\Attribute\RequestBody;
use App\Service\PakegeService;
use App\Service\WalletService;
use OpenApi\Annotations as OA;
use App\Model\WalletReviewPage;
use App\Model\PakegeUserRequest;
use App\Model\WalletAllListResponse;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\SavingMailRewiewListResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminWalletController extends AbstractController
{
    public function __construct(private WalletService $walletService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Parameter(name="wallet_id", in="query", description="Page number",required=true, @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns wallet user",
     *     @Model(type=WalletReview::class)
     * )
     * @OA\Response(
     *     response="404",
     *     description="Error not found",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/admin/wallet/user', methods: ['GET'])]
    public function rewiewWalletUser( Request $request): Response
    {
        return $this->json($this->walletService->walletReviewUser(
            $request->query->get('wallet_id')
        ));
    }

    /**
     * @OA\Parameter(name="user_id", in="query", description="Page number",required=true, @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns wallet user_id",
     *     @Model(type=WalletReview::class)
     * )
     * @OA\Response(
     *     response="404",
     *     description="Error not found",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/admin/wallet/user_id', methods: ['GET'])]
    public function rewiewWalletUserId( Request $request): Response
    {
        return $this->json($this->walletService->walletReviewUserId(
            $request->query->get('user_id')
        ));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Rewiew all wallet users",
     *     @Model(type=WalletAllListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/admin/wallet/all', methods: ['GET'])]
    public function rewiewAll(): Response
    {
        return $this->json($this->walletService->walletAll());
    }


    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns all wallet users with pagination",
     *     @Model(type=WalletReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/admin/wallet/all/page', methods: ['GET'])]
    public function walletAllPage(Request $request): Response
    {
        return $this->json($this->walletService->getReviewPageBy(
            $request->query->get('page', 1)
        ));
    }

}
