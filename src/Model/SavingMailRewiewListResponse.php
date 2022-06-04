<?php

namespace App\Model;

class SavingMailRewiewListResponse
{
    /**
     * @var SavingMail[]
     */
    private array $items;

    /**
     * @param SavingMail[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return SavingMail[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
