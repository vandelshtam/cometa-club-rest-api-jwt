<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;

class TokenRateRequest
{
    #[NotBlank]
    private string $exchange_rate;

    private string $created_at;

    private string $updated_at;


    public function getExchangeRate(): string
    {
        return $this->exchange_rate;
    }

    public function setExchangeRate(string $exchange_rate): self
    {
        $this->exchange_rate = $exchange_rate;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
