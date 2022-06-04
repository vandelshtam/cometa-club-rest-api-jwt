<?php

namespace App\Model;


use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class WalletRequest
{
    #[NotBlank]
    private int $user_id;

    #[NotBlank]
    private float $summ;

    #[NotBlank]
    private string $type;

    #[NotBlank]
    #[Email]
    private string $email;

    #[NotBlank]
    private string $referral_link;


    
    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSumm(): float
    {
        return $this->summ;
    }

    public function setSumm(float $summ): self
    {
        $this->summ = $summ;

        return $this;
    }


    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
        return $this->referral_link;
    }

    public function setReferralLink(string $referral_link): self
    {
        $this->referral_link = $referral_link;

        return $this;
    }
}
