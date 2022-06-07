<?php

namespace App\Model;

class WalletAllListResponse
{
    /**
     * @var Wallet[]
     */
    private array $items;

    /**
     * @param Wallet[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return Wallet[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
