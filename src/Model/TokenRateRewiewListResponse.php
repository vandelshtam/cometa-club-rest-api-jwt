<?php

namespace App\Model;

class TokenRateRewiewListResponse
{
    /**
     * @var TokenRate[]
     */
    private array $items;

    /**
     * @param TokenRate[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return TokenRate[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
