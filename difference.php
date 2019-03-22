<?php
if(!$argc = 3){
    die (PHP_EOL. 'USE: php difference.php YYYY-MM-DD YYYY-MM-DD!'. PHP_EOL);
}
$first = $argc[1];
$second = $argc[2];

require_once './date.php';
require_once './day.php';


class Difference extends Day
{
    const MONTH = (365 + 365 + 365 + 366) / (4 * 12);

    /**
     * Difference constructor.
     * @param $first
     * @param $second
     * @throws Exception
     */
    public function __construct($first, $second)
    {
        parent::__construct($first, $second);
    }

    /**
     * @return int
     */
    public function getYears()
    {
        $days = $this->getDiffDays();
        $i = 0;
        while ($days > 364) {
            $days -= 365;
            $i++;
            if ($this->ifLeapYear($i)) {
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
        return floor($this->getDiffDays() / self::MONTH);
    }

    /**
     * @return int
     */
    public function getDays()
    {
        return floor((($this->getDiffDays() / self::MONTH) - $this->getMonths()) * self::MONTH);
    }

    /**
     * Take you two date difference.
     */
    public function getReadyData()
    {
        echo 'Years: ' . $this->getYears() . PHP_EOL . 'Months: '. $this->getMonths() . PHP_EOL . 'Days: '. $this->getDays().
            PHP_EOL . 'Total Days: ' . $this->getDiffDays() . PHP_EOL . 'Date of start greater: ' . $this->whichDateGreater();
    }

}

$diff = new Difference($first, $second);
$diff->getReadyData();
