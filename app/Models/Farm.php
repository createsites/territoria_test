<?php

namespace App\Models;

use App\Factories\AnimalFactory;

class Farm
{
    private array $animals = [];

    private AnimalFactory $animalFactory;

    public function __construct(AnimalFactory $animalFactory)
    {
        $this->animalFactory = $animalFactory;
    }

    /**
     * Store some amount of specified type of animals
     * @param string $animalType class name of an animal
     * @param int $count
     */
    public function addAnimals(string $animalType, int $count = 1): void
    {
        // create key if was not exist
        if (!isset($this->animals[$animalType])) {
            $this->animals[$animalType] = [];
        }

        $currentCount = count($this->animals[$animalType]);
        for ($i = 1; $i <= $count; $i++) {
            $animalId = $animalType::getTypeName() . '-' . ($currentCount + 1);
            $this->animals[$animalType][] = $this->animalFactory->create($animalType, $animalId);
        }
    }

    /**
     * Does collection for all animals for specified term
     * @param int $days term of the collection
     */
    public function collectProducts(int $days = 1): void
    {
        foreach ($this->animals as $animalList) {
            foreach ($animalList as $animal) {
                for ($i = 0; $i < $days; $i++) {
                    $animal->collectProduct();
                }
            }
        }
    }

    /**
     * @return array for displaying animals
     */
    public function getAnimalsCount(): array
    {
        $counts = [];
        foreach ($this->animals as $animalType => $animalList) {
            $counts[$animalType] = count($animalList);
        }

        return $counts;
    }

    /**
     * @return array for displaying products
     */
    public function getProductsCount(): array
    {
        $products = [];
        foreach ($this->animals as $animalList) {
            foreach ($animalList as $animal) {
                $productName = $animal->getProduct()->getName();
                if (!isset($products[$productName])) {
                    $products[$productName] = 0;
                }
                $products[$productName] += $animal->getProduct()->getCount();
            }
        }

        return $products;
    }
}
