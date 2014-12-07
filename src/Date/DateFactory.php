<?php
namespace Phellow\Date;

/**
 * @author    Christian Blos <christian.blos@gmx.de>
 * @copyright Copyright (c) 2014-2015, Christian Blos
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @link      https://github.com/phellow/date
 */
class DateFactory
{

    /**
     * Create DateTime object.
     *
     * @param mixed $value
     * @param mixed $timezone
     *
     * @return DateTime
     */
    public function createDateTime($value = null, $timezone = null)
    {
        if ($timezone && !$timezone instanceof \DateTimeZone) {
            $timezone = new \DateTimeZone($timezone);
        }

        if (is_int($value)) {
            $dt = new DateTime('@' . $value);
            if ($timezone) {
                $dt->setTimezone($timezone);
            }
        } else {
            if ($value === null) {
                $value = 'now';
            } elseif ($value instanceof \DateTime) {
                if (!$timezone) {
                    $timezone = $value->getTimezone();
                }
                $value = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof Month) {
                $value = $value->getValue();
            }

            if ($timezone) {
                $dt = new DateTime($value, $timezone);
            } else {
                $dt = new DateTime($value);
            }
        }

        return $dt;
    }

    /**
     * Create Month object.
     *
     * @param mixed $value
     *
     * @return Month
     */
    public function createMonth($value = null)
    {
        if ($value instanceof Month) {
            $month = clone $value;
        } else {
            $dt = $this->createDateTime($value);
            $month = new Month($dt);
        }
        return $month;
    }

    /**
     * Get a timezone name by the given offset or abbreviation.
     *
     * If the given source value is...
     * - ..a valid timezone, it will be returned unchanged.
     * - ..a numeric value or a string like "+01:00", it will be treated as an offset
     * - ..a string, it will be treated as an abbreviation
     *
     * @param int|string $source Offset or abbreviation.
     * @param int|null   $isDst  See timezone_name_from_abbr() or null to determine from current time.
     *
     * @return string
     */
    public function getTimeZoneName($source, $isDst = null)
    {
        $offset = null;
        $abbr = null;
        $timezone = null;

        // check if source value is offset
        if (is_numeric($source)) {
            $offset = (int)$source;
        } elseif (preg_match('/^([+-]{1})([0-9]+):([0-9]+)$/', $source, $matches)) {
            $hours = (int)($matches[1] . $matches[2]);
            $min = (int)($matches[1] . $matches[3]);
            $offset = $hours * 3600 + $min * 60;
        }

        // check if source value is abbreviation
        if ($offset === null) {
            if (array_key_exists($source, \DateTimeZone::listAbbreviations())) {
                $abbr = $source;
            }

            // check if source value is timezone
            if ($abbr === null) {
                if (in_array($source, \DateTimeZone::listIdentifiers(\DateTimeZone::ALL_WITH_BC))) {
                    $timezone = $source;
                }
            }
        }

        if (!$timezone) {
            if ($abbr !== null || $offset !== null) {
                if ($isDst === null) {
                    $isDst = date('I');
                }
                $timezone = timezone_name_from_abbr($abbr, $offset, $isDst);
                if (!$timezone) {
                    $timezone = null;
                    // fallback if timezone not found for offset
                    foreach (\DateTimeZone::listAbbreviations() as $abbreviation) {
                        foreach ($abbreviation as $city) {
                            if ($city['dst'] == $isDst && $city['offset'] == $offset && $city['timezone_id']) {
                                $timezone = $city['timezone_id'];
                                break 2;
                            }
                        }
                    }
                }
            }
        }
        return $timezone;
    }
}
