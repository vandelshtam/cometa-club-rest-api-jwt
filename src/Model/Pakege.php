<?php

namespace App\Model;

class Pakege
{
    private int $id;

    private int $user_id;

    private string $name;

    private int $price;

    private int $token;

    private string $client_code;

    private string $referral_link;

    private int $activation;

    private int $action;

    private ?\DateTimeInterface $createdAt;

    private ?\DateTimeInterface $updatedAt;

    public function __construct(int $id, int $user_id, string $name, int $price, int $token,
                                string $client_code, string $referral_link, int $activation, int $action, ?\DateTimeInterface $createdAt,?\DateTimeInterface $updatedAt)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->price = $price;
        $this->token = $token;
        $this->client_code = $client_code;
        $this->referral_link = $referral_link;
        $this->activation = $activation;
        $this->action = $action;
        $this->createdAt = $createdAt;
        $this->createdAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getToken(): int
    {
        return $this->token;
    }

    public function getClientCode(): string
    {
        return $this->client_code;
    }

    public function getReferralLink(): string
    {
        return $this->referral_link;
    }

    public function getActivation(): int
    {
        return $this->activation;
    }

    public function getAction(): int
    {
        return $this->action;
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
