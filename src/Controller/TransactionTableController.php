<?php

namespace App\Controller;

use DateTime;
use App\Model\ErrorResponse;
use OpenApi\Annotations as OA;
use App\Service\TransactionTableService;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\TransactionTableReviewPage;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use App\Service\TransactionTableReviewService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\TransactionTableRewiewListResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionTableController extends AbstractController
{
    public function __construct(private TransactionTableService $transactionTableService,private TransactionTableReviewService $transactionTableReviewService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given user",
     *     @Model(type=TransactionTableReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/transaction/table/{id}/rewiew', methods: ['GET'])]
    public function rewiew(int $id, Request $request): Response
    {
        return $this->json($this->transactionTableReviewService->getReviewPageByUserId(
            $id, $request->query->get('page', 1)
        ));
    }


    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given user",
     *     @Model(type=TransactionTableReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/transaction/table/{id}/rewiew/place', methods: ['GET'])]
    public function rewiewPlace(int $id, Request $request): Response
    {
        return $this->json($this->transactionTableReviewService->getReviewPageByUserPlace(
            $id, $request->query->get('page', 1)
        ));
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Parameter(name="date", in="query", description="Enter the date in the format yyyy-mm-dd", required=true, @OA\Schema(type="string"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given date",
     *     @Model(type=TransactionTableReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/transaction/table/rewiew/date', methods: ['POST'])]
    public function rewiewDate(Request $request): Response
    {
        return $this->json($this->transactionTableReviewService->getReviewPageByDate(
            $request->query->get('date'), $request->query->get('page', 1)
        ));
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Parameter(name="type", in="query", description="Enter the name of the operation without signs and symbols, use only one space between words", required=true, @OA\Schema(type="string"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given date",
     *     @Model(type=TransactionTableReviewPage::class)
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
    #[Route(path: '/api/v1/transaction/table/rewiew/type', methods: ['POST'])]
    public function rewiewType(Request $request): Response
    {
        return $this->json($this->transactionTableReviewService->getReviewPageByType(
            $request->query->get('type'), $request->query->get('page', 1)
        ));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Rewiew all transaction table",
     *     @Model(type=TransactionTableRewiewListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/transaction/table/rewiew/all', methods: ['GET'])]
    public function rewiewAll(): Response
    {
        return $this->json($this->transactionTableService->rewiew());
    }

    /**
     * @OA\Parameter(name="page", in="query", description="Page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="Returns page of reviews for the given user",
     *     @Model(type=TransactionTableReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/transaction/table/rewiew/page', methods: ['GET'])]
    public function rewiewPage(Request $request): Response
    {
        return $this->json($this->transactionTableService->getReviewPageBy(
            $request->query->get('page', 1)
        ));
    }

}
