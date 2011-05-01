<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCScheduleTest extends PHPUnit_Framework_TestCase {

    protected $schedule;

    public function setUp() {
        $this->schedule = new TCSchedule();
    }
    
    public function testNewEmptySchedule() {
        $this->assertInstanceOf('TCSchedule', $this->schedule);
        $this->assertEquals(0, $this->schedule->count());
    }

    public function testCountableInterface() {
        $this->assertEquals(0, count($this->schedule));
    }

    public function testNonEmptyScheduleConstructor() {
        $events = array();
        $events[] = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $events[] = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCRangeEveryMonthTemporalExpression(1));
        $schedule = new TCSchedule($events);
        $this->assertEquals(count($schedule), count($events));
    }

    public function testAddEvent() {
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->assertEquals(0, count($this->schedule));
        $this->schedule->add($event);
        $this->assertEquals(1, count($this->schedule));
        $this->schedule->add($event);
        $this->assertEquals(1, count($this->schedule), 'Adding the same scheduled event should overwrite the previous one');
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event2);
        $this->assertEquals(2, count($this->schedule));
    }

    public function testClearEvents() {
        $this->assertEquals(count($this->schedule), 0);
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event2);
        $this->assertEquals(2, count($this->schedule));
        $this->schedule->clear();
        $this->assertEquals(0, count($this->schedule));
    }

    public function testRemoveEvents() {
        $this->assertEquals(0, count($this->schedule));
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event2);
        $this->assertEquals(2, count($this->schedule));
        $this->schedule->remove($event);
        $this->assertEquals(1, count($this->schedule));
        $this->schedule->remove($event2);
        $this->assertEquals(0, count($this->schedule));
    }

    public function testIsOccuring() {
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCDateEqualsTemporalExpression(TCDate::getInstance('23rd March 2009')));
        $this->schedule->add($event2);
        $event3 = new TCScheduledEvent(new TCSimpleEvent('Non Existing'), new TCAlwaysTemporalExpression());
        $this->assertTrue($this->schedule->isOccuring($event->getEvent(), TCDate::getInstance()));
        $this->assertFalse($this->schedule->isOccuring($event3->getEvent(), TCDate::getInstance()));
        $this->assertTrue($this->schedule->isOccuring($event2->getEvent(), TCDate::getInstance('23rd March 2009')));
        $this->assertFalse($this->schedule->isOccuring($event2->getEvent(), TCDate::getInstance('24th March 2009')));
        $this->assertTrue($this->schedule->isOccuring(new TCSimpleEvent('Second'), TCDate::getInstance('23rd March 2009')));
        $this->assertFalse($this->schedule->isOccuring(new TCSimpleEvent('Second'), TCDate::getInstance('24th March 2009')));
    }

    public function testEventsForDate() {
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCDateEqualsTemporalExpression(TCDate::getInstance('23rd March 2009')));
        $this->schedule->add($event2);

        $events = $this->schedule->eventsForDate(TCDate::getInstance('1st April 1980'));
        $this->assertEquals(1, count($events));

        $events = $this->schedule->eventsForDate(TCDate::getInstance('23rd March 2009'));
        $this->assertEquals(2, count($events));
        $this->assertNotSame($events[0], $events[1]);
    }


}
?>
