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
 * This file provides a concrete class for determining dates that occur as a
 * given ordinal day in the month eg, 1st Monday, 2nd last Tuesday
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression that determines if a date occurs on a given ordinal
 * day of the month.
 *
 * Example for using this expression include:
 * - 1st Tuesday
 * - 2nd last Monday
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCDayInMonthTemporalExpression implements ITCTemporalExpression {

  /**
   *
   * @var int The day of the week
   */
  protected $dayIndex;
  /**
   *
   * @var int The ordinal occurence in the month
   */
  protected $count;

  /**
   * Construct the expression with the day and ordinal.
   *
   * The day of the week is a zero indexed integer starting from Sunday. The
   * ordinal occurence can be a positive integer to test from the start or a
   * negative integer to test from the end of the month.
   *
   * Examples:
   * - 1st Tueday: $aDayIndex=2, $aCount=1
   * - 2nd last Monday: $aDayIndex=1, $aCount=-2
   *
   * @see TCDate
   * @param int $aDayIndex The day of the week
   * @param int $aCount Ordinal occurence in the month
   */
  public function __construct($aDayIndex, $aCount) {
    if (!(is_int($aDayIndex) && is_int($aCount))) {
      throw new InvalidArgumentException("Integer values expected");
    }
    $this->dayIndex = $aDayIndex;
    $this->count = $aCount;
  }

  /**
   * Evaluates if a date occurs on the reference day and is the referenced
   * ordinal.
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs on the reference day in the referenced
   * ordinal position, FALSE otherwise
   */
  public function includes(TCDate $aDate) {
    return ($this->getDayMatches($aDate) && $this->getWeekMatches($aDate));
  }

  /**
   *
   * @param TCDate $aDate
   * @return bool TRUE if the day of week matches, FALSE otherwise
   */
  private function getDayMatches(TCDate $aDate) {
    return ($aDate->getDayOfWeek() == $this->dayIndex);
  }

  /**
   *
   * @param TCDate $aDate
   * @return bool TRUE if the ordinal matches
   */
  private function getWeekMatches(TCDate $aDate) {
    if ($this->count > 0) {
      return $this->getWeekFromStartMatches($aDate);
    } else {
      return $this->getWeekFromEndMatches($aDate);
    }
  }

  /**
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs in the ordinal week from the start of
   * the month
   */
  private function getWeekFromStartMatches(TCDate $aDate) {
    return ($aDate->getWeekInMonth() == $this->count);
  }


   /**
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs in the ordinal week from the end of
   * the month
   */
  private function getWeekFromEndMatches(TCDate $aDate) {
    $daysFromMonthEnd = $aDate->getDaysLeftInMonth()+1;
    return ($this->getWeekInMonth($daysFromMonthEnd) == abs($this->count));
  }

  /**
   *
   * @param int $dayNumber The day part of the date in the month
   * @return int The week of the month (ordinal) the day occurs on
   */
  private function getWeekInMonth($dayNumber) {
    return (int)((($dayNumber-1)/7)+1);
  }

}

?>