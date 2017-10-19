<?php

namespace kuaukutsu\ExampleWdate\tests;

use kuaukutsu\ExampleWdate\WDate;
use kuaukutsu\ExampleWdate\WDateException;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTest
 * @covers WDate
 */
final class WDateTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateDateFull(): void
    {
        $wdate = new WDate('01:00:05 21.07.2017');
        $this->assertEquals($wdate->format(), '2017-07-21 01:00:05');
    }

    /**
     * @test
     */
    public function testCreateDateWithoutSecond(): void
    {
        $wdate = new WDate('01:05 21.07.2017');
        $this->assertEquals($wdate->getHour(), '01');
        $this->assertEquals($wdate->getMinute(), '05');
    }


    /**
     * @test
     */
    public function testCreateDateWithoutMinute(): void
    {
        $wdate = new WDate('01: 21.07.2017');
        $this->assertEquals($wdate->getHour(), '01');
        $this->assertEquals($wdate->format('Y-m-d'), '2017-07-21');
    }


    /**
     * @test
     */
    public function testCreateDateWithoutTime(): void
    {
        $wdate = new WDate('21.07.2017');
        $this->assertEquals($wdate->format('Y-m-d'), '2017-07-21');
    }

    /**
     * @test
     */
    public function testCreateDateWithoutDay(): void
    {
        $wdate = new WDate('07.2017');
        $this->assertEquals($wdate->getMonth(), '07');
    }

    /**
     * @test
     */
    public function testCreateDateOnlyYear(): void
    {
        $wdate = new WDate('2017');
        $this->assertEquals($wdate->getYear(), '2017');
    }

    /**
     * @test
     */
    public function testCreateDateOnlyHour(): void
    {
        $wdate = new WDate('01:');
        $this->assertEquals($wdate->getHour(), '01');
    }

    /**
     * @test
     */
    public function testCreateDateOnlyHourAndMinute(): void
    {
        $wdate = new WDate('14:03');
        $this->assertEquals($wdate->getMinute(), '03');
    }

    /**
     * @test
     */
    public function testCreateDateOnlyTime(): void
    {
        $wdate = new WDate('07:05:26');
        $this->assertEquals($wdate->format('H:i:s'), '07:05:26');
    }

    /**
     * @test
     */
    public function testCreateDateError(): void
    {
        $this->expectException(WDateException::class);

        $wdate = new WDate('01:00:05 21.07.ssss');
        $this->assertEquals($wdate->format(), '2017-07-21 01:00:05');
    }
}
