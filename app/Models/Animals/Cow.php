<?php


namespace App\Models\Animals;


use App\Models\Products\Milk;
use App\Models\Products\Product;

class Cow extends Animal {
    protected const TYPE_NAME = "Cow";
    protected const MIN_PRODUCT = 8;
    protected const MAX_PRODUCT = 12;

    public function bindProduct(): Product
    {
        return new Milk();
    }
}

