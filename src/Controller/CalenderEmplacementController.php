<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Utility\DateHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class CalenderEmplacementController extends AbstractController
{

//    private $request;
//
//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }

    /**
     * @Route("/", name="calender_emplacement",methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface  $entityManager,Request $request): Response
    {
        //dd(date("Y-m-d", strtotime("monday last week", strtotime("2021-02-01"))));

        if($request->isMethod('GET')) {
            //$date=$request->get("date") ? $request->get("date") : date("now");
            //$date= $request->get("date") ?: date("now");
            $date= $request->get("date") ?? date("now");

        /** @var Reservation $reservationList */

            $reservationList = new ArrayCollection( $entityManager->getRepository(Reservation::class)->findBy(
                array(
                    'reservationAt' => DateHelper::getMyWorkWeek($date)
                ),
                array('emplacement' => 'ASC','reservationAt' => 'ASC')
            ));

            $array=self::calendarInitializeGenerator();
            //$array=self::calendarInitializeSimple();
            /** @var Reservation $res */
            foreach($reservationList as $res)
            {
                $array[$res->getEmplacement()->getName()][$res->getReservationAt()->format('N')] = true;
            }
        }

        return $this->render('calender_emplacement/index.html.twig', [
            'controller_name' => 'CalenderEmplacementController',
            'reservationList' => $array,
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
//                    if(next($rang)) {
                    if($pos !== count($rang)) {
                        $newArrayStructure[$column][$pos] = false;//
                    }else{
                        $newArrayStructure[$column][$pos] = "ban";
                    }
                }
            }else{
                foreach (range(1, 5) as $pos) {
                    $newArrayStructure[$column][$pos] = false;//
                }
            }
        }

        return $newArrayStructure;
    }
    public static function calendarInitializeSimple(): array
    {
        return [
            'Emplacement 1' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => false
            ],
            'Emplacement 2' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => false
            ],
            'Emplacement 3' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => false
            ],
            'Emplacement 4' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => false
            ],
            'Emplacement 5' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => false
            ],
            'Emplacement 6' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => false
            ],
            'Emplacement 7' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => false
            ],
            'Emplacement 8' => [
                1 => false,
                2 => false,
                3 => false,
                4 => false,
                5 => "ban"
            ]

        ];
    }


    
    
}
