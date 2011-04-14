<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDifferenceTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testDifference() {
    $temporalSpan = new TCDateBetweenTemporalExpression(new TCDate('2 days ago'), new TCDate('+2 days'));
    $temporalException = new TCDateEqualsTemporalExpression(new TCDate('tomorrow'));
    $expression = new TCDifferenceTemporalExpression($temporalSpan, $temporalException);

    $this->assertFalse($expression->includes(new TCDate('3 days ago')));
    $this->assertFalse($expression->includes(new TCDate('+ 3days')));
    $this->assertTrue($expression->includes(new TCDate('2 days ago')));
    $this->assertTrue($expression->includes(new TCDate('yesterday')));
    $this->assertTrue($expression->includes(new TCDate('today')));
    $this->assertFalse($expression->includes(new TCDate('tomorrow')));
    $this->assertTrue($expression->includes(new TCDate('+2 days')));

  }

}

?>