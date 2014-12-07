<?php
namespace Phellow\Date;

/**
 * @author    Christian Blos <christian.blos@gmx.de>
 * @copyright Copyright (c) 2014-2015, Christian Blos
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @link      https://github.com/phellow/date
 */
class Month
{

    /**
     * @var \DateTime
     */
    private $datetime = null;

    /**
     * @param \DateTime $datetime
     */
    public function __construct(\DateTime $datetime)
    {
        $this->datetime = clone $datetime;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->datetime->format('Y-m');
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return (int)$this->datetime->format('Y');
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return (int)$this->datetime->format('m');
    }

    /**
     * @param int $number
     *
     * @return void
     */
    public function addMonth($number = 1)
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('number can not be lower than 0');
        }
        $this->datetime->modify('+' . (int)$number . ' month');
    }

    /**
     * @param int $number
     *
     * @return void
     */
    public function subMonth($number = 1)
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('number can not be lower than 0');
        }
        $this->datetime->modify('-' . (int)$number . ' month');
    }

    /**
     * @param int $number
     *
     * @return void
     */
    public function addYear($number = 1)
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('number can not be lower than 0');
        }
        $this->datetime->modify('+' . (int)$number . ' year');
    }

    /**
     * @param int $number
     *
     * @return void
     */
    public function subYear($number = 1)
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('number can not be lower than 0');
        }
        $this->datetime->modify('-' . (int)$number . ' year');
    }

    /**
     * Get the distance between this and the given month.
     *
     * @param Month $month
     *
     * @return int Number of months
     */
    public function getDistance(Month $month)
    {
        $yd = $this->getYear() - $month->getYear();
        $md = $this->getMonth() - $month->getMonth();
        return ($yd * 12 + $md) * -1;
    }
}
