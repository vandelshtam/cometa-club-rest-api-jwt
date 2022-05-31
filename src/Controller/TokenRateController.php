<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Attribute\RequestBody;
use OpenApi\Annotations as OA;
use App\Model\TokenRateRequest;
use App\Service\TokenRateService;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\TokenRateRewiewListResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TokenRateController extends AbstractController
{
    public function __construct(private TokenRateService $tokenRateService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="New token rate",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string"),
     *         @OA\Property(property="exanchge_rate", type="string"),
     *         @OA\Property(property="updated_at", type="string"),
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="Failed to create new record, only one token rate record can be created",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=TokenRateRequest::class))
     */
    #[Route(path:'/api/v1/token/rate/new', name: 'app_token_rate_new', methods:['POST'])]
    public function new(#[RequestBody] TokenRateRequest $tokenRateRequest): Response
    {
        return $this->json($this->tokenRateService->new($tokenRateRequest));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="New token rate",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string"),
     *         @OA\Property(property="exanchge_rate", type="string"),
     *         @OA\Property(property="updated_at", type="string"),
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="Failed to create new record, only one token rate record can be created",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=TokenRateRequest::class))
     */
    #[Route(path:'/api/v1/token/rate/update', name: 'app_token_rate_update', methods:['POST'])]
    public function update(#[RequestBody] TokenRateRequest $tokenRateRequest,EntityManagerInterface $entityManager): Response
    {
        return $this->json($this->tokenRateService->update($entityManager,$tokenRateRequest));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Rewiew token rate",
     *     @Model(type=TokenRateRewiewListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/token/rate/rewiew', methods: ['GET'])]
    public function rewiew(): Response
    {
        return $this->json($this->tokenRateService->rewiew());
    }

}
