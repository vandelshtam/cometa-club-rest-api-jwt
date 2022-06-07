<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $user_id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $parent_user_id;

    #[ORM\Column(type: 'float', nullable: true)]
    private $usdt;

    #[ORM\Column(type: 'float', nullable: true)]
    private $cometapoin;

    #[ORM\Column(type: 'float', nullable: true)]
    private $etherium;

    #[ORM\Column(type: 'float', nullable: true)]
    private $bitcoin;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getParentUserId(): ?int
    {
        return $this->parent_user_id;
    }

    public function setParentUserId(?int $parent_user_id): self
    {
        $this->parent_user_id = $parent_user_id;

        return $this;
    }

    public function getUsdt(): ?float
    {
        return $this->usdt;
    }

    public function setUsdt(?float $usdt): self
    {
        $this->usdt = $usdt;

        return $this;
    }

    public function getCometapoin(): ?float
    {
        return $this->cometapoin;
    }

    public function setCometapoin(?float $cometapoin): self
    {
        $this->cometapoin = $cometapoin;

        return $this;
    }

    public function getEtherium(): ?float
    {
        return $this->etherium;
    }

    public function setEtherium(?float $etherium): self
    {
        $this->etherium = $etherium;

        return $this;
    }

    public function getBitcoin(): ?float
    {
        return $this->bitcoin;
    }

    public function setBitcoin(?float $bitcoin): self
    {
        $this->bitcoin = $bitcoin;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
