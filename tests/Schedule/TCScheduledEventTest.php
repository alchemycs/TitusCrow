<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCScheduledEventTest extends PHPUnit_Framework_TestCase {

  public function testWrongEventWrongDateIsOccuring() {
    $rightEvent = new TCSimpleEvent();
    $wrongEvent = new TCSimpleEvent();
    $expression = new TCNeverTemporalExpression();
    $element = new TCScheduledEvent($rightEvent, $expression);
    $date = TCDate::getInstance();
    $this->assertFalse($element->isOccuring($wrongEvent, $date));
  }

  public function testWrongEventRightDateIsOccuring() {
    $rightEvent = new TCSimpleEvent();
    $wrongEvent = new TCSimpleEvent();
    $expression = new TCAlwaysTemporalExpression();
    $element = new TCScheduledEvent($rightEvent, $expression);
    $date = TCDate::getInstance();
    $this->assertFalse($element->isOccuring($wrongEvent, $date));
  }

  public function testRightEventWrongDateIsOccuring() {
    $rightEvent = new TCSimpleEvent();
    $expression = new TCNeverTemporalExpression();
    $element = new TCScheduledEvent($rightEvent, $expression);
    $date = TCDate::getInstance();
    $this->assertFalse($element->isOccuring($rightEvent, $date));
  }

  public function testRightEventRightDateIsOccuring() {
    $rightEvent = new TCSimpleEvent();
    $expression = new TCAlwaysTemporalExpression();
    $element = new TCScheduledEvent($rightEvent, $expression);
    $date = TCDate::getInstance();
    $this->assertTrue($element->isOccuring($rightEvent, $date));
  }

  public function testGetTemporalExpression() {
      $event = new TCSimpleEvent();
      $expression = new TCAlwaysTemporalExpression();
      $scheduledEvent = new TCScheduledEvent($event, $expression);
      $this->assertSame($expression, $scheduledEvent->getTemporalExpression());
  }
  
  public function testGetEvent() {
      $event = new TCSimpleEvent();
      $expression = new TCAlwaysTemporalExpression();
      $scheduledEvent = new TCScheduledEvent($event, $expression);
      $this->assertSame($event, $scheduledEvent->getEvent());
  }

}


?>