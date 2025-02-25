<?php

namespace App\Models\Products;

use InvalidArgumentException;

abstract class Product
{
    private int $count = 0;

    abstract public function getName(): string;

    /**
     * Store to count
     * @param int $amount
     * @throws InvalidArgumentException
     */
    public function addToCount(int $amount): void
    {
        if ($amount < 0) {
            throw new InvalidArgumentException("Amount cannot be negative");
        }
        $this->count += $amount;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
