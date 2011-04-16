<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCAlwaysTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testTrueForNow() {
    $TCDate = TCDate::getInstance();
    $expression = new TCAlwaysTemporalExpression();
    $this->assertTrue($expression->includes($TCDate));
  }

  public function testTrueForYesterday() {
    $TCDate = TCDate::getInstance(new DateTime('yesterday'));
    $expression = new TCAlwaysTemporalExpression();
    $this->assertTrue($expression->includes($TCDate));
  }

  public function testTrueForTomorrow() {
    $TCDate = TCDate::getInstance(new DateTime('tomorrow'));
    $expression = new TCAlwaysTemporalExpression();
    $this->assertTrue($expression->includes($TCDate));
  }

}


?>