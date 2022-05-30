<?php

namespace App\Model;

class PakageAllListResponse
{
    /**
     * @var PakagesCategory[]
     */
    private array $items;

    /**
     * @param PakagesCategory[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return PakagesCategory[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
