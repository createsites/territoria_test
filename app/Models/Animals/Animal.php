<?php


namespace App\Models\Animals;


use App\Models\Products\Product;

abstract class Animal {
    protected string $id;
    private Product $product;

    public function __construct()
    {
        // Bind concrete product to an animal
        $this->product = $this->bindProduct();
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

    abstract public function bindProduct(): Product;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
}
