<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCNeverTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testFalseForNow() {
    $TCDate = new TCDate();
    $expression = new TCNeverTemporalExpression();
    $this->assertFalse($expression->includes($TCDate));
  }

  public function testFalseForYesterday() {
    $TCDate = new TCDate(new DateTime('yesterday'));
    $expression = new TCNeverTemporalExpression();
    $this->assertFalse($expression->includes($TCDate));
  }

  public function testFalseForTomorrow() {
    $TCDate = new TCDate(new DateTime('tomorrow'));
    $expression = new TCNeverTemporalExpression();
    $this->assertFalse($expression->includes($TCDate));
  }

}


?>