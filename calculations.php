<?php
require_once './date.php';
require_once './validate.php';

class Calculations
{
    const FEBRUARY = 2;
    private $months = [1 => 31, self::FEBRUARY => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31];
    private $first;
    private $second;
    public $validate;

    /**
     * Calculations constructor.
     * @param string $first
     * @param string $second
     * @throws Exception
     */
    public function __construct($first, $second)
    {
        $this->validate = new Validate($first, $second);
        $this->first = $this->arrayFromString($first);
        $this->second = $this->arrayFromString($second);
    }

    /**
     * @param string $date
     * @return array
     */
    public function arrayFromString($date)
    {
        return explode('-', $date);
    }

    /**
     * @return array
     */
    public function getFirstDate()
    {
        return $this->first;
    }

    /**
     * @return array
     */
    public function getSecondDate()
    {
        return $this->second;
    }

    /**
     * @param string $year
     * @return int
     */
    public function daysInYear($year)
    {
        $days = 0;
        for ($i = 0; $i < $year; $i++) {
            if ($this->validate->ifLeapYear($i)) {
                $days += 366;
            } else {
                $days += 365;
            }
        }
        return $days;
    }

    /**
     * @param string $year
     * @param string $month
     * @param string $days
     * @return int
     */
    public function daysWithStartYear($year, $month, $days)
    {
        $count = $days;
        for($i = 1; $i < $month; $i++){
            $count += $this->months[$i];
            if($i === self::FEBRUARY && $this->validate->ifLeapYear($year)){
                $count += 1;
            }
        }
        return $count;
    }
}