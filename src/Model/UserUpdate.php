<?php

namespace App\Model;

class UserUpdate
{
    private int $id;

    private string $firstName;

    private string $referral_link;

    private string $email;

    private array $roles;

    private int $user_id;

    private string $pesonal_code;

    private string $secret_code;

    public function __construct(int $id, string $firstName, string $referral_link, string $email,array $roles, int $user_id, string $pesonal_code, string $secret_code)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->referral_link = $referral_link;
        $this->email = $email;
        $this->roles = $roles;
        $this->user_id = $user_id;
        $this->pesonal_code = $pesonal_code;
        $this->secret_code = $secret_code;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getReferralLink(): string
    {
        return $this->referral_link;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getPesonalCode(): string
    {
        return $this->pesonal_code;
    }

    public function getSecretCode(): string
    {
        return $this->secret_code;
    }

}
