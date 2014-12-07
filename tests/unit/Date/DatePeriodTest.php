<?php
namespace Phellow\Date;

/**
 *
 */
class DatePeriodTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testForeach()
    {
        $start = new \DateTime('first monday of january 2014');
        $interval = \DateInterval::createFromDateString('first monday of next month');
        $end = new DateTime('2014-12-31');

        $period = new DatePeriod($start, $interval, $end);
        $result = [];
        foreach ($period as $dt) {
            /* @var $dt \DateTime */
            $result[] = $dt->format('Y-m-d');
        }

        $expected = [
            '2014-01-06',
            '2014-02-03',
            '2014-03-03',
            '2014-04-07',
            '2014-05-05',
            '2014-06-02',
            '2014-07-07',
            '2014-08-04',
            '2014-09-01',
            '2014-10-06',
            '2014-11-03',
            '2014-12-01',
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @depends testForeach
     */
    public function testGetStatus()
    {
        $start = new \DateTime('first monday of january 2014');
        $interval = \DateInterval::createFromDateString('first monday of next month');
        $end = new DateTime('2014-12-31');

        $period = new DatePeriod($start, $interval, $end);

        $this->assertEquals(DatePeriod::STATUS_PENDING, $period->getStatus(new DateTime('2014-01-01')));
        $this->assertEquals(DatePeriod::STATUS_ACTIVE, $period->getStatus(new DateTime('2014-06-02')));
        $this->assertEquals(DatePeriod::STATUS_INACTIVE, $period->getStatus(new DateTime('2014-06-18')));
        $this->assertEquals(DatePeriod::STATUS_EXPIRED, $period->getStatus(new DateTime('2014-12-31')));
    }

    /**
     * @depends testForeach
     */
    public function testGetStatusInvalid()
    {
        $start = new \DateTime('2014-12-31');
        $interval = \DateInterval::createFromDateString('first monday of next month');
        $end = new DateTime('2014-12-31');

        $period = new DatePeriod($start, $interval, $end);

        $this->assertEquals(DatePeriod::STATUS_INVALID, $period->getStatus(new DateTime('2014-01-01')));
        $this->assertEquals(DatePeriod::STATUS_INVALID, $period->getStatus(new DateTime('2014-06-02')));
        $this->assertEquals(DatePeriod::STATUS_INVALID, $period->getStatus(new DateTime('2014-06-18')));
        $this->assertEquals(DatePeriod::STATUS_INVALID, $period->getStatus(new DateTime('2014-12-31')));
    }
}