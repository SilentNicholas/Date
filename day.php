<?php
require_once './date.php';

class Day extends Date
{
    protected $days;
    protected $months = [1 => 31, 2 => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31];


    /**
     * @param $year
     * @return int
     */
    public function daysInYear($year)
    {
        $days = 0;
        for ($i = 1; $i <= $year; $i++) {
            if ($this->ifLeapYear($i)) {
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
            if($i === 2 && $this->ifLeapYear($year)){
                $count += 1;
            }
        }
        return $count;
    }

    /**
     * @return int
     */
    public function getFullDayInFirst()
    {
        return $this->daysInYear($this->first[0]) + $this->daysWithStartYear($this->first[0], $this->first[1], $this->first[2]);
    }

    /**
     * @return int
     */
    public function getFullDayInSecond()
    {
        return $this->daysInYear($this->second[0]) + $this->daysWithStartYear($this->second[0], $this->second[1], $this->second[2]);
    }

    /**
     * @return bool
     */
    protected function whichDateGreater()
    {
        if($this->getFullDayInFirst() > $this->getFullDayInSecond()){
            $third = $this->first;
            $this->first = $this->second;
            $this->second = $third;
            return 'True';
        }else{
            return 'False';
        }
    }

    /**
     * @return int
     */
    public function getDiffDays()
    {
        return abs($this->getFullDayInSecond() - $this->getFullDayInFirst());
    }

}
