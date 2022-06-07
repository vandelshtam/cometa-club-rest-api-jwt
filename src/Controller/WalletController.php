<?php

namespace App\Controller;

use DateTime;
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

class WalletController extends AbstractController
{
    public function __construct(private WalletService $walletService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Wallet replenishment",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="user_id", type="integer"),
     *         @OA\Property(property="usdt", type="float"),
     *         @OA\Property(property="token", type="float"),
     *         @OA\Property(property="cometa", type="float"),
     *         @OA\Property(property="etherium", type="float"),
     *         @OA\Property(property="bitcoin", type="float"),
     *         @OA\Property(property="last_add_summ", type="float"),
     *     )
     * )
     * @OA\Response(
     *     response="404",
     *     description="Errors",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=WalletRequest::class))
     */
    #[Route(path: '/api/v1/wallet/add', methods: ['POST'])]
    public function walletCreate(#[RequestBody] WalletRequest $walletRequest,ManagerRegistry $doctrine,UserInterface $user): Response
    {
        $current_user = $user;
        return $this->json($this->walletService->walletAdd($walletRequest,$doctrine,$current_user));
       
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Return balance wallet user",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="user_id", type="integer"),
     *         @OA\Property(property="usdt", type="float"),
     *         @OA\Property(property="token", type="float"),
     *         @OA\Property(property="cometa", type="float"),
     *         @OA\Property(property="etherium", type="float"),
     *         @OA\Property(property="bitcoin", type="float"),
     *     )
     * )
     * @OA\Response(
     *     response="404",
     *     description="Errors",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/wallet/user', methods: ['GET'])]
    public function walletReview(UserInterface $user): Response
    {
        $current_user = $user;
        return $this->json($this->walletService->wallet($current_user));
    }

    // // /**
    // //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    // //  * @OA\Response(
    // //  *     response=200,
    // //  *     description="Returns balance wallet",
    // //  *     @Model(type=SavingMailReviewPage::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="404",
    // //  *     description="There is no record for the entered user",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="400",
    // //  *     description="Validation failed",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  */
    // // #[Route(path: '/api/v1/saving/mail/{id}/rewiew', methods: ['GET'])]
    // // public function rewiew(int $id, Request $request): Response
    // // {
    // //     return $this->json($this->savingMailReviewService->getReviewPageByUserId(
    // //         $id, $request->query->get('page', 1)
    // //     ));
    // // }

    // // /**
    // //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    // //  * @OA\Response(
    // //  *     response=200,
    // //  *     description="Returns page of reviews for the given saving mail",
    // //  *     @Model(type=SavingMailReviewPage::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="404",
    // //  *     description="Error, requested data not found",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="400",
    // //  *     description="Validation failed",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  * @OA\RequestBody(@Model(type=SavingMailRequest::class))
    // //  */
    // // #[Route(path: '/api/v1/saving/mail/rewiew/email', methods: ['POST'])]
    // // public function rewiewToMail(#[RequestBody] SavingMailRequest $savingMailRequest, Request $request): Response
    // // {
    // //     return $this->json($this->savingMailReviewService->getReviewPageByToMail(
    // //          $request->query->get('page', 1),$savingMailRequest
    // //     ));
    // // }

    // // /**
    // //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    // //  * @OA\Parameter(name="category", in="query", description="Email subject category", required=true, @OA\Schema(type="string"))
    // //  * @OA\Response(
    // //  *     response=200,
    // //  *     description="Returns page of reviews for the given saving mail",
    // //  *     @Model(type=SavingMailReviewPage::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="404",
    // //  *     description="Error, requested data not found",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="400",
    // //  *     description="Validation failed",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  */
    // // #[Route(path: '/api/v1/saving/mail/rewiew/category', methods: ['GET'])]
    // // public function rewiewCategory(Request $request): Response
    // // {
    // //     return $this->json($this->savingMailReviewService->getReviewPageByCategory(
    // //         $request->query->get('category'),$request->query->get('page', 1)
    // //     ));
    // // }

    // // /**
    // //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    // //  * @OA\Parameter(name="date", in="query", description="Enter the date in the format yyyy-mm-dd", required=true, @OA\Schema(type="string"))
    // //  * @OA\Response(
    // //  *     response=200,
    // //  *     description="Returns dates less than the entered date and newer",
    // //  *     @Model(type=SavingMailReviewPage::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="404",
    // //  *     description="Error not found",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  * @OA\Response(
    // //  *     response="400",
    // //  *     description="Validation failed",
    // //  *     @Model(type=ErrorResponse::class)
    // //  * )
    // //  */
    // // #[Route(path: '/api/v1/saving/mail/rewiew/date', methods: ['POST'])]
    // // public function rewiewDate( Request $request): Response
    // // {
    // //     return $this->json($this->savingMailReviewService->getReviewPageByDate(
    // //         $request->query->get('date'), $request->query->get('page', 1)
    // //     ));
    // // }


    // /**
    //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    //  * @OA\Response(
    //  *     response=200,
    //  *     description="Returns all wallet users with pagination",
    //  *     @Model(type=WalletReviewPage::class)
    //  * )
    //  */
    // #[Route(path: '/api/v1/wallet/all/page', methods: ['GET'])]
    // public function walletAllPage(Request $request): Response
    // {
    //     return $this->json($this->walletService->getReviewPageBy(
    //         $request->query->get('page', 1)
    //     ));
    // }

}
