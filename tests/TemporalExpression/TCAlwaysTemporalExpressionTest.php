<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCAlwaysTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testTrueForNow() {
    $TCDate = new TCDate();
    $expression = new TCAlwaysTemporalExpression();
    $this->assertTrue($expression->includes($TCDate));
  }

  public function testTrueForYesterday() {
    $TCDate = new TCDate(new DateTime('yesterday'));
    $expression = new TCAlwaysTemporalExpression();
    $this->assertTrue($expression->includes($TCDate));
  }

  public function testTrueForTomorrow() {
    $TCDate = new TCDate(new DateTime('tomorrow'));
    $expression = new TCAlwaysTemporalExpression();
    $this->assertTrue($expression->includes($TCDate));
  }

}


?>