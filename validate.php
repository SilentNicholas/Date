<?php
require_once './date.php';
require_once './calculations.php';

class Validate
{
    const FEBRUARY = 2;

    /**
     * Validate constructor.
     * @param string $first
     * @param string $second
     * @throws Exception
     */
    public function __construct($first, $second)
    {
        $this->validate($first, $second);
    }

    /**
     * @param string $year
     * @return bool
     */
    public function ifLeapYear($year)
    {
        return $year % 4 === 0 && !$year % 100 === 0;
    }

    /**
     * @param string $date
     * @return false|int
     */
    private function splitDate($date)
    {
        return preg_match('#^[0-9]{1,}-[0-9]{1,2}-[0-9]{1,2}$#', $date);
    }

    /**
     * @param string $date
     * @return bool|string
     */
    private function getYear($date)
    {
        return substr($date, 0, 4);
    }

    /**
     * @param string $date
     * @return bool|string
     */
    private function getMonth($date)
    {
        return substr($date, 5, 2);
    }

    /**
     * @param string $date
     * @return bool|string
     */
    private function getDay($date)
    {
        return substr($date, 8, 2);
    }

    /**
     * @param string $date
     * @throws Exception
     */
    private function validateMonths($date)
    {
        if($this->getMonth($date) < 1 || $this->getMonth($date) > 12){
            throw new Exception('Invalid month entered!');
        }
    }

    /**
     * @param string $date
     * @throws Exception
     */
    private function validateDaysInLongMonths($date)
    {
        $month = $this->getMonth($date);
        $days = $this->getDay($date);
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12 &&
            $days <= 0 || $days >= 32){
            throw new Exception('Does not exist day in month!');
        }
    }

    /**
     * @param string $date
     * @throws Exception
     */
    private function validateDaysInShortMonths($date)
    {
        $month = $this->getMonth($date);
        $days = $this->getDay($date);
        if($month == 4 || $month == 6 || $month == 9 || $month == 11 && $days < 1 || $days > 30){
            throw new Exception('Does not exist day in month!');
        }
    }


    /**
     * @param string $date
     * @throws Exception
     */
    private function validateLeapFebruary($date)
    {
        $year = $this->getYear($date);
        $month = $this->getMonth($date);
        $days = $this->getDay($date);
        if($this->ifLeapYear($year) && $month == self::FEBRUARY && $days > 29 || $days < 1){
            throw new Exception('Does not exist day in month!');
        }
    }

    /**
     * @param string $date
     * @throws Exception
     */
    private function validateUsualFebruary($date)
    {
        $year = $this->getYear($date);
        $month = $this->getMonth($date);
        $days = $this->getDay($date);
        if($this->ifLeapYear($year) && $month == self::FEBRUARY && $days > 28 || $days < 1){
            throw new Exception('Does not exist day in month!');
        }
    }


    /**
     * @param string $first
     * @param string $second
     * @throws Exception
     */
    private function validate($first, $second)
    {
        if(!$this->splitDate($first) === 1 || !$this->splitDate($second) === 1) {
            throw new Exception('Invalid data entered!');
        }else{
            $this->validateMonths($first);
            $this->validateMonths($second);
            $this->validateDaysInShortMonths($first);
            $this->validateDaysInShortMonths($second);
            $this->validateDaysInLongMonths($first);
            $this->validateDaysInLongMonths($second);
            $this->validateLeapFebruary($first);
            $this->validateLeapFebruary($second);
            $this->validateUsualFebruary($first);
            $this->validateUsualFebruary($second);
        }
    }
}