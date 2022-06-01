<?php

namespace App\Model;

class TransactionTableReview
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

    private int $type;

    private int $pakagePrice;

    private int $walletId;

    private float $somme;

    private string $token;

    private int $createdAt;

    //private ?\DateTimeInterface $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNetworkId(): float
    {
        return $this->networkId;
    }

    public function setNetworkId(float $networkId): self
    {
        $this->networkId = $networkId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPakageId(): int
    {
        return $this->pakageId;
    }

    public function setPakageId(int $pakageId): self
    {
        $this->pakageId = $pakageId;

        return $this;
    }

    public function getCash(): int
    {
        return $this->cash;
    }

    public function setCash(int $cash): self
    {
        $this->cash = $cash;

        return $this;
    }

    public function getDirect(): float
    {
        return $this->direct;
    }

    public function setDirect(float $direct): self
    {
        $this->direct = $direct;

        return $this;
    }

    public function getWithdrawalToWallet(): int
    {
        return $this->withdrawalToWallet;
    }

    public function setWithdrawalToWallet(int $withdrawalToWallet): self
    {
        $this->withdrawalToWallet = $withdrawalToWallet;

        return $this;
    }

    public function getWithdrawal(): int
    {
        return $this->withdrawal;
    }

    public function setWithdrawal(int $withdrawal): self
    {
        $this->withdrawal = $withdrawal;

        return $this;
    }

    public function getApplicationWithdrawal(): int
    {
        return $this->applicationWithdrawal;
    }

    public function setApplicationWithdrawal(int $applicationWithdrawal): self
    {
        $this->applicationWithdrawal = $applicationWithdrawal;

        return $this;
    }

    public function getApplicationWithdrawalStatus(): float
    {
        return $this->applicationWithdrawalStatus;
    }

    public function setApplicationWithdrawalStatus(float $applicationWithdrawalStatus): self
    {
        $this->applicationWithdrawalStatus = $applicationWithdrawalStatus;

        return $this;
    }

    public function getNetworkActivationId(): int
    {
        return $this->networkActivationId;
    }

    public function setNetworkActivationId(int $networkActivationId): self
    {
        $this->networkActivationId = $networkActivationId;

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPakagePrice(): int
    {
        return $this->pakagePrice;
    }

    public function setPakagePrice(int $pakagePrice): self
    {
        $this->pakagePrice = $pakagePrice;

        return $this;
    }

    public function getWalletId(): float
    {
        return $this->walletId;
    }

    public function setWalletId(float $walletId): self
    {
        $this->walletId = $walletId;

        return $this;
    }

    public function getSomme(): int
    {
        return $this->somme;
    }

    public function setSomme(int $somme): self
    {
        $this->somme = $somme;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
