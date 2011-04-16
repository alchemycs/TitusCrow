<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDayInMonthTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  /**
   * @dataProvider providePositiveDayInMonth()
   */
  public function testPositiveDayInMonth($dateString, $dayOfWeek, $count) {
    $date = TCDate::getInstance($dateString);
    $expression = new TCDayInMonthTemporalExpression($dayOfWeek, $count);
    $this->assertTrue($expression->includes($date));
    $expression = new TCDayInMonthTemporalExpression($dayOfWeek, ($count+1)%4+1);
    $this->assertFalse($expression->includes($date));
  }

  public function providePositiveDayInMonth() {
    $testData = array();
    for ($index=0; $index < 100; $index++) {
      $year = mt_rand(1970, 2020);
      $month = mt_rand(1, 12);
      $day = mt_rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
      $dateString = sprintf("%s-%s-%s", $year, $month, $day);
      $timestamp = strtotime($dateString);
      $dateInfo = getdate($timestamp);
      $dayOfWeek = $dateInfo['wday'];
      $week = (int)(($day-1)/7+1);
      $testData[] = array($dateString, $dayOfWeek, $week);
    }
    return $testData;    
  }

  /**
   * @dataProvider provideNegativeDayInMonth
   */
  public function testNegativeDayInMonth($dateString, $dayOfWeek, $count) {
    $date = TCDate::getInstance($dateString);
    $expression = new TCDayInMonthTemporalExpression($dayOfWeek, $count);
    $this->assertTrue($expression->includes($date));
    $expression = new TCDayInMonthTemporalExpression($dayOfWeek, $count+1);
    $this->assertFalse($expression->includes($date));
  }

  public function provideNegativeDayInMonth() {
    $testData = array();
    for ($index=0; $index < 100; $index++) {
      $year = mt_rand(1970, 2020);
      $month = mt_rand(1, 12);
      $day = mt_rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
      $dateString = sprintf("%s-%s-%s", $year, $month, $day);
      $timestamp = strtotime($dateString);
      $dateInfo = getdate($timestamp);
      $dayOfWeek = $dateInfo['wday'];
      $dayFromEnd = cal_days_in_month(CAL_GREGORIAN, $month, $year)-$day + 1;
      $week = (int)-(($dayFromEnd-1)/7+1);
      $testData[] = array($dateString, $dayOfWeek, $week);
    }
    return $testData;    
  }


}


?>