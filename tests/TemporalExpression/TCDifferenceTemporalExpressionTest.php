<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDifferenceTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testDifference() {
    $temporalSpan = new TCDateBetweenTemporalExpression(TCDate::getInstance('2 days ago'), TCDate::getInstance('+2 days'));
    $temporalException = new TCDateEqualsTemporalExpression(TCDate::getInstance('tomorrow'));
    $expression = new TCDifferenceTemporalExpression($temporalSpan, $temporalException);

    $this->assertFalse($expression->includes(TCDate::getInstance('3 days ago')));
    $this->assertFalse($expression->includes(TCDate::getInstance('+ 3days')));
    $this->assertTrue($expression->includes(TCDate::getInstance('2 days ago')));
    $this->assertTrue($expression->includes(TCDate::getInstance('yesterday')));
    $this->assertTrue($expression->includes(TCDate::getInstance('today')));
    $this->assertFalse($expression->includes(TCDate::getInstance('tomorrow')));
    $this->assertTrue($expression->includes(TCDate::getInstance('+2 days')));

  }

}

?>