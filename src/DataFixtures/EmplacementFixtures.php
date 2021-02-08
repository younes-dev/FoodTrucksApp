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
        foreach (range(1,8)  as $value)
        {
            $emplacement = new Emplacement();
            $emplacement->setName('Emplacement '.$value);
            $emplacement->setLocalisation($faker->randomDigit);
            $manager->persist($emplacement);
        }
        $manager->flush();
    }

}
