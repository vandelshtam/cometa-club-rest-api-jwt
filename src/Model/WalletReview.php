<?php

namespace App\Model;

class WalletReview
{
    private int $id;

    private int $userId;

    private float $usdt;

    private float $cometapoin;

    private float $bitcoin;

    private float $etherium;

    private int $createdAt;

    private int $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

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

    public function getUsdt(): float
    {
        return $this->usdt;
    }

    public function setUsdt(float $usdt): self
    {
        $this->usdt = $usdt;

        return $this;
    }

    public function getCometapoin(): float
    {
        return $this->cometapoin;
    }

    public function setCometapoin(float $cometapoin): self
    {
        $this->cometapoin = $cometapoin;

        return $this;
    }

    public function getBitcoin(): float
    {
        return $this->bitcoin;
    }

    public function setBitcoin(float $bitcoin): self
    {
        $this->bitcoin = $bitcoin;

        return $this;
    }

    public function getEtherium(): float
    {
        return $this->etherium;
    }

    public function setEtherium(float $etherium): self
    {
        $this->etherium = $etherium;

        return $this;
    }

    // public function getReferralLink(): string
    // {
    //     return $this->referral_link;
    // }

    // public function setReferralLink(string $referral_link): self
    // {
    //     $this->referral_link = $referral_link;

    //     return $this;
    // }

    // public function getActivation(): string
    // {
    //     return $this->activation;
    // }

    // public function setActivation(string $activation): self
    // {
    //     $this->activation = $activation;

    //     return $this;
    // }

    // public function getAction(): string
    // {
    //     return $this->action;
    // }

    // public function setAction(string $action): self
    // {
    //     $this->action = $action;

    //     return $this;
    // }


    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(int $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
