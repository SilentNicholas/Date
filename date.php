<?php

class Date
{
    public $first;
    public $second;

    public function __construct($first, $second)
    {
        $this->isCorrectData($first, $second);
    }

    public function getReadyData()
    {
        echo 'Years: '.$this->getDiffYears(). PHP_EOL. 'Months: '. PHP_EOL. 'Days: '. PHP_EOL. 'Total Days: '.
            $this->getDiffDays();
    }

    public function getDiffMonths()
    {
    }

    public function getDiffYears()
    {
        $days = $this->getDiffDays();
        $i = 0;
        while ($days > 365) {
            $days -= 365;
            $i++;
            if ($this->ifLeapYear($i)) {
                $days -= 1;
            }
        }
        return $i;
    }

    public function getDiffDays()
    {
        return abs($this->getFullDayInFirst() - $this->getFullDayInSecond());
    }

    public function getFullDayInSecond()
    {
        return $this->daysInYear($this->second[0]) + $this->daysInMonth($this->second[0], $this->second[1]) + $this->second[2];
    }

    public function getFullDayInFirst()
    {
        return $this->daysInYear($this->first[0]) + $this->daysInMonth($this->first[0], $this->first[1]) + $this->first[2];
    }

    public function daysInYear($year)
    {
        $days = 0;
        for($i = 1; $i < $year; $i++){
            if($this->ifLeapYear($i)){
                $days += 366;
            }else{
                $days += 365;
            }
        }
        return $days;
    }

    public function daysInMonth($year, $month)
    {
        $days = 0;
        for ($i = 1; $i < $month; $i++) {
            if ($i == 1 || $i == 3 || $i == 5 || $i== 7 || $i == 8 || $i == 10 || $i == 12) {
                $days += 31;
            }elseif($i == 4 || $i == 6 || $i == 9 || $i == 11){
                $days += 30;
            }elseif($i == 2 && $this->ifLeapYear($year)){
                $days += 29;
            }else{
                $days += 28;
            }
        }
        return $days;
    }
    /**
     * @param $first
     * @param $second
     * @throws Exception
     */
    private function isCorrectData($first, $second)
    {
        if(!preg_match('#^[0-9]{1,}-[0-9]{2}-[0-9]{2}$#', $first) == 1 ||
            !preg_match('#^[0-9]{1,}-[0-9]{2}-[0-9]{2}$#', $second) == 1) {
            throw new Exception('Invalid data entered!');
        }else{
            $this->validateYears($first, $second);
            $this->validateFirstMonths($first);
            $this->validateSecondMonths($second);
    }
    }

    /**
     * @param $first
     * @throws Exception
     */
    private function validateFirstMonths($first)
    {
        $first = explode('-', $first);
        if($first[1] > 12 || $first[1] < 1) {
            throw new Exception('Month in your first date does not exist!');
        }elseif($first[2] < 1) {
            throw new Exception('Day of month in your first date does not exist!');
        }elseif($first[1] % 2 == 0 && $first[1] !== 8 && $first[2] > 30) {
            throw new Exception('In your first date month has only 30 days!');
        }else{
            $this->first = $first;
        }
    }

    /**
     * @param $second
     * @throws Exception
     */
    private function ValidateSecondMonths($second)
    {
        $second = explode('-', $second);
        if($second[1] > 12 || $second[1] < 1) {
            throw new Exception('Month in your second date does not exist!');
        }elseif($second[2] < 1) {
            throw new Exception('Day of month in your second date does not exist!');
        }elseif($second[1] % 2 == 0 && $second[1] !== 8 && $second[2] > 30) {
            throw new Exception('In your second date month has only 30 days!');
        }else{
            $this->second = $second;
        }
    }

    /**
     * @param $first
     * @param $second
     * @throws Exception
     */
    private function validateYears($first, $second)
    {
        $first = explode('-', $first);
        $second = explode('-', $second);
        if($first[0] % 4 == 0 && !$first[0] % 100 == 0 && $first[1] == 2 && $first[2] > 29){
            throw new Exception('In your first date month has only 29 days!');
        }elseif($second[0] % 4 == 0 && !$second[0] % 100 == 0 && $second[1] == 2 && $this->second[2] > 29){
            throw new Exception('In your second date month has only 29 days!');
        }elseif($first[1] == 2 && $first[2] > 28){
            throw new Exception('In your first date month has only 28 days!');
        }elseif($second[1] == 2 && $second[2] > 28){
            throw new Exception('In your second date month has only 28 days!');
        }
    }

    public function ifLeapYear($year)
    {
        if($year % 4 == 0 && !$year % 100 == 0){
            return True;
        }else{
            return False;
        }
    }
}
var_dump((new Date('2011-05-29', '2021-01-29'))->getDiffYears());

