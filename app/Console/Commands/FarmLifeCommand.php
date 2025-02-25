<?php

namespace App\Console\Commands;

use App\Factories\AnimalFactory;
use App\Models\Animals\Frog;
use App\Models\Products\Product;
use Illuminate\Console\Command;
use App\Models\Farm;
use App\Models\Animals\Cow;
use App\Models\Animals\Chicken;
use UnexpectedValueException;

class FarmLifeCommand extends Command
{
    protected $signature = 'farm:life';

    protected $description = 'Simulate life on the farm';

    private const WEEK = 7;
    private const INITIAL_COWS = 10;
    private const INITIAL_CHICKENS = 20;

    public function __construct(private Farm $farm, private AnimalFactory $animalFactory)
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $cows = $this->animalFactory->createMany(Cow::class, self::INITIAL_COWS);
            $this->farm->addAnimals($cows);
            $chickens = $this->animalFactory->createMany(Chicken::class, self::INITIAL_CHICKENS);
            $this->farm->addAnimals($chickens);

            $this->info('Initial state of the farm:');
            $this->displayAnimals();

            $this->farm->collectProducts(static::WEEK);
            $this->info('A week has passed:');
            $this->displayProducts();

            $cow = $this->animalFactory->createOne(Cow::class);
            $this->farm->addAnimal($cow);
            $chickens = $this->animalFactory->createMany(Chicken::class, 5);
            $this->farm->addAnimals($chickens);

            $this->info('After market visit:');
            $this->displayAnimals();

            $this->farm->collectProducts(static::WEEK);
            $this->info('Another week has passed:');
            $this->displayProducts();

            $frog = $this->animalFactory->createOne(Frog::class);
            $this->farm->addAnimal($frog);
            $this->info('A frog was added:');
            $this->displayAnimals();
        } catch (UnexpectedValueException $e) {
            $this->error($e->getMessage());
        }
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
