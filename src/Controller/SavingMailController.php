<?php

namespace App\Controller;

use DateTime;
use App\Model\ErrorResponse;
use App\Attribute\RequestBody;
use OpenApi\Annotations as OA;
use App\Model\SavingMailReviewPage;
use App\Service\SavingMailReviewService;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\SavingMailRequest;
use App\Model\SavingMailRewiewListResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SavingMailController extends AbstractController
{
    public function __construct(private SavingMailReviewService $savingMailReviewService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given saving mail",
     *     @Model(type=SavingMailReviewPage::class)
     * )
     * @OA\Response(
     *     response="404",
     *     description="There is no record for the entered user",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/saving/mail/{id}/rewiew', methods: ['GET'])]
    public function rewiew(int $id, Request $request): Response
    {
        return $this->json($this->savingMailReviewService->getReviewPageByUserId(
            $id, $request->query->get('page', 1)
        ));
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given saving mail",
     *     @Model(type=SavingMailReviewPage::class)
     * )
     * @OA\Response(
     *     response="404",
     *     description="Error, requested data not found",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SavingMailRequest::class))
     */
    #[Route(path: '/api/v1/saving/mail/rewiew/email', methods: ['POST'])]
    public function rewiewToMail(#[RequestBody] SavingMailRequest $savingMailRequest, Request $request): Response
    {
        return $this->json($this->savingMailReviewService->getReviewPageByToMail(
             $request->query->get('page', 1),$savingMailRequest
        ));
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Parameter(name="category", in="query", description="Email subject category", required=true, @OA\Schema(type="string"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given saving mail",
     *     @Model(type=SavingMailReviewPage::class)
     * )
     * @OA\Response(
     *     response="404",
     *     description="Error, requested data not found",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/saving/mail/rewiew/category', methods: ['GET'])]
    public function rewiewCategory(Request $request): Response
    {
        return $this->json($this->savingMailReviewService->getReviewPageByCategory(
            $request->query->get('category'),$request->query->get('page', 1)
        ));
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Parameter(name="date", in="query", description="Enter the date in the format yyyy-mm-dd", required=true, @OA\Schema(type="string"))
     * @OA\Response(
     *     response=200,
     *     description="Returns dates less than the entered date and newer",
     *     @Model(type=SavingMailReviewPage::class)
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
    #[Route(path: '/api/v1/saving/mail/rewiew/date', methods: ['POST'])]
    public function rewiewDate( Request $request): Response
    {
        return $this->json($this->savingMailReviewService->getReviewPageByDate(
            $request->query->get('date'), $request->query->get('page', 1)
        ));
    }

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
     *     description="Returns all posts with pagination",
     *     @Model(type=SavingMailReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/saving/mail/rewiew/all/page', methods: ['GET'])]
    public function rewiewPage(Request $request): Response
    {
        return $this->json($this->savingMailReviewService->getReviewPageBy(
            $request->query->get('page', 1)
        ));
    }

}
