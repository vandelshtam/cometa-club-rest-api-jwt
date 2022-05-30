<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;

class TablePakageRequest
{
    #[NotBlank]
    private string $name;

    #[NotBlank]
    private int $pricePakage;

    #[NotBlank]
    private string $description;

     private string $created_at;

     private string $updated_at;


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPricePakage(): int
    {
        return $this->pricePakage;
    }

    public function setPricePakage(int $pricePakage): self
    {
        $this->pricePakage = $pricePakage;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
