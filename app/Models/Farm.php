<?php

namespace App\Models;

use App\Models\Animals\Animal;

class Farm
{
    // В этом массиве ведется учет животных фермой
    // тип животного (имя класса) => [
    //      [ сгенерированный фермой id => объект Animal]
    // ]
    private array $animals = [];

    public function addAnimal(Animal $animal): void
    {
        try {
            // create key if was not exist
            $this->animals[$animal::class] = $this->animals[$animal::class] ?? [];

            $currentCount = count($this->animals[$animal::class]);
            $animalId = $animal::class . '-' . ($currentCount + 1);
            $this->animals[$animal::class][] = [
                $animalId => $animal
            ];
        } catch (\InvalidArgumentException $e) {
            // logging
        }
    }

    /**
     * Store some amount of one type of animals
     * @param $animals array objects of Animal
     */
    public function addAnimals(array $animals): void
    {
        foreach ($animals as $animal) {
            $this->addAnimal($animal);
        }
    }

    /**
     * Does collection for all animals for specified term
     * @param int $days term of the collection
     */
    public function collectProducts(int $days = 1): void
    {
        foreach ($this->animals as $animalList) {
            foreach ($animalList as $animalArray) {
                $animal = reset($animalArray);
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
            foreach ($animalList as $animalArray) {
                $animal = reset($animalArray);
                $productName = $animal->getProduct()->getName();
                $products[$productName] = $products[$productName] ?? 0;
                $products[$productName] += $animal->getProduct()->getCount();
            }
        }

        return $products;
    }
}
