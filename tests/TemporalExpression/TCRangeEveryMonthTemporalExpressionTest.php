<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCRangeEveryMonthTemporalExpressionTest extends PHPUnit_Framework_TestCase {


  public function testDayOfMonthMatches() {
      $expression = new TCRangeEveryMonthTemporalExpression(23);
      $goodDate = TCDate::getInstance('23rd May 2011');
      $badDate = TCDate::getInstance('12th April 2011');
      $this->assertTrue($expression->includes($goodDate));
      $this->assertFalse($expression->includes($badDate));
  }

  /**
   * @dataProvider provideSimpleDayRange
   */
  public function testSimpleDayRange($date, $validity) {
      $expression = new TCRangeEveryMonthTemporalExpression(5, 23);
      if ($validity) {
          $this->assertTrue($expression->includes($date));
      } else {
          $this->assertFalse($expression->includes($date));
      }
  }

  /**
   *
   * @dataProvider provideWrappedDayRange
   */
  public function testWrappedDayRange($date, $validity) {
      $expression = new TCRangeEveryMonthTemporalExpression(23, 5);
      if ($validity) {
          $this->assertTrue($expression->includes($date));
      } else {
          $this->assertFalse($expression->includes($date));
      }
  }

  public function provideSimpleDayRange() {
      $data = array();
      $data[] = array(TCDate::getInstance('3rd April 2011'), false);//before range
      $data[] = array(TCDate::getInstance('5th June2011'), true);//lower boundary
      $data[] = array(TCDate::getInstance('19th August 2011'), true);//mid range
      $data[] = array(TCDate::getInstance('23rd December 2011'), true);//upper boundary
      $data[] = array(TCDate::getInstance('24th October 2011'), false);//after range
      return $data;
  }

  public function provideWrappedDayRange() {
      $data = array();
      $data[] = array(TCDate::getInstance('20th April 2011'), false); //before range
      $data[] = array(TCDate::getInstance('23rd January 2011'), true); //lower boundary
      $data[] = array(TCDate::getInstance('31st May 2011'), true); //mid range, end of month
      $data[] = array(TCDate::getInstance('1st April 2011'), true); //mid range, start of month
      $data[] = array(TCDate::getInstance('5th March 2011'), true); //upper boundary
      $data[] = array(TCDate::getInstance('12th July 2011'), false); //after range
      return $data;
  }

}


?>