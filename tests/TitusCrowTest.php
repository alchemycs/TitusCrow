<?php

require_once(dirname(__FILE__).'/../src/TitusCrow.php');

class TitusCrowTest extends PHPUnit_Framework_TestCase {

  public function testNewSchedule() {
    $schedule = new TCSchedule();
    $this->assertInstanceOf('TCSchedule', $schedule);
  }

}

?>