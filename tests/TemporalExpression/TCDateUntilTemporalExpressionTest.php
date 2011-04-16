<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDateUntilTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  protected $expression;
  protected $yesterday;
  protected $today;
  protected $tomorrow;

  public function setUp() {
    $this->expression = new TCDateUntilTemporalExpression(TCDate::getInstance());
    $this->yesterday = TCDate::getInstance(new DateTime('yesterday'));
    $this->today = TCDate::getInstance(new DateTime('today'));
    $this->tomorrow = TCDate::getInstance(new DateTime('tomorrow'));
  }

  public function testDayBefore() {
    $this->assertTrue($this->expression->includes($this->yesterday));
  }

  public function testSameDay() {
    $this->assertTrue($this->expression->includes($this->today));
  }

  public function testDayAfter() {
    $this->assertFalse($this->expression->includes($this->tomorrow));
  }

}


?>