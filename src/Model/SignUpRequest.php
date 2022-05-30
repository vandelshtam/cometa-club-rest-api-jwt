<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignUpRequest
{
    #[NotBlank]
    private string $firstName;

    //#[NotBlank]
    private string $lastName;

    #[Email]
    #[NotBlank]
    private string $email;

    #[NotBlank]
    private string $referral_link;

    #[NotBlank]
    private string $user_id;

    #[NotBlank]
    #[Length(min: 8)]
    private string $password;

    #[NotBlank]
    #[EqualTo(propertyPath: 'password', message: 'This value should be equal to password field')]
    private string $confirmPassword;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function setReferralLink(string $referral_link): self
    {
        $this->email = $referral_link;

        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $user_id): self
    {
        $this->userId = $user_id;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
