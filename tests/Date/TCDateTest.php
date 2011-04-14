<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCDateTest extends PHPUnit_Framework_TestCase {

  /*
   * for the dataproviders, we should be using static calculated dates rather than trying to do calculations on random ones
   */

  public function testUnixToJd() {
    $now = time();
    $this->assertEquals(unixtojd($now), TCDate::unixtojd($now));
    $past = new DateTime('23rd May 1923');
    $pastStamp = $past->getTimestamp();
    $this->assertFalse(TCDate::unixtojd($pastStamp), 'Built in unixtojd returns false on pre-unix epoch dates');
  }

  public function testEmptyConstructor() {
    $TCDate = new TCDate();
    $dateTime = $TCDate->toDateTime();
    $this->assertInstanceOf('DateTime', $dateTime);
  }

  public function testDateTimeConstructor() {
    $dateTime = new DateTime();
    $TCDateTime = new TCDate($dateTime);
    $this->assertInstanceOf('DateTime', $TCDateTime->toDateTime());
  }

  public function testStringConstructor() {
    $date = new TCDate('last sunday February 2009');
    $this->assertInstanceOf('TCDate', $date);
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testBadConstructorType() {
    $date = new TCDate(array(1,2,3));
  }

  /**
   * @expectedException Exception
   */
  public function testBadConstructorString() {
    $date = new TCDate('30 seconds after the big bang');
  }

  public function testToDateTime() {
    //Test using an empty constrctor
    $emptyDateConstructor = new TCDate();
    $this->assertInstanceOf('DateTime', $emptyDateConstructor->toDateTime());

    //Also test using a DateTime object in the constructor
    $newDateTime = new DateTime();
    $dateTimeConstructor = new TCDate($newDateTime);
    $this->assertInstanceOf('DateTime', $dateTimeConstructor->toDateTime());
  }

  public function testToString() {
    $TCDate = new TCDate();
    $this->assertNotEmpty($TCDate->__toString());
    //die($TCDate);
  }

  public function testDateEquality() {
    $now = new DateTime();
    $firstDate = new TCDate($now);
    $secondDate = new TCDate($now);
    $this->assertEquals($firstDate, $secondDate);

    // TODO : I think we actually want to turn unique dates into singletons..(or flyweights?)
    //$this->assertSame($firstDate, $secondDate);
  }

  public function testDateCloning() {
    $TCDate = new TCDate();
    $clonedDate = clone $TCDate;
    $this->assertEquals($TCDate, $clonedDate);
    $this->assertNotSame($TCDate, $clonedDate);
  }

  public function testEquals() {
    $now = new DateTime();
    $TCDate1 = new TCDate($now);
    $TCDate2 = new TCDate($now);
    $this->assertTrue($TCDate1->equals($TCDate2));
    //Equality tests are symetrical
    $this->assertTrue($TCDate2->equals($TCDate1));
  }

  public function testNotEquals() {
    $now = new DateTime();
    $TCDate1 = new TCDate(new DateTime('now'));
    $TCDate2 = new TCDate(new DateTime('tomorrow'));
    $this->assertFalse($TCDate1->equals($TCDate2));
    //Equality tests are symetrical
    $this->assertFalse($TCDate2->equals($TCDate1));
  }

  public function testCompareTo() {
    $now = new TCDate();
    $alsoNow = new TCDate();
    $tomorrow = new TCDate(new DateTime('tomorrow'));

    $this->assertTrue($now->compareTo($tomorrow) === -1);
    $this->assertTrue($tomorrow->compareTo($now) === 1);
    $this->assertTrue($now->compareTo($alsoNow) === 0);

  }

  public function testComparitiveImplication() {
    $yesterday = new TCDate(new DateTime('yesterday'));
    $today = new TCDate(new DateTime('today'));
    $tomorrow = new TCDate(new DateTime('tomorrow'));

    $this->assertTrue($yesterday->compareTo($today) == -1);
    $this->assertTrue($today->compareTo($tomorrow) == -1);
    $this->assertTrue($yesterday->compareTo($tomorrow) == -1);

  }

  public function testJulianDay() {
    $date = new DateTime();
    $TCDate = new TCDate($date);
    $julianDay = unixtojd($date->getTimestamp());
    $this->assertEquals($julianDay, $TCDate->toJulianDay());
  }

  public function testTimestamp() {
    $date = new DateTime();
    $TCDate = new TCDate($date);
    $timestamp = $date->getTimestamp(); 
    //Internally we normalize to a julian day so the timestamp will differ
    //We'll just make sure we are getting an integer back
    $this->assertInternalType('integer', $TCDate->toTimestamp());
  }

  /**
   * @dataProvider provideDaysOfWeek
   */
  public function testDayOfWeek($dateString, $dayOfWeek) {
    $TCDate = new TCDate(new DateTime($dateString));
    $this->assertEquals($TCDate->getDayOfWeek(), $dayOfWeek);
  }

  public function provideDaysOfWeek() {
    $testData = array();
    for ($index=0; $index < 100; $index++) {
      $year = mt_rand(1970, 2020);
      $month = mt_rand(1, 12);
      $day = mt_rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
      $dateString = sprintf("%s-%s-%s", $year, $month, $day);
      $timestamp = strtotime($dateString);
      $dateInfo = getdate($timestamp);
      $dayOfWeek = $dateInfo['wday'];
      $testData[] = array($dateString, $dayOfWeek);
    }
    return $testData;
  }

  /**
   * @dataProvider provideWeeksInMonth
   */
  public function testWeekInMonth($dateString, $week) {
    $date = new TCDate(new DateTime($dateString));
    $this->assertEquals($date->getWeekInMonth(), $week);
  }

  public function provideWeeksInMonth() {
    $testData = array();
    for ($index=0; $index < 100; $index++) {
      $year = mt_rand(1970, 2020);
      $month = mt_rand(1, 12);
      $day = mt_rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
      $dateString = sprintf("%s-%s-%s", $year, $month, $day);
      $week = (int)(($day-1)/7+1);
      $testData[] = array($dateString, $week);
    }
    return $testData;
  }

  /**
   * @dataProvider provideDaysLeftInMonth
   */
  public function testGetDaysLeftInMonth($dateString, $daysLeft) {
    $date = new TCDate(new DateTime($dateString));
    $this->assertEquals($date->getDaysLeftInMonth(), $daysLeft);
  }

  public function provideDaysLeftInMonth() {
    $testData = array();
    for ($index=0; $index < 100; $index++) {
      $year = mt_rand(1970, 2020);
      $month = mt_rand(1, 12);
      $day = mt_rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
      $dateString = sprintf("%s-%s-%s", $year, $month, $day);
      $daysLeft = cal_days_in_month(CAL_GREGORIAN, $month, $year) - $day;
      $testData[] = array($dateString, $daysLeft);
    }
    return $testData;
  }

  public function testGetDayOfMonth() {
    $date = new TCDate('23 may 1972');
    $this->assertEquals($date->getDayInMonth(), 23);
  }

  public function testGetMonthOfYear() {
    $date = new TCDate(new DateTime('23rd May 1972'));
    $this->assertEquals($date->getMonthInYear(), 5);
  }

  public function testWithPreUnixEpochDates() {
    $this->markTestIncomplete('Problem with unixtojd() and pre unix epoch dates - always returns false. Need to do something about this');
  }

}

?>