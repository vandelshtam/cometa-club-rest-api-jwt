<?php

namespace App\Model;

class PakagesCategory
{
    private int $id;

    private string $name;

    private string $price_pakage;

    private string $description;

    public function __construct(int $id, string $name, string $price_pakage, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price_pakage = $price_pakage;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPricePakage(): string
    {
        return $this->price_pakage;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
