<?php

namespace App\Tests\Unitaire;

use App\Utility\DateHelper;
use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{
    /**
     * Cmd : bin/phpunit --filter=testIsWeekend
     */
    public function testIsWeekend(): void
    {
        self::assertTrue(DateHelper::isWeekend('2021-02-06'));
        self::assertTrue(DateHelper::isWeekend('2021-02-07'));
    }

    /**
     * Cmd : bin/phpunit --filter=testIsWeekend
     */
    public function testIsNotWeekend(): void
    {
        self::assertFalse(DateHelper::isWeekend('2021-02-02'));
        self::assertFalse(DateHelper::isWeekend('2021-02-03'));
    }

    /**
     * Cmd : bin/phpunit --filter=testIsFriday
     */
    public function testIsFriday(): void
    {
        self::assertTrue(DateHelper::isFriday('2021-02-05'));
        self::assertFalse(DateHelper::isFriday('2021-02-07'));
    }

    /**
     * Cmd : bin/phpunit --filter=testWorkWeek
     */
    public function testWorkWeek(): void
    {
        $dateReservation='2021-02-05';
        // this line to test false date
        //$checkdat=in_array($dateReservation, DateHelper::getWorkWeek('2021-02-05'));
        // this line to test true date (the date given in the range of the dates of the week)
        $checkdat= in_array($dateReservation, DateHelper::getWorkWeek($dateReservation), true);
        //dd($checkdat);
        // dd(DateHelper::getWorkWeek('2021-02-05'));
        $this->assertTrue($checkdat);
    }
}
