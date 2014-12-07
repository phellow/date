<?php
namespace Phellow\Date;

/**
 * @author    Christian Blos <christian.blos@gmx.de>
 * @copyright Copyright (c) 2014-2015, Christian Blos
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @link      https://github.com/phellow/date
 */
class DateTime extends \DateTime
{

    /**
     * Set the timezone.
     *
     * If null, set default timezone via date_default_timezone_get().
     *
     * @param \DateTimeZone|string|null $timezone
     * @param bool                      $keepDateAndTime
     *
     * @return void
     */
    public function setTimezone($timezone = null, $keepDateAndTime = false)
    {
        if ($timezone === null) {
            $timezone = new \DateTimeZone(date_default_timezone_get());
        } elseif (is_string($timezone)) {
            $timezone = new \DateTimeZone($timezone);
        }

        if ($keepDateAndTime) {
            $year = $this->format('Y');
            $month = $this->format('n');
            $day = $this->format('j');
            $hour = $this->format('G');
            $minute = $this->format('i');
            $second = $this->format('s');
            parent::setTimezone($timezone);
            $this->setDate($year, $month, $day);
            $this->setTime($hour, $minute, $second);
        } else {
            parent::setTimezone($timezone);
        }
    }

    /**
     * Check if datetime is in future.
     *
     * @param \DateTime $now Check relative to this datetime.
     *
     * @return bool
     */
    public function isInFuture(\DateTime $now = null)
    {
        if (!$now) {
            $now = new \DateTime();
        }
        return $this->getTimestamp() > $now->getTimestamp();
    }

    /**
     * Check if given time is in past.
     *
     * @param \DateTime $now Check relative to this datetime.
     *
     * @return bool
     */
    public function isInPast(\DateTime $now = null)
    {
        if (!$now) {
            $now = new \DateTime();
        }
        return $this->getTimestamp() < $now->getTimestamp();
    }

    /**
     * Get the next timezone transitions.
     *
     * This will return an array with the following information for each transition:
     * Array (
     *     [ts] => 1396141200
     *     [time] => 2014-03-30T01:00:00+0000
     *     [offset] => 7200
     *     [isdst] => 1
     *     [abbr] => CEST
     * )
     *
     * @param mixed $number The number of returned transitions.
     *
     * @return array
     */
    public function getNextTimezoneTransitions($number = 1)
    {
        $transitions = $this->getTimeZone()->getTransitions($this->getTimestamp());
        return array_splice($transitions, 1, $number);
    }
}
