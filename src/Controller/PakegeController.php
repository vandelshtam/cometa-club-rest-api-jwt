<?php

namespace App\Controller;

use DateTime;
use App\Model\ErrorResponse;
use App\Model\PakegeRequest;
use App\Attribute\RequestBody;
use App\Service\PakegeService;
use OpenApi\Annotations as OA;
use App\Model\PakegeReviewPage;
use App\Model\PakegeUserRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\SavingMailRewiewListResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PakegeController extends AbstractController
{
    public function __construct(private PakegeService $pakegeService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="New up a pakege",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="user_id", type="integer"),
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="referral_link", type="string"),
     *         @OA\Property(property="price", type="integer"),
     *         @OA\Property(property="token", type="integer"),
     *         @OA\Property(property="referral_networks_id", type="string"),
     *         @OA\Property(property="client_code", type="string"),
     *         @OA\Property(property="action", type="string"),
     *         @OA\Property(property="created_at", type="string")
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
     * @OA\RequestBody(@Model(type=PakegeRequest::class))
     */
    #[Route(path: '/api/v1/pakege/new', methods: ['POST'])]
    public function new(#[RequestBody] PakegeRequest $pakegeRequest,ManagerRegistry $doctrine,UserInterface $user): Response
    {
        $current_user = $user;
        return $this->json($this->pakegeService->pakegeNew($pakegeRequest,$doctrine,$current_user));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Review user pakeges",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="user_id", type="integer"),
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="referral_link", type="string"),
     *         @OA\Property(property="price", type="integer"),
     *         @OA\Property(property="token", type="integer"),
     *         @OA\Property(property="referral_networks_id", type="string"),
     *         @OA\Property(property="client_code", type="string"),
     *         @OA\Property(property="action", type="string"),
     *         @OA\Property(property="created_at", type="string")
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
     * @OA\RequestBody(@Model(type=PakegeUserRequest::class))
     */
    #[Route(path: '/api/v1/pakege/user', methods: ['POST'])]
    public function pakegesUser(#[RequestBody] PakegeUserRequest $pakegeUserRequest,UserInterface $user): Response
    {
        $current_user = $user;
        return $this->json($this->pakegeService->pakegesUser($pakegeUserRequest,$current_user));
    }

    // /**
    //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    //  * @OA\Response(
    //  *     response=200,
    //  *     description="Returns page of reviews for the given saving mail",
    //  *     @Model(type=SavingMailReviewPage::class)
    //  * )
    //  * @OA\Response(
    //  *     response="404",
    //  *     description="There is no record for the entered user",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  * @OA\Response(
    //  *     response="400",
    //  *     description="Validation failed",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  */
    // #[Route(path: '/api/v1/saving/mail/{id}/rewiew', methods: ['GET'])]
    // public function rewiew(int $id, Request $request): Response
    // {
    //     return $this->json($this->savingMailReviewService->getReviewPageByUserId(
    //         $id, $request->query->get('page', 1)
    //     ));
    // }

    // /**
    //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    //  * @OA\Response(
    //  *     response=200,
    //  *     description="Returns page of reviews for the given saving mail",
    //  *     @Model(type=SavingMailReviewPage::class)
    //  * )
    //  * @OA\Response(
    //  *     response="404",
    //  *     description="Error, requested data not found",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  * @OA\Response(
    //  *     response="400",
    //  *     description="Validation failed",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  * @OA\RequestBody(@Model(type=SavingMailRequest::class))
    //  */
    // #[Route(path: '/api/v1/saving/mail/rewiew/email', methods: ['POST'])]
    // public function rewiewToMail(#[RequestBody] SavingMailRequest $savingMailRequest, Request $request): Response
    // {
    //     return $this->json($this->savingMailReviewService->getReviewPageByToMail(
    //          $request->query->get('page', 1),$savingMailRequest
    //     ));
    // }

    // /**
    //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    //  * @OA\Parameter(name="category", in="query", description="Email subject category", required=true, @OA\Schema(type="string"))
    //  * @OA\Response(
    //  *     response=200,
    //  *     description="Returns page of reviews for the given saving mail",
    //  *     @Model(type=SavingMailReviewPage::class)
    //  * )
    //  * @OA\Response(
    //  *     response="404",
    //  *     description="Error, requested data not found",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  * @OA\Response(
    //  *     response="400",
    //  *     description="Validation failed",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  */
    // #[Route(path: '/api/v1/saving/mail/rewiew/category', methods: ['GET'])]
    // public function rewiewCategory(Request $request): Response
    // {
    //     return $this->json($this->savingMailReviewService->getReviewPageByCategory(
    //         $request->query->get('category'),$request->query->get('page', 1)
    //     ));
    // }

    // /**
    //  * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
    //  * @OA\Parameter(name="date", in="query", description="Enter the date in the format yyyy-mm-dd", required=true, @OA\Schema(type="string"))
    //  * @OA\Response(
    //  *     response=200,
    //  *     description="Returns dates less than the entered date and newer",
    //  *     @Model(type=SavingMailReviewPage::class)
    //  * )
    //  * @OA\Response(
    //  *     response="404",
    //  *     description="Error not found",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  * @OA\Response(
    //  *     response="400",
    //  *     description="Validation failed",
    //  *     @Model(type=ErrorResponse::class)
    //  * )
    //  */
    // #[Route(path: '/api/v1/saving/mail/rewiew/date', methods: ['POST'])]
    // public function rewiewDate( Request $request): Response
    // {
    //     return $this->json($this->savingMailReviewService->getReviewPageByDate(
    //         $request->query->get('date'), $request->query->get('page', 1)
    //     ));
    // }

    // /**
    //  * @OA\Response(
    //  *     response=200,
    //  *     description="Rewiew all transaction table",
    //  *     @Model(type=TransactionTableRewiewListResponse::class)
    //  * )
    //  */
    // #[Route(path: '/api/v1/transaction/table/rewiew/all', methods: ['GET'])]
    // public function rewiewAll(): Response
    // {
    //     return $this->json($this->transactionTableService->rewiew());
    // }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns all pakages users with pagination",
     *     @Model(type=PakegeReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/admin/pakege/all/page', methods: ['GET'])]
    public function rewiewPage(Request $request): Response
    {
        return $this->json($this->pakegeService->getReviewPageBy(
            $request->query->get('page', 1)
        ));
    }

}
