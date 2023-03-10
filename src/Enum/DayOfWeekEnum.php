<?php

namespace VolodymyrKlymniuk\StdLib\Enum;

class DayOfWeekEnum extends AbstractEnum
{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    /**
     * @return int[]
     */
    public static function getAllowedValues()
    {
        return [self::MONDAY, self::TUESDAY, self::WEDNESDAY, self::THURSDAY, self::FRIDAY, self::SATURDAY, self::SUNDAY];
    }

    /**
     * @return string[]
     */
    public static function getDescriptions(): array
    {
        return [
            self::MONDAY => 'Monday',
            self::TUESDAY => 'Tuesday',
            self::WEDNESDAY => 'Wednesday',
            self::THURSDAY => 'Thursday',
            self::FRIDAY => 'Friday',
            self::SATURDAY => 'Saturday',
            self::SUNDAY => 'Sunday',
        ];
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return DayOfWeekEnum
     */
    public static function createByDateTime(\DateTime $dateTime): DayOfWeekEnum
    {
        $day = (int) $dateTime->format('w');

        return new self(0 === $day ? self::SUNDAY : $day);
    }

    /**
     * @return DayOfWeekEnum
     */
    public static function createToday(): DayOfWeekEnum
    {
        return self::createByDateTime(new \DateTime());
    }
}