<?php
namespace Phellow\Date;

/**
 *
 */
class DateFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateFactory
     */
    private $factory;

    /**
     *
     */
    protected function setUp()
    {
        $this->factory = new DateFactory();
    }

    /**
     *
     */
    public function testCreateDateTimeWithoutParams()
    {
        $dt = $this->factory->createDateTime();

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals(time(), $dt->getTimestamp());
    }

    /**
     *
     */
    public function testCreateDateTimeFromString()
    {
        $dt = $this->factory->createDateTime('now');

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals(time(), $dt->getTimestamp());

        $dt = $this->factory->createDateTime('1987-06-18');

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals('1987-06-18', $dt->format('Y-m-d'));
    }

    /**
     *
     */
    public function testCreateDateTimeFromInt()
    {
        $dt = $this->factory->createDateTime(551009472);

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals(551009472, $dt->getTimestamp());

        $dt = $this->factory->createDateTime(0);

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals('1970-01-01', $dt->format('Y-m-d'));
    }

    /**
     *
     */
    public function testCreateDateTimeFromDateTime()
    {
        $fromDt = new \DateTime('2013-03-08', new \DateTimeZone('Indian/Mahe'));
        $dt = $this->factory->createDateTime($fromDt);

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals('2013-03-08', $dt->format('Y-m-d'));
        $this->assertEquals('Indian/Mahe', $dt->getTimezone()->getName());


        $fromDt = new DateTime('1987-06-18', new \DateTimeZone('Europe/Berlin'));
        $dt = $this->factory->createDateTime($fromDt);

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals('1987-06-18', $dt->format('Y-m-d'));
        $this->assertEquals('Europe/Berlin', $dt->getTimezone()->getName());
        $this->assertNotSame($fromDt, $dt);
    }

    /**
     *
     */
    public function testCreateDateTimeFromMonth()
    {
        $month = new Month(new \DateTime('2013-03-08', new \DateTimeZone('Indian/Mahe')));
        $dt = $this->factory->createDateTime($month);

        $this->assertInstanceOf('Phellow\Date\DateTime', $dt);
        $this->assertEquals('2013-03-01 00:00:00', $dt->format('Y-m-d H:i:s'));
        $this->assertEquals(date_default_timezone_get(), $dt->getTimezone()->getName());
    }

    /**
     *
     */
    public function testCreateDateTimeWithTimezone()
    {
        $dt = $this->factory->createDateTime(null, 'Indian/Mahe');
        $this->assertEquals('Indian/Mahe', $dt->getTimezone()->getName());

        $dt = $this->factory->createDateTime(null, new \DateTimeZone('Indian/Mahe'));
        $this->assertEquals('Indian/Mahe', $dt->getTimezone()->getName());

        $dt = $this->factory->createDateTime(time(), 'Europe/Berlin');
        $this->assertEquals('Europe/Berlin', $dt->getTimezone()->getName());

        $dt = $this->factory->createDateTime(new \DateTime('now', new \DateTimeZone('UTC')), 'Pacific/Fiji');
        $this->assertEquals('Pacific/Fiji', $dt->getTimezone()->getName());
    }

    /**
     *
     */
    public function testCreateMonthWithoutParams()
    {
        $month = $this->factory->createMonth();
        $this->assertInstanceOf('Phellow\Date\Month', $month);
        $this->assertEquals(date('Y-m'), $month->getValue());
    }

    /**
     *
     */
    public function testCreateMonthFromString()
    {
        $month = $this->factory->createMonth('2013-03-08');
        $this->assertInstanceOf('Phellow\Date\Month', $month);
        $this->assertEquals('2013-03', $month->getValue());
    }

    /**
     *
     */
    public function testCreateMonthFromInt()
    {
        $month = $this->factory->createMonth(time());
        $this->assertInstanceOf('Phellow\Date\Month', $month);
        $this->assertEquals(date('Y-m'), $month->getValue());
    }

    /**
     *
     */
    public function testCreateMonthFromMonth()
    {
        $fromMonth = new Month(new \DateTime('1987-06-18'));

        $month = $this->factory->createMonth($fromMonth);
        $this->assertInstanceOf('Phellow\Date\Month', $month);
        $this->assertEquals('1987-06', $month->getValue());
        $this->assertNotSame($fromMonth, $month);
    }

    /**
     *
     */
    public function testGetTimeZoneName()
    {
        $this->assertEquals('Europe/Berlin', $this->factory->getTimeZoneName('Europe/Berlin'));
        $this->assertEquals('Europe/Paris', $this->factory->getTimeZoneName('+01:00'));
        $this->assertEquals('Europe/Paris', $this->factory->getTimeZoneName(3600));
        $this->assertEquals('Europe/Berlin', $this->factory->getTimeZoneName('cest'));
        $this->assertNull($this->factory->getTimeZoneName(-7300));
        $this->assertEquals('America/Adak', $this->factory->getTimeZoneName(-36000, 1));
    }
}