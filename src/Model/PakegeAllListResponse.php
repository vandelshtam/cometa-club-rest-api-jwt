<?php

namespace App\Model;

class PakegeAllListResponse
{
    /**
     * @var Pakeges[]
     */
    private array $items;

    /**
     * @param Pakeges[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return Pakeges[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
