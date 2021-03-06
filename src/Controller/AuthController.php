<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Model\SignUpRequest;
use App\Attribute\RequestBody;
use App\Service\SignUpService;
use OpenApi\Annotations as OA;
use App\Model\SignUpCreateRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    public function __construct(private SignUpService $signUpService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Signs up a user",
     *     @OA\JsonContent(
     *         @OA\Property(property="token", type="string"),
     *         @OA\Property(property="refresh_token", type="string")
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="User already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SignUpRequest::class))
     */
    #[Route(path: '/api/v1/auth/signUp', methods: ['POST'])]
    public function signUp(#[RequestBody] SignUpRequest $signUpRequest): Response
    {
        return $this->signUpService->signUp($signUpRequest);
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Signs up a user create",
     *     @OA\JsonContent(
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="first_name", type="string"),
     *         @OA\Property(property="referral_link", type="string"),
     *         @OA\Property(property="personal_code", type="string")
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="User already exists",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SignUpCreateRequest::class))
     */
    #[Route(path: '/api/v1/auth/signUpCreate', methods: ['POST'])]
    public function signUpCreate(#[RequestBody] SignUpCreateRequest $signUpCreateRequest): Response
    {
        return $this->json($this->signUpService->signUserCreate($signUpCreateRequest));
    }
}
