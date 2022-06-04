<?php

namespace App\Model;

class SavingMailReview
{
    private int $id;

    private int $userId;

    private string $from_mail;

    private string $to_mail;

    private string $status;

    private string $text;

    private string $category;

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

    public function getFromMail(): string
    {
        return $this->from_mail;
    }

    public function setFromMail(string $from_mail): self
    {
        $this->from_mail = $from_mail;

        return $this;
    }

    public function getToMail(): string
    {
        return $this->to_mail;
    }

    public function setToMail(string $to_mail): self
    {
        $this->to_mail = $to_mail;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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
