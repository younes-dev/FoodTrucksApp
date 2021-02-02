<?php

namespace App\Tests\Functionel;

use App\Entity\Emplacement;
use App\Entity\FoodTruck;
use App\Tests\AbstractFunctionalApiTest;
use Doctrine\Common\Collections\ArrayCollection;

class PreventFridayReservationTest extends AbstractFunctionalApiTest
{
    public $entityManager;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
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
                    "reservationAt" => "2021-02-22" // vendredi
                ]]);

        }

        $this->assertResponseStatusCodeSame(400);
    }

}
