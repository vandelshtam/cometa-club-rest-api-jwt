<?php

namespace App\Model;

class WalletReviewPage
{
    /**
     * @var WalletReview[]
     */
    private array $items;

    private int $page;

    private int $pages;

    private int $perPage;

    private int $total_wallet;

    private float $total_usdt;

    private float $total_bitcoin;

    private float $total_etherium;

    private float $total_cometapoin;

    /**
     * @return WalletReview[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param WalletReview[] $items
     * @return WalletReviewPage
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function setPages(int $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function getTotalWallet(): int
    {
        return $this->total_wallet;
    }

    public function setTotalWallet(int $total_wallet): self
    {
        $this->total_wallet = $total_wallet;

        return $this;
    }

    public function getTotalUsdt(): float
    {
        return $this->total_usdt;
    }

    public function setTotalUsdt(float $total_usdt): self
    {
        $this->total_usdt = $total_usdt;

        return $this;
    }

    public function getTotalBitcoin(): float
    {
        return $this->total_bitcoin;
    }

    public function setTotalBitcoin(float $total_bitcoin): self
    {
        $this->total_bitcoin = $total_bitcoin;

        return $this;
    }

    public function getTotalEtherium(): float
    {
        return $this->total_etherium;
    }

    public function setTotalEtherium(float $total_etherium): self
    {
        $this->total_etherium = $total_etherium;

        return $this;
    }

    public function getTotalCometapoin(): float
    {
        return $this->total_cometapoin;
    }

    public function setTotalCometapoin(float $total_cometapoin): self
    {
        $this->total_cometapoin = $total_cometapoin;

        return $this;
    }
}
