<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDateEqualsTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testIncludes() {
    $TCDateNow = TCDate::getInstance('28 August 1984');
    $TCDateNowAlso = TCDate::getInstance('28 August 1984');
    $expression = new TCDateEqualsTemporalExpression($TCDateNow);
    $this->assertTrue($TCDateNow->equals($expression->getDate()));
    $this->assertTrue($expression->includes($TCDateNow));
    $this->assertTrue($expression->includes($TCDateNowAlso));
  } 

  public function testNotIncludes() {
    $TCDateNow = TCDate::getInstance();
    $TCDateTomorrow = TCDate::getInstance(new DateTime('tomorrow'));
    $this->assertNotSame($TCDateNow, $TCDateTomorrow);
    $this->assertFalse($TCDateNow->equals($TCDateTomorrow));
    $expression = new TCDateEqualsTemporalExpression($TCDateNow);
    $this->assertFalse($expression->includes($TCDateTomorrow));
  } 



}


?>