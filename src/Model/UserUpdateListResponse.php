<?php

namespace App\Model;

class UserUpdateListResponse
{
    /**
     * @var UserUpdate[]
     */
    private array $items;

    /**
     * @param UserUpdate[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return UserUpdate[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
