<?php
require_once './date.php';
require_once './validate.php';

class Calculations
{
    const MONTH = (365 + 365 + 365 + 366) / (4 * 12);
    private $months = [1 => 31, 2 => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31];
    private $first;
    private $second;
    public $validate;

    public function __construct($first, $second)
    {
        $this->validate = new Validate();
        $this->validate->isCorrectData($first, $second);
        $this->first = $this->validate->arrayWithDate($first);
        $this->second = $this->validate->arrayWithDate($second);
    }

    /**
     * @param $year
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
     * @param $year
     * @param $month
     * @param $days
     * @return int
     */
    public function daysWithStartYear($year, $month, $days)
    {
        $count = $days;
        for($i = 1; $i < $month; $i++){
            $count += $this->months[$i];
            if($i === 2 && $this->validate->ifLeapYear($year)){
                $count += 1;
            }
        }
        return $count;
    }

    /**
     * @return int
     */
    public function getTotalDayInFirst()
    {
        return $this->daysInYear($this->first[0]) + $this->daysWithStartYear($this->first[0], $this->first[1], $this->first[2]);
    }

    /**
     * @return int
     */
    public function getTotalDayInSecond()
    {
        return $this->daysInYear($this->second[0]) + $this->daysWithStartYear($this->second[0], $this->second[1], $this->second[2]);
    }
}