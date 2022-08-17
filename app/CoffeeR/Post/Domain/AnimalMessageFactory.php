<?php

namespace App\CoffeeR\Post\Domain;

class AnimalMessageFactory
{
    public function create(int $animalType, string $message): AnimalMessageInterface
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
            case 4:
                $animalMessage = new ChickMessage($message);
                break;
            case 5:
                $animalMessage = new ElephantMessage($message);
                break;
            case 6:
                $animalMessage = new FlogMessage($message);
                break;
            default:
                throw new \InvalidArgumentException('animal type id ' . $animalType . ' not supported');
                break;
        }

        return $animalMessage;
    }
}
