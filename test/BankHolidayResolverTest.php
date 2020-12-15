<?php
/**
 * @copyright 2017 Hostnet B.V.
 */
declare(strict_types=1);

namespace Hostnet\Component\BankHoliday;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Hostnet\Component\BankHoliday\BankHolidayResolver
 */
class BankHolidayResolverTest extends TestCase
{
    /**
     * @var BankHolidayResolver
     */
    private $bank_holiday_resolver;

    protected function setUp(): void
    {
        $this->bank_holiday_resolver = new BankHolidayResolver();
    }

    public function testCreateResolverWithNonExistingBankHoliday(): void
    {
        $this->expectException(\RuntimeException::class);
        new BankHolidayResolver(['symfony_con']);
    }

    public function testGetAvailableBankHolidays(): void
    {
        self::assertSame(BankHoliday::ALL, $this->bank_holiday_resolver->getAvailableBankHolidays());
    }

    /**
     * @dataProvider findByDateProvider
     */
    public function testFindByDate($date, $expected): void
    {
        self::assertEquals($expected, $this->bank_holiday_resolver->getByDate(new \DateTime($date)));
    }

    public function findByDateProvider()
    {
        return [
            ['2017-05-25 00:00:00', [BankHoliday::ASCENSION_DAY]],
            ['2017-05-25 00:00:01', [BankHoliday::ASCENSION_DAY]],
            ['2005-05-05 00:00:00', [BankHoliday::DUTCH_LIBERATION_DAY, BankHoliday::ASCENSION_DAY]],
            ['2016-05-05 12:16:00', [BankHoliday::ASCENSION_DAY]],
            ['2017-05-26 12:16:00', []],
        ];
    }

    public function testFindByTypeNoneFound(): void
    {
        self::assertNull($this->bank_holiday_resolver->getByType(BankHoliday::DUTCH_LIBERATION_DAY, 2019));
        self::assertNull($this->bank_holiday_resolver->getByType('', 2019));
    }

    /**
     * @dataProvider findByTypeProvider
     */
    public function testFindByType($expected, $year, $type): void
    {
        self::assertEquals(new \DateTime($expected), $this->bank_holiday_resolver->getByType($type, $year));
    }

    public function findByTypeProvider()
    {
        return [
            ['2015-01-01 00:00:00', 2015, BankHoliday::NEW_YEARS_DAY],
            ['2015-04-05 00:00:00', 2015, BankHoliday::EASTER_SUNDAY],
            ['2015-04-06 00:00:00', 2015, BankHoliday::EASTER_MONDAY],
            ['2017-04-17 00:00:00', 2017, BankHoliday::EASTER_MONDAY],
            ['2014-04-26 00:00:00', 2014, BankHoliday::DUTCH_KINGS_DAY],
            ['2015-04-27 00:00:00', 2015, BankHoliday::DUTCH_KINGS_DAY],
            ['2020-05-05 00:00:00', 2020, BankHoliday::DUTCH_LIBERATION_DAY],
            ['2017-05-25 00:00:00', 2017, BankHoliday::ASCENSION_DAY],
            ['2017-06-04 00:00:00', 2017, BankHoliday::WHIT_SUNDAY],
            ['2017-06-05 00:00:00', 2017, BankHoliday::WHIT_MONDAY],
            ['2016-12-25 00:00:00', 2016, BankHoliday::CHRISTMAS_DAY],
            ['2016-12-26 00:00:00', 2016, BankHoliday::BOXING_DAY],
            ['2016-05-05 00:00:00', 2016, BankHoliday::ASCENSION_DAY],
        ];
    }
}
