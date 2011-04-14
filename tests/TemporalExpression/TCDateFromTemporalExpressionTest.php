<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDateFromTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  protected $expression;
  protected $yesterday;
  protected $today;
  protected $tomorrow;

  public function setUp() {
    $this->expression = new TCDateFromTemporalExpression(new TCDate());
    $this->yesterday = new TCDate(new DateTime('yesterday'));
    $this->today = new TCDate(new DateTime('today'));
    $this->tomorrow = new TCDate(new DateTime('tomorrow'));
  }

  public function testDayBefore() {
    $this->assertFalse($this->expression->includes($this->yesterday));
  }

  public function testSameDay() {
    $this->assertTrue($this->expression->includes($this->today));
  }

  public function testDayAfter() {
    $this->assertTrue($this->expression->includes($this->tomorrow));
  }

}


?>