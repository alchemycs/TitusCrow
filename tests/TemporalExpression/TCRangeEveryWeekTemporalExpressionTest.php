<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCRangeEveryWeekTemporalExpressionTest extends PHPUnit_Framework_TestCase {


  public function testDayOfWeekMatches() {
      $expression = new TCRangeEveryWeekTemporalExpression(TCDate::DOW_MON);
      $goodDate = new TCDate('11th April 2011'); //Is a Monday
      $badDate = new TCDate('12th April 2011'); //Is a Tuesday
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
      $data[] = array(new TCDate('10th April 2011'), false); //Sunday
      $data[] = array(new TCDate('11th April 2011'), true); //Monday
      $data[] = array(new TCDate('12th April 2011'), true); //Tuesday
      $data[] = array(new TCDate('13th April 2011'), true); //Wednesday
      $data[] = array(new TCDate('14th April 2011'), false); //Thursday
      $data[] = array(new TCDate('15th April 2011'), false); //Friday
      $data[] = array(new TCDate('16th April 2011'), false); //Saturday
      return $data;
  }

  public function provideWrappedDayRange() {
      $data = array();
      $data[] = array(new TCDate('10th April 2011'), true); //Sunday
      $data[] = array(new TCDate('11th April 2011'), true); //Monday
      $data[] = array(new TCDate('12th April 2011'), false); //Tuesday
      $data[] = array(new TCDate('13th April 2011'), false); //Wednesday
      $data[] = array(new TCDate('14th April 2011'), false); //Thursday
      $data[] = array(new TCDate('15th April 2011'), true); //Friday
      $data[] = array(new TCDate('16th April 2011'), true); //Saturday
      return $data;
  }

}


?>