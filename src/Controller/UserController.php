<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Attribute\RequestBody;
use OpenApi\Annotations as OA;
use App\Model\UserUpdateRequest;
use App\Service\UserUpdateService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function __construct(private UserUpdateService $userUpdateService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Update a user",
     *     @OA\JsonContent(
     *         @OA\Property(property="firstName", type="string"),
     *         @OA\Property(property="lastName", type="string"),
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="roles", type="string"),
     *         @OA\Property(property="password", type="string"),
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
     * @OA\RequestBody(@Model(type=UserUpdateRequest::class))
     */
    #[Route(path: '/api/v1/user/update', methods: ['POST'])]
    public function userUpdate(#[RequestBody] UserUpdateRequest $userUpdateRequest, Request $request,EntityManagerInterface $entityManager,): Response
    {
        $data = $request->query;
        $id = $data->get('id');
        return $this->json($this->userUpdateService->userUpdate($entityManager,$userUpdateRequest,$id));
    }
}
