<?php
/**
 * @copyright 2017 Hostnet B.V.
 */
declare(strict_types=1);

namespace Hostnet\Component\BankHoliday;

/**
 * Resolves whether a certain day is a business day
 * based on the given BankHolidayResolver.
 */
class BusinessDayResolver
{
    /**
     * @var BankHolidayResolver
     */
    private $bank_holiday_resolver;

    public function __construct(BankHolidayResolver $bank_holiday_resolver)
    {
        $this->bank_holiday_resolver = $bank_holiday_resolver;
    }

    public function getFirstBusinessDayOfWeek(int $year, int $week_number): \DateTime
    {
        $week_date = new \DateTime('midnight');
        $week_date->setISODate($year, $week_number);

        while (!$this->isBusinessDay($week_date)) {
            $week_date->add(new \DateInterval('P1D'));
        }

        return $week_date;
    }

    public function getLastBusinessDayOfMonth(int $year, int $month): \DateTime
    {
        $last_day_month = new \DateTime(sprintf('%d-%s-01 00:00:00', $year, $month));
        $last_day_month->modify('last day of this month');

        while (!$this->isBusinessDay($last_day_month)) {
            $last_day_month->sub(new \DateInterval('P1D'));
        }

        return $last_day_month;
    }

    public function getNextBusinessDay(\DateTime $date): \DateTime
    {
        $date = clone $date;
        $date->setTime(0, 0, 0);
        $date->add(new \DateInterval('P1D'));

        while (!$this->isBusinessDay($date)) {
            $date->add(new \DateInterval('P1D'));
        }

        return $date;
    }

    public function getPreviousBusinessDay(\DateTime $date): \DateTime
    {
        $date = clone $date;
        $date->setTime(0, 0, 0);
        $date->sub(new \DateInterval('P1D'));

        while (!$this->isBusinessDay($date)) {
            $date->sub(new \DateInterval('P1D'));
        }

        return $date;
    }

    public function isBusinessDay(\DateTime $date): bool
    {
        return $date->format('N') < 6 && empty($this->bank_holiday_resolver->getByDate($date));
    }
}
