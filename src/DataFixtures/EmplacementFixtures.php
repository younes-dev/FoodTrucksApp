<?php

namespace App\DataFixtures;

use App\Entity\Emplacement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EmplacementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        foreach (range(0,10)  as $value)
        {
            $emplacement = new Emplacement();
            $emplacement->setName($faker->name);
            $emplacement->setLocalisation($faker->randomDigit);
            $manager->persist($emplacement);
        }
        $manager->flush();
    }

}
