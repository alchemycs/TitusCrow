<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCNeverTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testFalseForNow() {
    $TCDate = TCDate::getInstance();
    $expression = new TCNeverTemporalExpression();
    $this->assertFalse($expression->includes($TCDate));
  }

  public function testFalseForYesterday() {
    $TCDate = TCDate::getInstance(new DateTime('yesterday'));
    $expression = new TCNeverTemporalExpression();
    $this->assertFalse($expression->includes($TCDate));
  }

  public function testFalseForTomorrow() {
    $TCDate = TCDate::getInstance(new DateTime('tomorrow'));
    $expression = new TCNeverTemporalExpression();
    $this->assertFalse($expression->includes($TCDate));
  }

}


?>