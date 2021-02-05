<?php

namespace App\DataFixtures;

use App\Entity\Emplacement;
use App\Entity\FoodTruck;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReservationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $listeEmplacement = new ArrayCollection($manager->getRepository(Emplacement::class)->findAll());

        $listeFoodtruck = new ArrayCollection($manager->getRepository(FoodTruck::class)->findAll());

        foreach (range(0,10)  as $value)
        {
            $reservation = new Reservation();
            $reservation->setNote($faker->realText(100));
            $reservation->setEmplacement($listeEmplacement->current());
            $reservation->setFoodtruck($listeFoodtruck->current());
            $reservation->setReservationAt($faker->datetime());
            $listeEmplacement->next();
            $listeFoodtruck->next();
            $manager->persist($reservation);
        }
        $manager->flush();
    }

}
