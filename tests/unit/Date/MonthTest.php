<?php
namespace Phellow\Date;

/**
 *
 */
class MonthTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetValue()
    {
        $month = new Month(new \DateTime('1987-06-18'));
        $this->assertEquals('1987-06', $month->getValue());
    }

    /**
     *
     */
    public function testGetYear()
    {
        $month = new Month(new \DateTime('1987-06-18'));
        $this->assertEquals(1987, $month->getYear());
    }

    /**
     *
     */
    public function testGetMonth()
    {
        $month = new Month(new \DateTime('1987-06-18'));
        $this->assertEquals(6, $month->getMonth());
    }

    /**
     * @depends testGetMonth
     */
    public function testAddMonth()
    {
        $month = new Month(new \DateTime('1987-06-18'));

        $month->addMonth();
        $this->assertEquals(7, $month->getMonth());

        $month->addMonth(0);
        $this->assertEquals(7, $month->getMonth());

        $month->addMonth(2);
        $this->assertEquals(9, $month->getMonth());
    }

    /**
     * @depends testGetMonth
     * @expectedException \InvalidArgumentException
     */
    public function testAddMonthInvalid()
    {
        $month = new Month(new \DateTime('1987-06-18'));
        $month->addMonth(-1);
    }

    /**
     * @depends testGetMonth
     */
    public function testSubMonth()
    {
        $month = new Month(new \DateTime('1987-06-18'));

        $month->subMonth();
        $this->assertEquals(5, $month->getMonth());

        $month->subMonth(0);
        $this->assertEquals(5, $month->getMonth());

        $month->subMonth(2);
        $this->assertEquals(3, $month->getMonth());
    }

    /**
     * @depends testGetMonth
     * @expectedException \InvalidArgumentException
     */
    public function testSubMonthInvalid()
    {
        $month = new Month(new \DateTime('1987-06-18'));
        $month->subMonth(-1);
    }

    /**
     * @depends testGetYear
     */
    public function testAddYear()
    {
        $month = new Month(new \DateTime('1987-06-18'));

        $month->addYear();
        $this->assertEquals(1988, $month->getYear());

        $month->addYear(0);
        $this->assertEquals(1988, $month->getYear());

        $month->addYear(2);
        $this->assertEquals(1990, $month->getYear());
    }

    /**
     * @depends testGetYear
     * @expectedException \InvalidArgumentException
     */
    public function testAddYearInvalid()
    {
        $month = new Month(new \DateTime('1987-06-18'));
        $month->addYear(-1);
    }

    /**
     * @depends testGetYear
     */
    public function testSubYear()
    {
        $month = new Month(new \DateTime('1987-06-18'));

        $month->subYear();
        $this->assertEquals(1986, $month->getYear());

        $month->subYear(0);
        $this->assertEquals(1986, $month->getYear());

        $month->subYear(2);
        $this->assertEquals(1984, $month->getYear());
    }

    /**
     * @depends testGetYear
     * @expectedException \InvalidArgumentException
     */
    public function testSubYearInvalid()
    {
        $month = new Month(new \DateTime('1987-06-18'));
        $month->subYear(-1);
    }

    /**
     *
     */
    public function testGetDistance()
    {
        $month1 = new Month(new \DateTime('1987-06-18'));
        $month2 = new Month(new \DateTime('2013-03-08'));

        $this->assertEquals(309, $month1->getDistance($month2));
        $this->assertEquals(-309, $month2->getDistance($month1));
    }
}