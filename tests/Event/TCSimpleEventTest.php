<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCSimpleEventTest extends PHPUnit_Framework_TestCase {

  public function testEmptyConstructor() {
    $event = new TCSimpleEvent();
    $this->assertStringStartsWith('Unnamed Event: ', $event->getName());
    $this->assertEquals($event->__toString(), $event->getName());
  }

  public function testStringConstructor() {
    $eventName = "Sample Test Event Name";
    $event = new TCSimpleEvent($eventName);
    $this->assertEquals($eventName, $event->getName());
    $this->assertEquals($eventName, $event->__toString());
    $newEvent = new TCSimpleEvent('New Event');
    $this->assertEquals('New Event', $newEvent->getName());
  }

  public function testEquals() {
      $firstEvent = new TCSimpleEvent('First Event');
      $clonedFirstEvent = clone $firstEvent;
      $secondEvent = new TCSimpleEvent('Second Event');
      $this->assertTrue($firstEvent->equals($firstEvent));
      $this->assertTrue($firstEvent->equals($clonedFirstEvent));
      $this->assertFalse($firstEvent->equals($secondEvent));
  }

}

?>