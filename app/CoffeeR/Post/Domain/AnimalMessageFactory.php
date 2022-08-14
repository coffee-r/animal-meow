<?php

namespace App\CoffeeR\Post\Domain;

class AnimalMessageFactory
{
    public function create(int $animalType, string $message)
    {
        switch ($animalType) {
            case 1:
                $animalMessage = new CatMessage($message);
                break;
            case 2:
                $animalMessage = new DogMessage($message);
                break;
            case 3:
                $animalMessage = new GoriraMessage($message);
                break;
            default:
                throw new \InvalidArgumentException();
                break;
        }

        return $animalMessage;
    }
}