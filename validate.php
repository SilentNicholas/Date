<?php
require_once './date.php';
require_once './calculations.php';

class Validate
{

    /**
     * @param $date
     * @return array
     */
    public function arrayWithDate($date)
    {
        $first = explode('-', $date);
        return $first;
    }

    /**
     * @param $first
     * @param $second
     * @throws Exception
     */
    public function isCorrectData($first, $second)
    {
        if(!preg_match('#^[0-9]{1,}-[0-9]{1,2}-[0-9]{1,2}$#', $first) == 1 ||
            !preg_match('#^[0-9]{1,}-[0-9]{1,2}-[0-9]{1,2}$#', $second) == 1) {
            throw new Exception('Invalid data entered!');
        }else{
            $this->validateYears($first, $second);
            $this->validateFirstMonth($first);
            $this->validateSecondMonth($second);
        }
    }

    /**
     * @param $first
     * @throws Exception
     */
    private function validateFirstMonth($first)
    {
        $first = $this->arrayWithDate($first);
        if($first[1] > 12 || $first[1] < 1) {
            throw new Exception('Month in your first date does not exist!');
        }elseif($first[2] < 1) {
            throw new Exception('Day of month in your first date does not exist!');
        }elseif($first[1] % 2 == 0 && $first[1] !== 8 && $first[2] > 30) {
            throw new Exception('In your first date month has only 30 days!');
        }
    }

    /**
     * @param $second
     * @throws Exception
     */
    private function ValidateSecondMonth($second)
    {
        $second = $this->arrayWithDate($second);
        if($second[1] > 12 || $second[1] < 1) {
            throw new Exception('Month in your second date does not exist!');
        }elseif($second[2] < 1) {
            throw new Exception('Day of month in your second date does not exist!');
        }elseif($second[1] % 2 == 0 && $second[1] !== 8 && $second[2] > 30) {
            throw new Exception('In your second date month has only 30 days!');
        }
    }

    /**
     * @param $first
     * @param $second
     * @throws Exception
     */
    private function validateYears($first, $second)
    {
        $first = $this->arrayWithDate($first);
        $second = $this->arrayWithDate($second);
        if($this->ifLeapYear($first[0]) && $first[1] == 2 && $first[2] > 29){
            throw new Exception('In your first date month has only 29 days!');
        }elseif($this->ifLeapYear($second[0]) && $second[1] == 2 && $second[2] > 29){
            throw new Exception('In your second date month has only 29 days!');
        }elseif(!$this->ifLeapYear($first[0]) && $first[1] == 2 && $first[2] > 28){
            throw new Exception('In your first date month has only 28 days!');
        }elseif(!$this->ifLeapYear($first[0]) && $second[1] == 2 && $second[2] > 28){
            throw new Exception('In your second date month has only 28 days!');
        }
    }

    /**
     * @param $year
     * @return bool
     */
    public function ifLeapYear($year)
    {
        if($year % 4 == 0 && !$year % 100 == 0){
            return True;
        }else{
            return False;
        }
    }
}