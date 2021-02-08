<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Utility\ArrayHelper;
use App\Utility\DateHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalenderEmplacementController extends AbstractController
{

    /**
     * @Route("/", name="calender_emplacement",methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface  $entityManager,Request $request): Response
    {
        if($request->isMethod('GET')) {
            $date= $request->get("date") ?? date("now");

        /** @var Reservation $reservationList */

            $reservationList = new ArrayCollection( $entityManager->getRepository(Reservation::class)->findBy(
                array(
                    'reservationAt' => DateHelper::getMyWorkWeek($date),
                    'periode' => 'midi'
                ),
                array('emplacement' => 'ASC','reservationAt' => 'ASC')
            ));

            $array=self::calendarInitializeGenerator();
            /** @var Reservation $res */
            foreach($reservationList as $res)
            {
                $array[$res->getEmplacement()->getName()][$res->getReservationAt()->format('N')] = true;
            }


            /** @var Reservation $reservationListSoire */
            // todo reduce le nombre de ligne factoriser en functions
            $reservationListSoire = new ArrayCollection( $entityManager->getRepository(Reservation::class)->findBy(
                array(
                    'reservationAt' => DateHelper::getMyWorkWeek($date),
                    'periode' => 'soir'
                ),
                array('emplacement' => 'ASC','reservationAt' => 'ASC')
            ));

            $arraySoire=self::calendarInitializeGenerator();
            /** @var Reservation $res */
            foreach($reservationListSoire as $res)
            {
                $arraySoire[$res->getEmplacement()->getName()][$res->getReservationAt()->format('N')] = true;
            }


        }

        return $this->render('calender_emplacement/index.html.twig', [
            'controller_name' => 'CalenderEmplacementController',
            'reservationList' => $array,
            'reservationListSoire' => $arraySoire,
            'currentMonday' => date("Y-m-d", strtotime("monday this week", strtotime($date))),
            'currentFriday' => date("Y-m-d", strtotime("friday this week", strtotime($date))),
            'nextMonday' => date("Y-m-d", strtotime("monday next week", strtotime($date))),
            'lastMonday' => date("Y-m-d", strtotime("monday last week", strtotime($date))),
        ]);
    }
    
    public static function calendarInitializeGenerator(): array
    {
        $Emplacement=$newArrayStructure=[];
        $rang=range(1, 5);
        foreach (range(1, 8) as $pos) {
            $Emplacement[]= "Emplacement $pos";
        }
        foreach($Emplacement as $column) {
            if($column === end($Emplacement)){
                foreach ($rang as $pos) {
                    if($pos !== count($rang)) {
                        $newArrayStructure[$column][$pos] = false;
                    }else{
                        $newArrayStructure[$column][$pos] = "ban";
                    }
                }
            }else{
                foreach (range(1, 5) as $pos) {
                    $newArrayStructure[$column][$pos] = false;
                }
            }
        }

        return $newArrayStructure;
    }

    public static function calendarInitializeSimple(): array
    {
        return [
            'Emplacement 1' => ArrayHelper::getArrayFalse(),
            'Emplacement 2' => ArrayHelper::getArrayFalse(),
            'Emplacement 3' => ArrayHelper::getArrayFalse(),
            'Emplacement 4' => ArrayHelper::getArrayFalse(),
            'Emplacement 5' => ArrayHelper::getArrayFalse(),
            'Emplacement 6' => ArrayHelper::getArrayFalse(),
            'Emplacement 7' => ArrayHelper::getArrayFalse(),
            'Emplacement 8' => array_replace(ArrayHelper::getArrayFalse(),Array(5=>"ban")),
        ];
    }
    
}
