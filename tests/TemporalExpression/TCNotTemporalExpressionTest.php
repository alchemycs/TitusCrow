<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCNotTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testNotForAlways() {
    $TCDate = TCDate::getInstance();
    $alwaysExpression = new TCAlwaysTemporalExpression();
    $notAlwaysExpression = new TCNotTemporalExpression($alwaysExpression);
    $this->assertTrue($alwaysExpression->includes($TCDate));
    $this->assertFalse($notAlwaysExpression->includes($TCDate));
  }

  public function testNotForNever() {
    $TCDate = TCDate::getInstance();
    $neverExpression = new TCNeverTemporalExpression();
    $notNeverExpression = new TCNotTemporalExpression($neverExpression);
    $this->assertFalse($neverExpression->includes($TCDate));
    $this->assertTrue($notNeverExpression->includes($TCDate));
  }

}


?>