<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Attribute\RequestBody;
use OpenApi\Annotations as OA;
use App\Model\SettingOptionsRequest;
use App\Service\SettingOptionsService;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\HttpFoundation\Response;
use App\Model\SettingOptionsRewiewListResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTimeValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingOptionsController extends AbstractController
{
    public function __construct(private SettingOptionsService $settingOptionsService,private EntityManagerInterface $em,)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="New setting options",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string"),
     *         @OA\Property(property="payments_singleline", type="string"),
     *         @OA\Property(property="payments_direct", type="string"),
     *         @OA\Property(property="cash_back", type="string"),
     *         @OA\Property(property="all_price_pakage", type="string"),
     *         @OA\Property(property="accrual_limit", type="string"),
     *         @OA\Property(property="system_revenues", type="string"),
     *         @OA\Property(property="update_day", type="string"),
     *         @OA\Property(property="limit_wallet_from_line", type="string"),
     *         @OA\Property(property="payments_direct_fast", type="string"),
     *         @OA\Property(property="multi_pakage_day", type="string"),
     *         @OA\Property(property="name_multi_pakage", type="string"),
     *         @OA\Property(property="start_day", type="string"),
     *         @OA\Property(property="privileget_mambers", type="string"),
     *         @OA\Property(property="fast_start", type="string"),
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="Failed to create new record, only one setting options record can be created",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SettingOptionsRequest::class))
     */
    #[Route('/api/v1/setting/options/new', name: 'app_setting_options', methods:['POST'])]
    public function new(#[RequestBody] SettingOptionsRequest $settingOptionsRequest): Response
    {
        return $this->json($this->settingOptionsService->new($settingOptionsRequest));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Rewiew setting options",
     *     @Model(type=SettingOptionsRewiewListResponse::class)
     * )
     */
    #[Route(path: '/api/v1/setting/options/rewiew', methods: ['GET'])]
    public function rewiew(): Response
    {
        return $this->json($this->settingOptionsService->rewiew());
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Updated setting options",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string"),
     *         @OA\Property(property="payments_singleline", type="string"),
     *         @OA\Property(property="payments_direct", type="string"),
     *         @OA\Property(property="cash_back", type="string"),
     *         @OA\Property(property="all_price_pakage", type="string"),
     *         @OA\Property(property="accrual_limit", type="string"),
     *         @OA\Property(property="system_revenues", type="string"),
     *         @OA\Property(property="update_day", type="string"),
     *         @OA\Property(property="limit_wallet_from_line", type="string"),
     *         @OA\Property(property="payments_direct_fast", type="string"),
     *         @OA\Property(property="multi_pakage_day", type="string"),
     *         @OA\Property(property="name_multi_pakage", type="string"),
     *         @OA\Property(property="start_day", type="string"),
     *         @OA\Property(property="privileget_mambers", type="string"),
     *         @OA\Property(property="fast_start", type="string"),
     *     )
     * )
     * @OA\Response(
     *     response="409",
     *     description="Failed to create new record, only one setting options record can be created",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\Response(
     *     response="400",
     *     description="Validation failed",
     *     @Model(type=ErrorResponse::class)
     * )
     * @OA\RequestBody(@Model(type=SettingOptionsRequest::class))
     */
    #[Route('/api/v1/setting/options/update', name: 'app_setting_options_update', methods:['POST'])]
    public function update(#[RequestBody] SettingOptionsRequest $settingOptionsRequest,EntityManagerInterface $entityManager): Response
    {
        return $this->json($this->settingOptionsService->update($entityManager,$settingOptionsRequest));
    }

}
