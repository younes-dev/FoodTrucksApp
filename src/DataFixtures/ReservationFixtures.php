<?php

namespace App\DataFixtures;

use App\Entity\Emplacement;
use App\Entity\FoodTruck;
use App\Entity\Reservation;
use App\Utility\DateHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReservationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $enum = ['midi', 'soir'];

        $listeEmplacement = new ArrayCollection($manager->getRepository(Emplacement::class)->findAll());

        $listeFoodtruck = new ArrayCollection($manager->getRepository(FoodTruck::class)->findAll());

        foreach (range(0,20)  as $value)
        {
            //dd(DateHelper::getMyWorkWeek(date("now"))[0];
            $reservation = new Reservation();
            $reservation->setNote($faker->realText(100));
            $reservation->setEmplacement($listeEmplacement->current());
            $reservation->setFoodtruck($listeFoodtruck->current());
           // $interval=$faker->dateTimeBetween('now', '+ '.$value.' days', null) ;
            $reservation->setReservationAt(
                \DateTime::createFromFormat('Y-m-d',DateHelper::getMyWorkWeek(date("now"))[mt_rand(0,4)])
            );
            $reservation->setPeriode($enum[mt_rand(0,1)]);
            if ($value === 7 || $value === 14 ) {
               $listeEmplacement->first();
               $listeFoodtruck->first();
            }
            $listeEmplacement->next();
            $listeFoodtruck->next();
            $manager->persist($reservation);
        }

        $manager->flush();
    }



}
