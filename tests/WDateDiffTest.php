<?php

namespace kuaukutsu\ExampleWdate\tests;

use kuaukutsu\ExampleWdate\WDate;
use kuaukutsu\ExampleWdate\WDateException;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTest
 * @covers WDate
 */
final class WDateDiffTest extends TestCase
{
    /**
     *
     */
    public function testIsEqual(): void
    {
        $wdate = new WDate('01:00:05 21.07.2017');
        $wdate2 = new WDate('01:00:05 21.07.2017');

        $this->assertTrue($wdate->isEqualTo($wdate2));
    }

    /**
     *
     */
    public function testHowManyDaysBefore()
    {
        $wdate = new WDate('01:00:05 21.07.2017');
        $wdate2 = new WDate('01:00:05 29.07.2017');

        $this->assertEquals($wdate->howManyDaysBefore($wdate2), 8);
    }

    /**
     *
     */
    public function testHowManyDaysBeforeError()
    {
        $this->expectException(WDateException::class);

        $wdate = new WDate('01:00:05 21.07.2017');
        $wdate2 = new WDate('01:00:05 20.07.2017');

        $this->assertEquals($wdate->howManyDaysBefore($wdate2), 8);
    }

    /**
     *
     */
    public function testHowManyDaysAfter()
    {
        $wdate = new WDate('01:00:05 23.07.2017');
        $wdate2 = new WDate('01:00:05 29.07.2017');

        $this->assertEquals($wdate2->howManyDaysAfter($wdate), 6);
    }

    /**
     *
     */
    public function testHowManyDaysAfterError()
    {
        $this->expectException(WDateException::class);

        $wdate = new WDate('01:00:05 23.07.2017');
        $wdate2 = new WDate('01:00:05 22.07.2017');

        $this->assertEquals($wdate2->howManyDaysAfter($wdate), 6);
    }
}
