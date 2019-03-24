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
    private $calculations;

    /**
     * Date constructor.
     * @param $first
     * @param $second
     * @throws Exception
     */
    public function __construct($first, $second)
    {
        $this->calculations = new Calculations($first, $second);
    }

    /**
     * Take you two date difference.
     */
    public function getReadyData()
    {
        echo 'Years: ' . $this->getYears() . PHP_EOL . 'Months: '. $this->getMonths() . PHP_EOL . 'Days: '. $this->getDays().
            PHP_EOL . 'Total Days: ' . $this->getTotalDays() . PHP_EOL . 'Date of start greater: ' . $this->whichDateGreater();
    }

    /**
     * @return int
     */
    public function getYears()
    {
        $days = $this->getTotalDays();
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
    public function getMonths()
    {
        return floor($this->getTotalDays() / Calculations::MONTH) -  ($this->getYears() * 12);
    }


    /**
     * @return int
     */
    public function getDays()
    {
        return round(((($this->getTotalDays() / Calculations::MONTH) -  ($this->getYears() * 12)) - $this->getMonths()) * Calculations::MONTH);
    }

    /**
     * @return int
     */
    public function getTotalDays()
    {
        return abs($this->calculations->getTotalDayInSecond() - $this->calculations->getTotalDayInFirst());
    }

    /**
     * @return bool
     */
    private function whichDateGreater()
    {
        if($this->calculations->getTotalDayInFirst() > $this->calculations->getTotalDayInSecond()){
            return 'True';
        }else{
            return 'False';
        }
    }
}

$date = new Date( $first, $second);
$date->getReadyData();