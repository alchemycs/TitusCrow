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
 * Provides a temporal expression that determines if a date falls between a given
 * range in a year.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression that determines if a date falls between a given range
 * in a year.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCRangeEveryYearTemporalExpression implements ITCTemporalExpression {

  /**
   *
   * @var int The month the range starts on
   */
  protected $startMonth;
  /**
   *
   * @var int The month the range finishes on
   */
  protected $finishMonth;

  /**
   * Construct the expression with the start and (optional) finish month of the year.
   *
   * There are 2 signatures for this constructor:
   *
   * The first takes a single parameter that is the month to check if a date
   * occurs in.
   *
   * The second takes two parameters where the first is the start month and the
   * second is the end month. The expression will then check if a date occurs
   * anytime between the two months.
   *
   * The range can be "wrapped" so that of a start month of November is given
   * and an end month of February then any date in November, December, January
   * and February will be valid for the expression.
   *
   * - A single month:
   * new TCRangeEveryYearTempralExpression(12); //Any day in December
   * - A month range:
   * new TCRangeEveryYearTempralExpression(3, 5); //Any day from the start of March to the end of May
   * - A wrapped month range:
   * new TCRangeEveryYearTemporalExpresion(11, 2); //Any day in Nov, Dec, Jan, Feb
   */
  public function __construct() {
    $initializer = null;
    switch (func_num_args()) {
    case 2:
      $initializer = 'initializeMonthRange';
      break;
    case 1:
      $initializer = 'initializeSingleMonth';
      break;
    default:
      throw new InvalidArgumentException('Constructor accepts 1 or 2 arguments');
    }
    call_user_func_array(array($this, $initializer), func_get_args());
  }

  private function initializeMonthRange($aStartMonth, $aFinishMonth) {
    $this->startMonth = $aStartMonth;
    $this->finishMonth = $aFinishMonth;
  }

  private function initializeSingleMonth($aMonth) {
    $this->startMonth = $aMonth;
    $this->finishMonth = $aMonth;
  }


  /**
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date is in between the start and finish months
   */
  private function includesMonth(TCDate $aDate) {
    $month = $aDate->getMonthInYear();
    if ($this->startMonth <= $this->finishMonth) {
        return ($month > $this->startMonth && $month < $this->finishMonth);
    } else {
        return ($month > $this->startMonth || $month < $this->finishMonth);
    }
  }

  /**
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs in the start month, FALSE otherwise
   */
  private function includesStartMonth(TCDate $aDate) {
    return ($aDate->getMonthInYear()==$this->startMonth);

    if ($aDate->getMonthInYear() !== $this->startMonth) {
      return false;
    }
    if ($this->startDay == 0) {
      return true;
    }
    return ($aDate->getDayInMonth() >= $this->startDay);
  }

  /**
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs in the finish month, FALSE otherwise
   */
  private function includesFinishMonth(TCDate $aDate) {
    return ($aDate->getMonthInYear()==$this->finishMonth);

    if ($aDate->getMonthInYear() != $this->finishMonth) {
      return false;
    }
    if ($this->finishDay == 0) {
      return true;
    }
    return ($aDate->getDayInMonth() <= $this->finishDay);
  }

  /**
   * Determine if a date occurs in the given range for a year.
   *
   * @param TCDate $aDate The date to test
   * @return bool TRUE if the temporal expression is not included by the temporal
   * expression in the constructor, FALSE if it is
   */
  public function includes(TCDate $aDate) {
      return $this->includesMonth($aDate) ||
      $this->includesStartMonth($aDate) ||
      $this->includesFinishMonth($aDate);
  }


}

?>