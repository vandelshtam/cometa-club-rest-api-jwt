<?php

namespace App\Controller;

use DateTime;
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
     *     description="Returns page of reviews for the given date",
     *     @Model(type=TransactionTableReviewPage::class)
     * )
     */
    #[Route(path: '/api/v1/transaction/table/{date}/rewiew/date', methods: ['GET'])]
    public function rewiewDate(string $date, Request $request): Response
    {
        // $date_time = new DateTime('2022-05-30');
        // dd($date_time);
        return $this->json($this->transactionTableReviewService->getReviewPageByDate(
            $date, $request->query->get('page', 1)
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
