<?php

namespace App\Model;

class TokenRate
{
    private int $id;

    private string $exchangeRate;


    public function __construct(int $id, string $exchangeRate)
    {
        $this->id = $id;
        $this->exchangeRate = $exchangeRate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExchangeRate(): string
    {
        return $this->exchangeRate;
    }

}
