<?php

// src/EventListener/SearchIndexerSubscriber.php
namespace App\Subscibers;

use App\Entity\Reservation;
use App\Utility\DateHelper;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReservationSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        /** @var Reservation $entity */
        $entity = $args->getObject();
        if ($entity instanceof Reservation) {
            $entity->setPeriode($entity->getPeriode() ?? 'midi');
            $entityManager = $args->getObjectManager();
            if (DateHelper::isWeekend($entity->getReservationAt()))
            {
                throw new BadRequestHttpException('you are not allowed to reserve a place during the weekend ! in '.self::mappingPeriod($entity->getPeriode()));
            }

            // test Fri not reserve more thant 7
            $entityManager = $args->getObjectManager();
            $countReservation = $entityManager->getRepository(Reservation::class)->count([
                'reservationAt' => $entity->getReservationAt(),
                'periode' => $entity->getPeriode()
            ]);

            if ($countReservation === 7 && DateHelper::isFriday($entity->getReservationAt())) {
                throw new BadRequestHttpException('you cannot reserve more than 7 reservation in friday in  '.self::mappingPeriod($entity->getPeriode()));
            }

            if ($countReservation === 8) {
                throw new BadRequestHttpException('you cannot reserve more than 8 reservation a day  '.self::mappingPeriod($entity->getPeriode()));
            }

            $countFoudTruck = $entityManager->getRepository(Reservation::class)->count([
                'foodtruck' => $entity->getFoodtruck(),
                'reservationAt' => $entity->getReservationAt(),
                'periode' => $entity->getPeriode()
            ]);

            if ($countFoudTruck === 1) {
                throw  new BadRequestHttpException('foodtruck cannot reserve more than one time in the '.self::mappingPeriod($entity->getPeriode()));
            }

            $countFoudTruck = $entityManager->getRepository(Reservation::class)->count([
                'foodtruck' => $entity->getFoodtruck(),
                'reservationAt' => DateHelper::getMyWorkWeek($entity->getReservationAt()),
                'periode' => $entity->getPeriode()
            ]);

            if ($countFoudTruck === 3) {
                throw  new BadRequestHttpException('foodtruck cannot reserve more thant 3 times a week '.self::mappingPeriod($entity->getPeriode()));
            }



        }
    }

    public static function mappingPeriod($period)
    {
        return $period === 'midi' ? 'morning' : 'evening';
    }
}