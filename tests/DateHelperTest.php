<?php

namespace App\Tests;

use App\Utility\DateHelper;
use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{
    /**
     * Cmd : bin/phpunit --filter=testIsWeekend
     */
    public function testIsWeekend(): void
    {
        // todo add now sortime sunday this week and next functions
        self::assertTrue(DateHelper::isWeekend('2021-02-06'));
        self::assertTrue(DateHelper::isWeekend('2021-02-07'));
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
        $checkdat= in_array($dateReservation, DateHelper::getWorkWeek($dateReservation), true);

        $this->assertTrue($checkdat);
    }
}
