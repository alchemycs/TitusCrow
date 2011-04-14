<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCRangeEveryYearTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testFullRange() {
    $expression = new TCRangeEveryYearTemporalExpression(1, 5, 3,20); //5th Jan - 20th March
    $this->assertTrue($expression->includes(TCDate::getInstance('5th January 1972'))); //lower boundary
    $this->assertTrue($expression->includes(TCDate::getInstance('20th March 1972'))); //upper boundary
    $this->assertTrue($expression->includes(TCDate::getInstance('28th February 1972'))); //mid range
    $this->assertFalse($expression->includes(TCDate::getInstance('1st January 1972'))); //below range
    $this->assertFalse($expression->includes(TCDate::getInstance('31st December 1972'))); //above range
  }

  public function testSingleDayOfMonth() {
      $expression = new TCRangeEveryYearTemporalExpression(1, 1, 26, 26); //Australia day
      $this->assertTrue($expression->includes(TCDate::getInstance("26th January 2012")), "Should include same day in month");
      $this->assertFalse($expression->includes(TCDate::getInstance("25th January 2012")), "Should not include different day in same month");
      $this->assertFalse($expression->includes(TCDate::getInstance("26th February 2012")), "Should not include same day in different month");
      $this->assertFalse($expression->includes(TCDate::getInstance("25th February 2012")), "Should not include different day in different month");
  }

  public function testRangeInSingleMonth() {
      $this->markTestIncomplete("Need to test range in a single month");
  }

  public function testWrappedRangeInSingleMonth() {
      $this->markTestIncomplete("Need to test wrapped range in a single month");
  }

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
    $expression = new TCRangeEveryYearTemporalExpression(11, 2);
    $this->assertTrue($expression->includes(TCDate::getInstance('15th December 2011')));
    $this->assertTrue($expression->includes(TCDate::getInstance('15th January 2011')));
    $this->assertFalse($expression->includes(TCDate::getInstance('15th October 2011')));
    $this->assertFalse($expression->includes(TCDate::getInstance('15th March 2011')));
  }

  public function testWrappedFullRange() {
    $expression = new TCRangeEveryYearTemporalExpression(11, 2, 15, 15);
    $this->assertTrue($expression->includes(TCDate::getInstance('15th December 2011'))); //Inside lower range
    $this->assertTrue($expression->includes(TCDate::getInstance('15th January 2011'))); //Inside upper range
    $this->assertTrue($expression->includes(TCDate::getInstance('15th November 2011'))); //Lower boundary
    $this->assertTrue($expression->includes(TCDate::getInstance('15th February 2011'))); //Upper boundary
    $this->assertFalse($expression->includes(TCDate::getInstance('1st November 2011'))); //Outside lower range
    $this->assertFalse($expression->includes(TCDate::getInstance('16th February 2011'))); //Outsid upper range
  }


}

?>