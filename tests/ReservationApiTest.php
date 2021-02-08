<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Emplacement;
use App\Entity\FoodTruck;
use App\Entity\Reservation;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationApiTest extends ApiTestCase
{

    private $entityManager;

    public function setUp(): void
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $this->entityManager = $container
            ->get('doctrine')
            ->getManager();
        $listeTestReservation = $container
            ->get('doctrine')
            ->getRepository(Reservation::class)
            ->findBy([
                'note' => 'first reserv'
            ]);
        foreach ($listeTestReservation as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();
        parent::setUp(); // TODO: Change the autogenerated stub

    }

    public function testPreventWeekendReservation():void
    {
        $listeEmplacement = new ArrayCollection($this->entityManager->getRepository(Emplacement::class)->findAll());

        $listeFoodtruck = new ArrayCollection($this->entityManager->getRepository(FoodTruck::class)->findAll());

        /**
         * test reservation d'un emplacement pendant les weekend
         */
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/reservations', [
            'json' => [
                "note" => "first reserv",
                "emplacement" => "/api/emplacements/" . $listeEmplacement->next()->getId(),
                "foodtruck" => "/api/foodtrucks/" . $listeFoodtruck->next()->getId(),
                "reservationAt" => "2021-02-06",
                "periode" => "midi"
            ]]);

        $this->assertResponseStatusCodeSame(400);
        $listeFoodtruck->first();
        $listeEmplacement->first();
        $crawler = $client->request('POST', '/api/reservations', [
            'json' => [
                "note" => "first reserv",
                "emplacement" => "/api/emplacements/" . $listeEmplacement->next()->getId(),
                "foodtruck" => "/api/foodtrucks/" . $listeFoodtruck->next()->getId(),
                "reservationAt" => "2021-02-06",
                "periode" => "soir"
            ]]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPreventFridayReservation():void
    {
        /**
         * test reservation d'un emplacement pendant les weekend
         */
        $client = static::createClient();

        $listeEmplacement = new ArrayCollection($this->entityManager->getRepository(Emplacement::class)->findAll());

        $listeFoodtruck = new ArrayCollection($this->entityManager->getRepository(FoodTruck::class)->findAll());

        foreach (range(1,8) as $number)
        {
            $crawler = $client->request('POST', '/api/reservations', [
                'json' => [
                    "note" => "first reserv",
                    "emplacement" => "/api/emplacements/" . $listeEmplacement->next()->getId(),
                    "foodtruck" => "/api/foodtrucks/" . $listeFoodtruck->next()->getId(),
                    "reservationAt" => "2021-02-05"
                ]]);
            if ($number === 7) {
                $listeEmplacement->first();
            }

        }

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPreventThursdayReservation():void
    {
        /**
         * test reservation d'un emplacement pendant les weekend
         */
        $client = static::createClient();

        $listeEmplacement = new ArrayCollection($this->entityManager->getRepository(Emplacement::class)->findAll());

        $listeFoodtruck = new ArrayCollection($this->entityManager->getRepository(FoodTruck::class)->findAll());

        foreach (range(1,10) as $number)
        {
            $crawler = $client->request('POST', '/api/reservations', [
                'json' => [
                    "note" => "first reserv",
                    "emplacement" => "/api/emplacements/" . $listeEmplacement->next()->getId(),
                    "foodtruck" => "/api/foodtrucks/" . $listeFoodtruck->next()->getId(),
                    "reservationAt" => "2021-02-04"
                ]]);

            if ($number === 7) {
                $listeEmplacement->first();
            }
        }

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPreventfoodTruckMoreThanADayeservation():void
    {
        /**
         * test reservation d'un emplacement pendant les weekend
         */
        $client = static::createClient();

        $listeEmplacement = new ArrayCollection($this->entityManager->getRepository(Emplacement::class)->findAll());

        $listeFoodtruck = new ArrayCollection($this->entityManager->getRepository(FoodTruck::class)->findAll());

        foreach (range(1,2) as $number)
        {
            $crawler = $client->request('POST', '/api/reservations', [
                'json' => [
                    "note" => "first reserv",
                    "emplacement" => "/api/emplacements/" . $listeEmplacement->next()->getId(),
                    "foodtruck" => "/api/foodtrucks/" . $listeFoodtruck->current()->getId(),
                    "reservationAt" => "2021-02-03"
                ]]);
            if ($number === 7) {
                $listeEmplacement->first();
            }
        }

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPreventfoodTruckMoreThanAthreeAWeekervation():void
    {
        /**
         * test reservation d'un emplacement pendant les weekend
         */
        $client = static::createClient();
        $listeEmplacement = new ArrayCollection($this->entityManager->getRepository(Emplacement::class)->findAll());
        $listeFoodtruck = new ArrayCollection($this->entityManager->getRepository(FoodTruck::class)->findAll());

        foreach (range(8,11) as $number)
        {
            $crawler = $client->request('POST', '/api/reservations', [
                'json' => [
                    "note" => "first reserv",
                    "emplacement" => "/api/emplacements/" . $listeEmplacement->next()->getId(),
                    "foodtruck" => "/api/foodtrucks/" . $listeFoodtruck->current()->getId(),
                    "reservationAt" => "2021-02-".$number,
                ]]);

            if ($number === 7) {
                $listeEmplacement->first();
            }

        }

        $this->assertResponseStatusCodeSame(400);
    }


}
