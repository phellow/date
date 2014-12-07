<?php
namespace Phellow\Date;

/**
 * @author    Christian Blos <christian.blos@gmx.de>
 * @copyright Copyright (c) 2014-2015, Christian Blos
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @link      https://github.com/phellow/date
 */
class DatePeriod extends \DatePeriod
{

    const STATUS_INVALID = 0;
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_INACTIVE = 3;
    const STATUS_EXPIRED = 4;

    /**
     * Get status of given DateTime inside this period.
     *
     * @param \DateTime $datetime
     *
     * @return int
     */
    public function getStatus(\DateTime $datetime)
    {
        $first = true;
        $currentTs = 0;
        $checkTs = 0;

        foreach ($this as $dt) {
            /* @var $dt \DateTime */
            $currentTs = $dt->getTimestamp();
            $checkTs = $datetime->getTimestamp();

            if ($checkTs === $currentTs) {
                return self::STATUS_ACTIVE;
            } elseif ($first) {
                $first = false;
                if ($checkTs < $currentTs) {
                    return self::STATUS_PENDING;
                }
            }
        }

        if ($checkTs < $currentTs) {
            return self::STATUS_INACTIVE;
        } elseif ($checkTs > $currentTs) {
            return self::STATUS_EXPIRED;
        }

        return self::STATUS_INVALID;
    }
}
