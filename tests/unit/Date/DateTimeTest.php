<?php
namespace Phellow\Date;

/**
 *
 */
class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    protected $defaultTimezone = null;

    /**
     *
     */
    protected function setUp()
    {
        $this->defaultTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
    }

    /**
     *
     */
    protected function tearDown()
    {
        date_default_timezone_set($this->defaultTimezone);
    }

    /**
     *
     */
    public function testSetTimezone()
    {
        $dt = new DateTime('2013-03-08 10:00:00');

        $dt->setTimezone('Europe/Berlin');
        $this->assertEquals('2013-03-08 11:00:00', $dt->format('Y-m-d H:i:s'));
        $this->assertEquals('Europe/Berlin', $dt->getTimezone()->getName());

        $dt->setTimezone(new \DateTimeZone('Indian/Mahe'), true);
        $this->assertEquals('2013-03-08 11:00:00', $dt->format('Y-m-d H:i:s'));
        $this->assertEquals('Indian/Mahe', $dt->getTimezone()->getName());

        $dt->setTimezone(null);
        $this->assertEquals('UTC', $dt->getTimezone()->getName());
    }

    /**
     *
     */
    public function testIsInFuture()
    {
        $dt = new DateTime();

        $dt->modify('+1 hour');
        $this->assertTrue($dt->isInFuture());

        $dt->modify('-2 hour');
        $this->assertFalse($dt->isInFuture());

        $dt = new DateTime('2013-03-08 11:00:00');
        $this->assertTrue($dt->isInFuture(new \DateTime('2013-03-08 10:59:59')));
        $this->assertFalse($dt->isInFuture(new \DateTime('2013-03-08 11:00:01')));
    }

    /**
     *
     */
    public function testIsInPast()
    {
        $dt = new DateTime();

        $dt->modify('-1 hour');
        $this->assertTrue($dt->isInPast());

        $dt->modify('+2 hour');
        $this->assertFalse($dt->isInPast());

        $dt = new DateTime('2013-03-08 11:00:00');
        $this->assertTrue($dt->isInPast(new \DateTime('2013-03-08 11:00:01')));
        $this->assertFalse($dt->isInPast(new \DateTime('2013-03-08 10:59:59')));
    }

    /**
     *
     */
    public function testGetNextTimezoneTransitions()
    {
        $dt = new DateTime('2014-03-01', new \DateTimeZone('Europe/Berlin'));

        $transitions = $dt->getNextTimezoneTransitions();
        $this->assertCount(1, $transitions);

        $expected = array(
            'ts' => 1396141200,
            'time' => '2014-03-30T01:00:00+0000',
            'offset' => 7200,
            'isdst' => 1,
            'abbr' => 'CEST',
        );
        $this->assertEquals($expected, $transitions[0]);

        $transitions = $dt->getNextTimezoneTransitions(2);
        $this->assertCount(2, $transitions);
    }
}