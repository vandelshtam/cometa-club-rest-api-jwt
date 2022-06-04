<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class PakegeRequest
{
    #[NotBlank]
    private int $user_id;

    #[NotBlank]
    private int $pakage_id;

    #[Email]
    private string $email;

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

    public function getPakageId(): int
    {
        return $this->pakage_id;
    }

    public function setPakageId(int $pakage_id): self
    {
        $this->pakage_id = $pakage_id;

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
