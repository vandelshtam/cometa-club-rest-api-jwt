<?php

namespace App\Model;

class TransactionTableRewiewListResponse
{
    /**
     * @var TransactionTable[]
     */
    private array $items;

    /**
     * @param TransactionTable[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return TransactionTable[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
