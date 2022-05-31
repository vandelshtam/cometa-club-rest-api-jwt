<?php

namespace App\Model;

class SettingOptionsRewiewListResponse
{
    /**
     * @var SettingOptions[]
     */
    private array $items;

    /**
     * @param SettingOptions[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return SettingOptions[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
