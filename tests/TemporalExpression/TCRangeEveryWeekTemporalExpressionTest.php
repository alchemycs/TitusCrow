<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCRangeEveryWeekTemporalExpressionTest extends PHPUnit_Framework_TestCase {


  public function testDayOfWeekMatches() {
      $expression = new TCRangeEveryWeekTemporalExpression(TCDate::DOW_MON);
      $goodDate = TCDate::getInstance('11th April 2011'); //Is a Monday
      $badDate = TCDate::getInstance('12th April 2011'); //Is a Tuesday
      $this->assertTrue($expression->includes($goodDate));
      $this->assertFalse($expression->includes($badDate));
  }

  /**
   * @dataProvider provideSimpleDayRange
   */
  public function testSimpleDayRange($date, $validity) {
      $expression = new TCRangeEveryWeekTemporalExpression(TCDate::DOW_MON, TCDate::DOW_WED);
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
      $expression = new TCRangeEveryWeekTemporalExpression(TCDate::DOW_FRI, TCDate::DOW_MON);
      if ($validity) {
          $this->assertTrue($expression->includes($date));
      } else {
          $this->assertFalse($expression->includes($date));
      }
  }

  public function provideSimpleDayRange() {
      $data = array();
      $data[] = array(TCDate::getInstance('10th April 2011'), false); //Sunday
      $data[] = array(TCDate::getInstance('11th April 2011'), true); //Monday
      $data[] = array(TCDate::getInstance('12th April 2011'), true); //Tuesday
      $data[] = array(TCDate::getInstance('13th April 2011'), true); //Wednesday
      $data[] = array(TCDate::getInstance('14th April 2011'), false); //Thursday
      $data[] = array(TCDate::getInstance('15th April 2011'), false); //Friday
      $data[] = array(TCDate::getInstance('16th April 2011'), false); //Saturday
      return $data;
  }

  public function provideWrappedDayRange() {
      $data = array();
      $data[] = array(TCDate::getInstance('10th April 2011'), true); //Sunday
      $data[] = array(TCDate::getInstance('11th April 2011'), true); //Monday
      $data[] = array(TCDate::getInstance('12th April 2011'), false); //Tuesday
      $data[] = array(TCDate::getInstance('13th April 2011'), false); //Wednesday
      $data[] = array(TCDate::getInstance('14th April 2011'), false); //Thursday
      $data[] = array(TCDate::getInstance('15th April 2011'), true); //Friday
      $data[] = array(TCDate::getInstance('16th April 2011'), true); //Saturday
      return $data;
  }

}


?>