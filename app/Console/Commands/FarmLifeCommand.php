<?php

namespace App\Console\Commands;

use App\Factories\AnimalFactory;
use Illuminate\Console\Command;
use App\Models\Farm;
use App\Models\Animals\Cow;
use App\Models\Animals\Chicken;

class FarmLifeCommand extends Command
{
    protected $signature = 'farm:life';

    protected $description = 'Simulate life on the farm';

    private Farm $farm;

    private const WEEK = 7;
    private const INITIAL_COWS = 10;
    private const INITIAL_CHICKENS = 20;

    public function handle()
    {
        $this->farm = new Farm(new AnimalFactory());

        $this->farm->addAnimals(Cow::class, self::INITIAL_COWS);
        $this->farm->addAnimals(Chicken::class, self::INITIAL_CHICKENS);

        $this->info('Initial state of the farm:');
        $this->displayAnimals();

        $this->farm->collectProducts(static::WEEK);
        $this->info('A week has passed:');
        $this->displayProducts();

        $this->farm->addAnimals(Cow::class, 1);
        $this->farm->addAnimals(Chicken::class, 5);

        $this->info('After market visit:');
        $this->displayAnimals();

        $this->farm->collectProducts(static::WEEK);
        $this->info('Another week has passed:');
        $this->displayProducts();
    }

    /**
     * Display products
     */
    private function displayProducts()
    {
        $this->info('Products:');
        foreach ($this->farm->getProductsCount() as $productName => $productCount) {
            $this->info("\t$productName: $productCount");
        }
    }

    /**
     * Display animals
     */
    private function displayAnimals()
    {
        $this->info('Animals:');
        foreach ($this->farm->getAnimalsCount() as $animalType => $count) {
            $typeName = $animalType::getTypeName();
            $this->info("\t{$typeName}: {$count}");
        }
    }
}
