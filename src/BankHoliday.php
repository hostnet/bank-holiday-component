<?php
/**
 * @copyright 2017-2018 Hostnet B.V.
 */
declare(strict_types=1);

namespace Hostnet\Component\BankHoliday;

/**
 * Enum class that contains the bank holidays that can be resolved
 * by the BankHolidayResolver.
 */
final class BankHoliday
{
    /**
     * The first day of a year.
     */
    public const NEW_YEARS_DAY = 'new_years_day';

    /**
     * The sunday of easter.
     */
    public const EASTER_SUNDAY = 'easter_sunday';

    /**
     * The monday of easter.
     */
    public const EASTER_MONDAY = 'easter_monday';

    /**
     * The Dutch bank holiday Kings day.
     */
    public const DUTCH_KINGS_DAY = 'dutch_kings_day';

    /**
     * Bank holiday on May 5th, denoting the end of WW2 in The Netherlands.
     * This is, for the majority of the Dutch population, a bank holiday once every five years.
     */
    public const DUTCH_LIBERATION_DAY = 'dutch_liberation_day';

    /**
     * Ascension day (Christian holiday).
     */
    public const ASCENSION_DAY = 'ascension_day';

    /**
     * Whit sunday (Christian holiday).
     */
    public const WHIT_SUNDAY = 'whit_sunday';

    /**
     * Whit monday is a bank holiday that follows the Christian holiday whit sunday.
     */
    public const WHIT_MONDAY = 'whit_monday';

    /**
     * Christmas day, always on December 25th.
     */
    public const CHRISTMAS_DAY = 'christmas_day';

    /**
     * The day after christmas day.
     */
    public const BOXING_DAY = 'boxing_day';

    /**
     * All bank holidays that are defined in this class.
     */
    public const ALL = [
        self::DUTCH_LIBERATION_DAY,
        self::ASCENSION_DAY,
        self::BOXING_DAY,
        self::CHRISTMAS_DAY,
        self::DUTCH_KINGS_DAY,
        self::EASTER_MONDAY,
        self::EASTER_SUNDAY,
        self::NEW_YEARS_DAY,
        self::WHIT_MONDAY,
        self::WHIT_SUNDAY,
    ];

    /**
     * Set of Dutch bank holidays.
     */
    public const DUTCH_BANK_HOLIDAY_SET = [
        self::NEW_YEARS_DAY,
        self::EASTER_MONDAY,
        self::DUTCH_KINGS_DAY,
        self::DUTCH_LIBERATION_DAY,
        self::ASCENSION_DAY,
        self::WHIT_MONDAY,
        self::CHRISTMAS_DAY,
        self::BOXING_DAY,
    ];

    /**
     * @codeCoverageIgnore private by design because this is an ENUM class
     */
    private function __construct()
    {
    }
}
