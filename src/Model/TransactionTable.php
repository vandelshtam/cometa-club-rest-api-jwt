<?php

namespace App\Model;

use DateTimeInterface;

class TransactionTable
{
    private int $id;

    private int $networkId;

    private int $userId;

    private int $pakageId;

    private float $cash;

    private float $direct;

    private float $withdrawalToWallet;

    private float $withdrawal;

    private float $applicationWithdrawal;

    private int $applicationWithdrawalStatus;

    private int $networkActivationId;

    private string $type;

    private int $pakagePrice;

    private int $walletId;

    private float $somme;

    private string $token;

    private ?\DateTimeInterface $createdAt;

    private ?\DateTimeInterface $updatedAt;


    public function __construct(int $id,int $networkId,int $userId,int $pakageId,float $cash,float $direct,
                                float $withdrawalToWallet,float $withdrawal,float $applicationWithdrawal,int $applicationWithdrawalStatus,
                                int $networkActivationId,int $type,int $pakagePrice,int $walletId,float $somme,
                                string $token, ?\DateTimeInterface $createdAt, ?\DateTimeInterface $updatedAt)
    {
        $this->id = $id;
        $this->networkId = $networkId;
        $this->userId = $userId;
        $this->pakageId = $pakageId;
        $this->cash =$cash;
        $this->direct = $direct;
        $this->withdrawalToWallet =$withdrawalToWallet;
        $this->withdrawal = $withdrawal;
        $this->applicationWithdrawal = $applicationWithdrawal;
        $this->applicationWithdrawalStatus = $applicationWithdrawalStatus;
        $this->networkActivationId = $networkActivationId;
        $this->type = $type;
        $this->pakagePrice =$pakagePrice;
        $this->walletId = $walletId;
        $this->somme = $somme;
        $this->token = $token;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNetworkId(): int
    {
        return $this->networkId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPakageId(): int
    {
        return $this->pakageId;
    }

    public function getCash(): float
    {
        return $this->cash;
    }

    public function getDirect(): float
    {
        return $this->direct;
    }

    public function getWithdrawalToWallet(): float
    {
        return $this->withdrawalToWallet;
    }

    public function getWithdrawal(): float
    {
        return $this->withdrawal;
    }

    public function getApplicationWithdrawal(): float
    {
        return $this->applicationWithdrawal;
    }

    public function getApplicationWithdrawalStatus(): int
    {
        return $this->applicationWithdrawalStatus;
    }

    public function getNetworkActivationId(): int
    {
        return $this->networkActivationId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPakagePrice(): int
    {
        return $this->pakagePrice;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getSomme(): float
    {
        return $this->somme;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

}
