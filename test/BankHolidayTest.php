<?php
/**
 * @copyright 2017 Hostnet B.V.
 */
declare(strict_types=1);

namespace Hostnet\Component\BankHoliday;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Hostnet\Component\BankHoliday\BankHoliday
 */
class BankHolidayTest extends TestCase
{
    public function testCollections(): void
    {
        $holidays = array_filter((new \ReflectionClass(BankHoliday::class))->getConstants(), function ($item) {
            return ! is_array($item);
        });

        $all      = BankHoliday::ALL;
        $expected = array_values($holidays);

        sort($all, SORT_STRING);
        sort($expected, SORT_STRING);

        self::assertEquals($expected, $all);
    }
}
