<?php

namespace App\DataFixtures;

use App\Entity\Emplacement;
use App\Entity\FoodTruck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FoodTruckFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
         $faker = Factory::create();
        foreach (range(0,10)  as $value)
        {
            $foodTruck = new FoodTruck();
            $foodTruck->setName($faker->name);
            $foodTruck->setDescription($faker->text(100));
            $manager->persist($foodTruck);
        }
        $manager->flush();
    }
}
