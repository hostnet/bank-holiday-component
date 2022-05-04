<?php
/**
 * @copyright 2017 Hostnet B.V.
 */
declare(strict_types=1);

namespace Hostnet\Component\BankHoliday;

/**
 * Find bank holidays based on date or type.
 * @see BankHoliday
 */
class BankHolidayResolver
{
    /**
     * @var string[]
     */
    private $available_bank_holidays = [];

    /**
     * @param string[] $available_bank_holidays
     */
    public function __construct(array $available_bank_holidays = BankHoliday::ALL)
    {
        foreach ($available_bank_holidays as $available_bank_holiday) {
            $this->addAvailableBankHoliday($available_bank_holiday);
        }
    }

    private function addAvailableBankHoliday(string $bank_holiday): self
    {
        if (!in_array($bank_holiday, BankHoliday::ALL)) {
            throw new \RuntimeException(sprintf(
                "Tried to add unknown BankHoliday '%s'. Only add BankHolidays from %s.",
                $bank_holiday,
                BankHoliday::class
            ));
        }

        if (!in_array($bank_holiday, $this->available_bank_holidays)) {
            $this->available_bank_holidays[] = $bank_holiday;
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getAvailableBankHolidays(): array
    {
        return $this->available_bank_holidays;
    }

    /**
     * @param \DateTime $date
     * @return string[]
     */
    public function getByDate(\DateTime $date): array
    {
        $date = clone $date;
        $date->setTime(0, 0, 0);

        $types = [];
        foreach ($this->available_bank_holidays as $type) {
            if ($this->getByType($type, (int) $date->format('Y')) == $date) {
                $types[] = $type;
            }
        }

        return $types;
    }

    /**
     * @param string $bank_holiday_type
     * @param int    $year
     * @return \DateTime|null
     */
    public function getByType(string $bank_holiday_type, int $year)
    {
        switch ($bank_holiday_type) {
            case BankHoliday::NEW_YEARS_DAY:
                return new \DateTime(sprintf('%d-01-01', $year));

            case BankHoliday::EASTER_SUNDAY:
                return $this->getEasterSundayDate($year);

            case BankHoliday::EASTER_MONDAY:
                return $this->getEasterSundayDate($year)->add(new \DateInterval('P1D'));

            case BankHoliday::DUTCH_KINGS_DAY:
                return $this->getDutchKingsDayDate($year);

            case BankHoliday::DUTCH_LIBERATION_DAY:
                return $this->getDutchLiberationDate($year);

            case BankHoliday::ASCENSION_DAY:
                return $this->getEasterSundayDate($year)->add(new \DateInterval('P39D'));

            case BankHoliday::WHIT_SUNDAY:
                return $this->getEasterSundayDate($year)->add(new \DateInterval('P49D'));

            case BankHoliday::WHIT_MONDAY:
                return $this->getEasterSundayDate($year)->add(new \DateInterval('P50D'));

            case BankHoliday::CHRISTMAS_DAY:
                return new \DateTime(sprintf('%d-12-25', $year));

            case BankHoliday::BOXING_DAY:
                return new \DateTime(sprintf('%d-12-26', $year));
        }

        return null;
    }

    /**
     * @param int $year
     * @return \DateTime
     */
    private function getDutchKingsDayDate(int $year): \DateTime
    {
        $base = new \DateTime(sprintf('%d-04-27', $year));

        if ($base->format('N') == 7) {
            $base->sub(new \DateInterval('P1D'));
        }

        return $base;
    }

    /**
     * This function calculates the date based on the days after March 21st
     * and adds them to that date to get the easter sunday date of a given year.
     * It is possible to do this exact calculation with the PHP function easter_days,
     * but unfortunately this isn't always enabled.
     *
     * The calculation is based on Gauss algorithm https://en.wikipedia.org/wiki/Computus#Gauss_algorithm
     *
     * Source of the function https://blog.rgpsoft.com/php-code-to-find-the-date-of-easter
     * Checked with https://www.assa.org.au/edm#Computer
     *
     * @var int
     * @return \DateTime
     */
    private function getEasterSundayDate(int $year): \DateTime
    {
        $base = new \DateTime(sprintf('%d-03-21', $year));
        $gm   = [22, 22, 23, 23, 24, 24];
        $da   = [2, 2, 3, 4, 5, 5];
        $a    = $year % 19;
        $b    = $year % 4;
        $c    = $year % 7;
        $i    = bcsub(bcdiv((string) $year, '100'), '15');
        $d    = (19 * $a + $gm[$i]) % 30;
        $e    = (2 * $b + 4 * $c + 6 * $d + $da[$i]) % 7;
        $days = 1 + $d + $e;

        return $base->add(new \DateInterval(sprintf('P%dD', $days)));
    }

    /**
     * @param int $year
     * @return \DateTime|null
     */
    private function getDutchLiberationDate(int $year)
    {
        if ($year % 5 > 0) {
            return null;
        }

        return new \DateTime(sprintf('%d-05-05', $year));
    }
}
