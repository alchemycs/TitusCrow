<?php
/*
    TitusCrow - A library to manage scheduled events with complex recurrence
    Copyright (C) 2011  Michael McHugh

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * TCDate is the primary class used by the TitusCrow library to represent dates.
 *
 * @package TitusCrow
 * @subpackage Date
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * TCDate is the primary class used by the TitusCrow library to represent dates.
 *
 * @package TitusCrow
 * @subpackage Date
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCDate {

  /** Numeric representation for Sunday */
  const DOW_SUN = 0;
  /** Numeric representation for Monday */
  const DOW_MON = 1;
  /** Numeric representation for Tuesday */
  const DOW_TUE = 2;
  /** Numeric representation for Wednesday */
  const DOW_WED = 3;
  /** Numeric representation for Thursday */
  const DOW_THU = 4;
  /** Numeric representation for Friday */
  const DOW_FRI = 5;
  /** Numeric representation for Saturday */
  const DOW_SAT = 6;

  /**
   * Internal representation of the date given as a julian day
   *
   * @var int
   *
   */
  protected $julianday;

  /**
   * Converts a unix epoch timestamp to a julian day.
   *
   * Currently uses the internal unixtojd() function but we
   * have this stubbed for future use since the
   * internal unixtojd() function returns FALSE for negative
   * timestamps. That is, dates prior to the unix epoch fail.
   *
   * @todo Currently returns internal unixtojd() but we need to
   * fix it to work on pre-unix epoch dates.
   * @param int $timestamp The unix epoch timestamp of the date to convert
   * @return int The julian day of represented by input unix timestamp
   */
  static function unixtojd($timestamp) {
    // @TODO : The built in PHP unixtojd() function fails on dates older than the unix epoch!
    return unixtojd($timestamp);
    $julianday = round(($timestamp/86400 + 2440587.5));
    return $julianday;
  }

  /**
   * Construct a representation of a date from a DateTime object or
   * from a string.
   *
   * When a string is passed it is internally converted to a DateTime object.
   *
   * For the purposes of this library we are only concerned with the day and
   * hence any time information passed into the constructor is not preserved.
   *
   * @param string|DateTime $aDate The date to create this representation.
   */
  public function __construct($aDate = null) {
    if (empty($aDate)) {
      $aDate = new DateTime();
    }
    if (is_string($aDate)) {
      $aDate = new DateTime($aDate);
    } else if (!($aDate instanceof DateTime)) {
      throw new InvalidArgumentException('Constructor parameter must be a date string or a DateTime object');
    }
    $this->julianday = unixtojd($aDate->getTimestamp());
  }

  /**
   * Converts the date represented by this object to a native DateTime object.
   *
   * TCDate is only concerned with the day and not the time. Converting to a
   * DateTime object looses any time precission that may have been passed into
   * the constructor.
   *
   * @return DateTime Converts to a DateTime object with time set to midnight UTC
   */
  public function toDateTime() {
    return DateTime::createFromFormat('U', $this->toTimestamp());
  }

  /**
   * Converts the date represented by this object to a Julian Day.
   *
   * Used primarily by classes implementing the {@link ITCTemporalExpression}
   * interface.
   *
   * @return int The Julian Day represented by this object
   */
  public function toJulianDay() {
    return $this->julianday;
  }

  /**
   * Converts the date represented by this object to a unix epoch timestamp.
   *
   * TCDate is only concerned with the day and not the time. Converting to a
   * timestamp looses any time precission that may have been passed into the
   * constructor
   *
   * @return DateTime Converts to a unix epoch timestamp with time set to
   * midnight UTC
   */
  public function toTimestamp() {
    return jdtounix($this->julianday);
  }

  /**
   * Converts the date represented by this object to an array containg Gregorian
   * calendar information.
   *
   * For information on the format of the array please see the internal PHP 
   * function for {@link cal_from_jd cal_from_jd()}.
   *
   * @see cal_from_jd
   * @return array Gregorian calendar information
   */
  protected function toCalendar() {
    return cal_from_jd($this->julianday, CAL_GREGORIAN);
  }

  /**
   * The day of the week the date of this object falls on.
   *
   * @see DOW_SUN,DOW_MON,DOW_TUE,DOW_WED,DOW_THU,DOW_FRI,DOW_SAT
   * @return int The day of the week starting on Sunday having a 0-index offset
   */
  public function getDayOfWeek() {
    return jddayofweek($this->julianday, CAL_DOW_DAYNO);
  }

  /**
   * The day of the month the date of this object represents.
   *
   * Not to be confused with the {@link getDayOfWeek day of the week}. This is
   * essentially the day part of the date. For example, 23rd May will return 23.
   *
   * @return int The day in the month (day date part)
   */
  public function getDayInMonth() {
    $calendar = $this->toCalendar();
    return $calendar['day'];
  }

  /**
   * The month the date of this object represents.
   *
   * @return int The month part of the date
   */
  public function getMonthInYear() {
    $calendar = $this->toCalendar();
    return $calendar['month'];
  }


  /**
   * The week in the month the date of this object falls on.
   *
   * The week in month index can be used to find things such as the 2nd Monday
   * in the month.
   *
   * @return int The week in the month
   */
  public function getWeekInMonth() {
    $calendar = cal_from_jd($this->julianday, CAL_GREGORIAN);
    $day = $calendar['day'];
    return (int)((($day-1)/7)+1);
  }

  /**
   * Calculates how many days are left in the month that the date of this object
   * represents.
   *
   * @return int The number of days left in the month
   */
  public function getDaysLeftInMonth() {
    $calendar = cal_from_jd($this->julianday, CAL_GREGORIAN);
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $calendar['month'], $calendar['year']);
    return $daysInMonth - $calendar['day'];
  }

  /**
   * Returns the date in {@link http://www.faqs.org/rfcs/rfc2822 RFC 2822}
   * format.
   *
   * @return string A human readable date
   */
  public function __toString() {
    return $this->toDateTime()->format('r');
  }

  /**
   * Check if two dates are the same.
   *
   * If the two dates both occur on the same Julian Day then thay are equal.
   *
   * @param TCDate $aDate A date to compare with
   * @return bool True if the objects represent the same days
   */
  public function equals(TCDate $aDate) {
    return ($aDate->julianday == $this->julianday);
  }

  /**
   * Compares the order of two dates.
   * 
   * If the two dates are equal, the result will be 0.
   * If the date of this object is later than the compared object then the
   * result will be 1.
   * If the date of this object is earlier than the compared object then the
   * result will be -1.
   *
   * @param TCDate $aDate
   * @return int Either -1 (this object is earlier), 0 (both objects are equal)
   * or 1 (this object is later)
   */
  public function compareTo(TCDate $aDate) {
    if (function_exists('gmp_sign')) {
      return (gmp_sign($this->julianday - $aDate->julianday));
    } else {
      $diff = $this->julianday - $aDate->julianday;
      if ($diff < 0) {
	return -1;
      } else if($diff > 0) {
	return 1;
      }
      return 0;
    }
  }

}

?>