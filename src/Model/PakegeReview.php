<?php

namespace App\Model;

class PakegeReview
{
    private int $id;

    private int $userId;

    private string $name;

    private string $price;

    private string $token;

    private string $client_code;

    private string $referral_link;

    private string $activation;

    private string $action;

    private int $createdAt;

    

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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

    public function getClientCode(): string
    {
        return $this->client_code;
    }

    public function setClientCode(string $client_code): self
    {
        $this->client_code = $client_code;

        return $this;
    }

    public function getReferralLink(): string
    {
        return $this->referral_link;
    }

    public function setReferralLink(string $referral_link): self
    {
        $this->referral_link = $referral_link;

        return $this;
    }

    public function getActivation(): string
    {
        return $this->activation;
    }

    public function setActivation(string $activation): self
    {
        $this->activation = $activation;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

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
