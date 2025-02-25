<?php


namespace App\Models\Animals;


use App\Models\Products\Eggs;
use App\Models\Products\Product;

class Chicken extends Animal {
    protected const TYPE_NAME = "Chicken";
    protected const MIN_PRODUCT = 0;
    protected const MAX_PRODUCT = 1;

    public function bindProduct(): Product
    {
        return new Eggs();
    }
}

