<?php
require_once './validate.php';

class Date
{
    public $first;
    public $second;
    private $validate;
    public $months = [1=>31, 2=>28, 3=>31, 4=>30, 5=>31, 6=>30, 7=>31, 8=>31, 9=>30, 10=>31, 11=>30, 12=>31];

    /**
     * Date constructor.
     * @param $first
     * @param $second
     */
    public function __construct($first, $second)
    {
        $this->validate = new Validate($first, $second);
        $this->first = $this->validate->first;
        $this->second = $this->validate->second;
    }

    public function getReadyData()
    {
        echo 'Years: ' . $this->getDiffYears() . PHP_EOL . 'Months: '. $this->getDiffMonths() . PHP_EOL . 'Days: ' . PHP_EOL . 'Total Days: ' .
            $this->getDiffDays() . PHP_EOL . 'If date of start greater(bool): ' . $this->whichDateGreater();
    }

    public function getDiffMonths()
    {
        return $this->getMonths(abs($this->getFullDayInSecond() - $this->daysInYear($this->first[0])));
    }

    public function getMonths($days)
    {
        $count = 0;
        $i = 0;
        foreach($this->months as $month){
            while($count < $days){
                $count += $month;
                $i++;
                if($this->validate->ifLeapYear(($i / 12))){
                    $count += 1;
                }
            }
        }
        return $i;
    }

    public function getDiffYears()
    {
        $days = $this->getDiffDays();
        $i = 0;
        while ($days > 364) {
            $days -= 365;
            $i++;
            if ($this->validate->ifLeapYear($i)) {
                $days -= 1;
            }
        }
        return $i;
    }

    public function getDiffDays()
    {
        return abs($this->getFullDayInSecond() - $this->getFullDayInFirst());
    }

    public function getFullDayInSecond()
    {
        return $this->daysInYear($this->second[0]) + $this->daysWithStartYear($this->second[0], $this->second[1], $this->second[2]);
    }

    public function getFullDayInFirst()
    {
        return $this->daysInYear($this->first[0]) + $this->daysWithStartYear($this->first[0], $this->first[1], $this->first[2]);
    }

    public function daysInYear($year)
    {
        $days = 0;
        for ($i = 1; $i <= $year; $i++) {
            if ($this->validate->ifLeapYear($i)) {
                $days += 366;
            } else {
                $days += 365;
            }
        }
        return $days;
    }

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
     * @return bool
     */
    private function whichDateGreater()
    {
        if($this->getFullDayInFirst() > $this->getFullDayInSecond()){
            return True;
        }else{
            return False;
        }
    }


}

var_dump((new Date('0001-03-30', '0001-05-20'))->getDiffMonths());
