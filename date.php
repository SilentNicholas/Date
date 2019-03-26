<?php
if(!$argc = 3){
    die (PHP_EOL. 'USE: php date.php YYYY-MM-DD YYYY-MM-DD!'. PHP_EOL);
}
$first = $argv[1];
$second = $argv[2];

require_once './validate.php';
require_once './calculations.php';

class Date
{
    const MONTH = (365 + 365 + 365 + 366) / (4 * 12);
    private $calculations;

    /**
     * Date constructor.
     * @param string $first
     * @param string $second
     * @throws Exception
     */
    public function __construct($first, $second)
    {
        $this->calculations = new Calculations($first, $second);
    }

    /**
     * @return int
     */
    public function getMonths()
    {
        return floor($this->getTotalDiffDays() / self::MONTH) -  ($this->getYears() * 12);
    }

    /**
     * @return int
     */
    public function getYears()
    {
        $days = $this->getTotalDiffDays();
        $i = 0;
        while ($days > 364) {
            $days -= 365;
            $i++;
            if ($this->calculations->validate->ifLeapYear($i)) {
                $days -= 1;
            }
        }
        return $i;
    }

    /**
     * @return int
     */
    public function getDays()
    {
        return round(((($this->getTotalDiffDays() / self::MONTH) -  ($this->getYears() * 12)) - $this->getMonths()) * self::MONTH);
    }

    /**
     * @param array $array
     * @return int
     */
    public function getTotalDaysInDate($array)
    {
        return $this->calculations->daysInYear($array[0]) + $this->calculations->daysWithStartYear($array[0], $array[1], $array[2]);
    }

    /**
     * @return int
     */
    public function getTotalDiffDays()
    {
        return abs($this->getTotalDaysInDate($this->calculations->getFirstDate()) -
            $this->getTotalDaysInDate($this->calculations->getSecondDate()));
    }

    /**
     * @return bool
     */
    public function whichDateGreater()
    {
        return $this->getTotalDaysInDate($this->calculations->getFirstDate()) > $this->getTotalDaysInDate($this->calculations->getSecondDate());
    }

    /**
     * Take you two date difference.
     */
    public function getTotalDiff()
    {
        echo 'Years: ' . $this->getYears() . PHP_EOL . 'Months: '. $this->getMonths() . PHP_EOL . 'Days: '. $this->getDays().
            PHP_EOL . 'Total Days: ' . $this->getTotalDiffDays() . PHP_EOL . 'Date of start greater: ' . $this->whichDateGreater();
    }
}

$date = new Date( $first, $second);
$date->getTotalDiff();