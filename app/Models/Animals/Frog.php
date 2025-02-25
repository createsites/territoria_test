<?php


namespace App\Models\Animals;


use App\Models\Products\Meat;
use App\Models\Products\Product;

class Frog extends Animal {
    protected const TYPE_NAME = "Frog french";
    protected const MIN_PRODUCT = 8;
    protected const MAX_PRODUCT = 12;

    public function bindProduct(): Product
    {
        return new Meat();
    }
}

