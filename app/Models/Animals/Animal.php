<?php


namespace App\Models\Animals;


use App\Models\Products\Product;

abstract class Animal {
    protected string $id;

    protected Product $product;

    /**
     * @param string $id Unique animal ID
     * @param Product $product Product associated with the animal
     */
    public function __construct(string $id, Product $product)
    {
        $this->id = $id;
        $this->product = $product;
    }

    /**
     * @return int amount of products depends of the animal's type
     */
    public function produceProduct(): int {
        return random_int(static::MIN_PRODUCT, static::MAX_PRODUCT);
    }

    /**
     * Store amount in the product object
     */
    public function collectProduct(): void
    {
        $this->product->addToCount($this->produceProduct());
    }

    public static function getTypeName(): string
    {
        return defined('static::TYPE_NAME') ? static::TYPE_NAME : 'Animal';
    }

    public function getProduct(): Product
    {
        return $this->product;
    }


}
