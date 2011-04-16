<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCRangeEveryYearTemporalExpressionTest extends PHPUnit_Framework_TestCase {


  public function testMonthRange() {
    $expression = new TCRangeEveryYearTemporalExpression(2, 4); //Feb - April
    $this->assertTrue($expression->includes(TCDate::getInstance('1st February 1972'))); //lower boundary
    $this->assertTrue($expression->includes(TCDate::getInstance('30th April 1972'))); //upper boundary
    $this->assertTrue($expression->includes(TCDate::getInstance('28th February 1972'))); //mid range
    $this->assertFalse($expression->includes(TCDate::getInstance('1st January 1972'))); //below range
    $this->assertFalse($expression->includes(TCDate::getInstance('31st December 1972'))); //above range
  }

  public function testSingleMonth() {
    $expression = new TCRangeEveryYearTemporalExpression(5); //May
    $this->assertTrue($expression->includes(TCDate::getInstance('1st May 1972'))); //lower boundary
    $this->assertTrue($expression->includes(TCDate::getInstance('31st May 1972'))); //upper boundary
    $this->assertTrue($expression->includes(TCDate::getInstance('23rd May 1972'))); //mid range
    $this->assertFalse($expression->includes(TCDate::getInstance('30th April 1972'))); //below range
    $this->assertFalse($expression->includes(TCDate::getInstance('1st June 1972'))); //above range
  }

  public function testWrappedMonth() {
    $expression = new TCRangeEveryYearTemporalExpression(11, 2); //November to February
    $this->assertTrue($expression->includes(TCDate::getInstance('15th December 2011')));
    $this->assertTrue($expression->includes(TCDate::getInstance('15th January 2011')));
    $this->assertFalse($expression->includes(TCDate::getInstance('15th October 2011')));
    $this->assertFalse($expression->includes(TCDate::getInstance('15th March 2011')));
  }

}

?>