<?php

namespace App\Model;

class Wallet
{
    private int $id;

    private int $user_id;

    private float $usdt;

    private float $bitcoin;

    private float $etherium;

    private float $cometapoin;

    private ?\DateTimeInterface $updatedAt;

    public function __construct(int $id, int $user_id, float $usdt, float $bitcoin, float $etherium,
                                float $cometapoin, ?\DateTimeInterface $updatedAt)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->usdt = $usdt;
        $this->bitcoin = $bitcoin;
        $this->etherium = $etherium;
        $this->cometapoin = $cometapoin;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getUsdt(): float
    {
        return $this->usdt;
    }

    public function getEtherium(): float
    {
        return $this->etherium;
    }

    public function getBitcoin(): float
    {
        return $this->bitcoin;
    }

    public function getCometapoin(): float
    {
        return $this->cometapoin;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
