<?php
/**
 * @copyright 2017 Hostnet B.V.
 */
declare(strict_types=1);

namespace Hostnet\Component\BankHoliday;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Hostnet\Component\BankHoliday\BusinessDayResolver
 */
class BusinessDayResolverTest extends TestCase
{
    /**
     * @var BusinessDayResolver
     */
    private $business_day_resolver;

    protected function setUp(): void
    {
        $this->business_day_resolver = new BusinessDayResolver(
            new BankHolidayResolver()
        );
    }

    /**
     * @dataProvider getFirstBusinessDayOfWeekProvider
     */
    public function testGetFirstBusinessDayOfWeek($year, $week, $expected): void
    {
        self::assertEquals(
            new \DateTime($expected),
            $this->business_day_resolver->getFirstBusinessDayOfWeek($year, $week)
        );
    }

    public function getFirstBusinessDayOfWeekProvider()
    {
        return [
            [2017,  1, '2017-01-02'],
            [2017, 23, '2017-06-06'],
            [2017, 52, '2017-12-27'],
            [2018,  1, '2018-01-02'],
        ];
    }

    /**
     * @dataProvider getLastBusinessDayOfMonthProvider
     */
    public function testGetLastBusinessDayOfMonth($year, $month, $expected): void
    {
        self::assertEquals(
            new \DateTime($expected),
            $this->business_day_resolver->getLastBusinessDayOfMonth($year, $month)
        );
    }

    public function getLastBusinessDayOfMonthProvider()
    {
        return [
            [2017, 4, '2017-04-28'],
            [2017, 4, '2017-04-28'],
        ];
    }

    /**
     * @dataProvider isBusinessDayProvider
     */
    public function testIsBusinessDay($expected, $date): void
    {
        self::assertSame($expected, $this->business_day_resolver->isBusinessDay(new \DateTime($date)));
    }

    public function isBusinessDayProvider()
    {
        return [
            [false, '2017-05-25'],
            [true , '2017-05-26'],
            [true , '2017-05-05'],
            [false, '2015-05-05'],
            [false, '2017-02-25'],
            [false, '2017-02-26'],
            [true , '2017-02-27'],
        ];
    }

    /**
     * @dataProvider getNextBusinessDayProvider
     */
    public function testGetNextBusinessDay($date, $expected): void
    {
        self::assertEquals(
            new \DateTime($expected),
            $this->business_day_resolver->getNextBusinessDay(new \DateTime($date))
        );
    }

    public function getNextBusinessDayProvider()
    {
        return [
            ['2017-05-29', '2017-05-30'],
            ['2017-06-02', '2017-06-06'],
            ['2017-12-31', '2018-01-02'],
            ['2017-12-29', '2018-01-02'],
        ];
    }

    /**
     * @dataProvider getPreviousBusinessDayProvider
     */
    public function testGetPreviousBusinessDay($date, $expected): void
    {
        self::assertEquals(
            new \DateTime($expected),
            $this->business_day_resolver->getPreviousBusinessDay(new \DateTime($date))
        );
    }

    public function getPreviousBusinessDayProvider()
    {
        return [
            ['2017-05-30', '2017-05-29'],
            ['2017-06-06', '2017-06-02'],
            ['2018-01-01', '2017-12-29'],
            ['2018-01-02', '2017-12-29'],
            ['2018-05-11', '2018-05-09'],
        ];
    }
}
