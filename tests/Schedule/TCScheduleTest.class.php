<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCScheduleTest extends PHPUnit_Framework_TestCase {

    protected $schedule;

    public function setUp() {
        $this->schedule = new TCSchedule();
    }
    
    public function testNewEmptySchedule() {
        $this->assertInstanceOf('TCSchedule', $this->schedule);
        $this->assertEquals($this->schedule->count(), 0);
    }

    public function testCountableInterface() {
        $this->assertEquals(count($this->schedule), 0);
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
        $this->assertEquals(count($this->schedule), 0);
        $this->schedule->add($event);
        $this->assertEquals(count($this->schedule), 1);
        $this->schedule->add($event);
        $this->assertEquals(count($this->schedule), 1, 'Adding the same scheduled event should overwrite the previous one');
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event2);
        $this->assertEquals(count($this->schedule), 2);
    }

    public function testClearEvents() {
        $this->assertEquals(count($this->schedule), 0);
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event2);
        $this->assertEquals(count($this->schedule), 2);
        $this->schedule->clear();
        $this->assertEquals(count($this->schedule), 0);
    }

    public function testRemoveEvents() {
        $this->assertEquals(count($this->schedule), 0);
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event2);
        $this->assertEquals(count($this->schedule), 2);
        $this->schedule->remove($event);
        $this->assertEquals(count($this->schedule), 1);
        $this->schedule->remove($event2);
        $this->assertEquals(count($this->schedule), 0);
    }

    public function testIsOccuring() {
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCDateEqualsTemporalExpression(new TCDate('23rd March 2009')));
        $this->schedule->add($event2);
        $event3 = new TCScheduledEvent(new TCSimpleEvent('Non Existing'), new TCAlwaysTemporalExpression());
        $this->assertTrue($this->schedule->isOccuring($event->getEvent(), new TCDate()));
        $this->assertFalse($this->schedule->isOccuring($event3->getEvent(), new TCDate()));
        $this->assertTrue($this->schedule->isOccuring($event2->getEvent(), new TCDate('23rd March 2009')));
        $this->assertFalse($this->schedule->isOccuring($event2->getEvent(), new TCDate('24th March 2009')));
        $this->assertTrue($this->schedule->isOccuring(new TCSimpleEvent('Second'), new TCDate('23rd March 2009')));
        $this->assertFalse($this->schedule->isOccuring(new TCSimpleEvent('Second'), new TCDate('24th March 2009')));
    }

    public function testEventsForDate() {
        $event = new TCScheduledEvent(new TCSimpleEvent('First'), new TCAlwaysTemporalExpression());
        $this->schedule->add($event);
        $event2 = new TCScheduledEvent(new TCSimpleEvent('Second'), new TCDateEqualsTemporalExpression(new TCDate('23rd March 2009')));
        $this->schedule->add($event2);

        $events = $this->schedule->eventsForDate(new TCDate('1st April 1980'));
        $this->assertEquals(1, count($events));

        $events = $this->schedule->eventsForDate(new TCDate('23rd March 2009'));
        $this->assertEquals(2, count($events));
        $this->assertNotSame($events[0], $events[1]);
    }


}
?>
