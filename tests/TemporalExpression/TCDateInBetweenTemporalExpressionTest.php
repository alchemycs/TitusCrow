<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDateInBetweenTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  protected $expression;

  public function setUp() {
    $this->expression = new TCDateInBetweenTemporalExpression(TCDate::getInstance(new DateTime('2 days ago')), TCDate::getInstance(new DateTime('+2 days')));
  }

  public function testOutOfRange() {
    $this->assertFalse($this->expression->includes(TCDate::getInstance(new DateTime('2 days ago'))));
    $this->assertFalse($this->expression->includes(TCDate::getInstance(new DateTime('+ 2 days'))));
  }

  public function testInRange() {
    $this->assertTrue($this->expression->includes(TCDate::getInstance(new DateTime('yesterday'))));
    $this->assertTrue($this->expression->includes(TCDate::getInstance(new DateTime('today'))));
    $this->assertTrue($this->expression->includes(TCDate::getInstance(new DateTime('tomorrow'))));
  }

  public function testDateRetrieval() {
    $this->assertInstanceOf('TCDate', $this->expression->getStartDate());
    $this->assertInstanceOf('TCDate', $this->expression->getFinishDate());
  }

  /**
     @expectedException RangeException
   */
  public function testInvalidRange() {
    $this->expression = new TCDateInBetweenTemporalExpression(TCDate::getInstance(new DateTime('tomorrow')), TCDate::getInstance(new DateTime('yesterday')));
  }


}


?>