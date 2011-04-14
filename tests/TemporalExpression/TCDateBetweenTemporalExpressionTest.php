<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDateBetweenTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  protected $expression;

  public function setUp() {
    $this->expression = new TCDateBetweenTemporalExpression(new TCDate(new DateTime('yesterday')), new TCDate(new DateTime('tomorrow')));
  }

  public function testOutOfRange() {
    $this->assertFalse($this->expression->includes(new TCDate(new DateTime('2 days ago'))));
    $this->assertFalse($this->expression->includes(new TCDate(new DateTime('+ 2 days'))));
  }

  public function testInRange() {
    $this->assertTrue($this->expression->includes(new TCDate()));
  }

  public function testDateRetrieval() {
    $this->assertInstanceOf('TCDate', $this->expression->getStartDate());
    $this->assertInstanceOf('TCDate', $this->expression->getFinishDate());
  }

  /**
     @expectedException RangeException
   */
  public function testInvalidRange() {
    $this->expression = new TCDateBetweenTemporalExpression(new TCDate(new DateTime('tomorrow')), new TCDate(new DateTime('yesterday')));
  }

}


?>