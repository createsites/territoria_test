<?php


namespace App\Factories;


use App\Models\Animals\Animal;
use Psr\Container\ContainerInterface;
use UnexpectedValueException;

class AnimalFactory
{
    public function __construct(private ContainerInterface $container) {}

    /**
     * @param string $animalType a class name
     * @return Animal
     * @throws UnexpectedValueException
     */
    public function createOne(string $animalType): Animal
    {
        try {
            // contains the class validation inside
            return $this->container->get($animalType);
        } catch (\Throwable $e) {
            throw new UnexpectedValueException("Class {$e->getMessage()} is not an Animal");
        }
    }

    /**
     * @param string $animalType an animal model class name
     * @param int $count how many instances need to create
     * @return array of Animals
     */
    public function createMany(string $animalType, int $count): array
    {
        $animals = [];
        for ($i = 0; $i < $count; $i++) {
            $animals[] = $this->createOne($animalType);
        }
        return $animals;
    }
}
