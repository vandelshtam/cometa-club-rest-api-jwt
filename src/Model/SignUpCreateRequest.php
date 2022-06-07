<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignUpCreateRequest
{
    #[NotBlank]
    private string $firstName;

    #[Email]
    #[NotBlank]
    private string $email;

    #[NotBlank]
    private string $referralLink;

    #[NotBlank]
    private string $roles;

    #[NotBlank]
    private string $userId;


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getReferralLink(): string
    {
        return $this->referralLink;
    }

    public function setReferralLink(string $referralLink): self
    {
        $this->referralLink = $referralLink;

        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getRoles(): string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
