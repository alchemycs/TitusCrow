<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCNotTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testNotForAlways() {
    $TCDate = new TCDate();
    $alwaysExpression = new TCAlwaysTemporalExpression();
    $notAlwaysExpression = new TCNotTemporalExpression($alwaysExpression);
    $this->assertTrue($alwaysExpression->includes($TCDate));
    $this->assertFalse($notAlwaysExpression->includes($TCDate));
  }

  public function testNotForNever() {
    $TCDate = new TCDate();
    $neverExpression = new TCNeverTemporalExpression();
    $notNeverExpression = new TCNotTemporalExpression($neverExpression);
    $this->assertFalse($neverExpression->includes($TCDate));
    $this->assertTrue($notNeverExpression->includes($TCDate));
  }

}


?>