<?php

namespace App\Models\Products;

use InvalidArgumentException;

class Product
{
    // Name of the product for displaying
    private string $name;

    private int $count = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

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
