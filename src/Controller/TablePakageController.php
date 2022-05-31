<?php

namespace App\Controller;


use App\Model\ErrorResponse;
use App\Attribute\RequestBody;
use OpenApi\Annotations as OA;
use App\Model\TablePakageRequest;
use App\Service\TablePakageService;
use App\Model\PakageAllListResponse;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TablePakageController extends AbstractController
{
    public function __construct(private TablePakageService $tablePakageService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="New up a table pakage",
     *     @OA\JsonContent(
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="table_pakage", type="string"),
     *         @OA\Property(property="description", type="string")
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="Pakage already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=TablePakageRequest::class))
     */
    #[Route(path: '/api/v1/table/pakage/new', methods: ['POST'])]
    public function new(#[RequestBody] TablePakageRequest $tablePakageRequest): Response
    {
        return $this->json($this->tablePakageService->pakageNew($tablePakageRequest));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Returns table pakages",
     *     @Model(type=PakageAllListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/table/pakage/all', methods: ['GET'])]
    public function all(): Response
    {
        return $this->json($this->tablePakageService->pakages());
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Updated a table pakage",
     *     @OA\JsonContent(
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="table_pakage", type="string"),
     *         @OA\Property(property="description", type="string")
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="Pakage already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=TablePakageRequest::class))
     */
    #[Route(path: '/api/v1/table/pakage/update/{table_pakage_id}', methods: ['POST'])]
    public function pakegeUpdate(#[RequestBody] TablePakageRequest $tablePakageRequest,EntityManagerInterface $entityManager, int $table_pakage_id): Response
    {
        return $this->json($this->tablePakageService->update($entityManager,$tablePakageRequest,$table_pakage_id));
    }
}
