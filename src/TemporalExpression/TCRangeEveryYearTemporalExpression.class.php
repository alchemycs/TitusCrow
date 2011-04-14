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
  /*
   * @var int The day (date part) the range starts in the month
   */
  protected $startDay;
  /*
   * @var int The day (date part) the range end in the month
   */
  protected $finishDay;

  /**
   * Creates the range this temporal expression evaluates.
   *
   * Note: there are 3 signatures for this constructor
   *
   * - A single month:
   * new TCRangeEveryYearTempralExpression(12); //Any day in December
   * - A month range:
   * new TCRangeEveryYearTempralExpression(3, 5); //Any day from the start of March to the end of May
   * - A full range:
   * new TCRangeEveryYearTempralExpression(3, 8, 15, 27); //Any day from 15th March to 27th August
   */
  public function __construct() {
    $initializer = null;
    switch (func_num_args()) {
    case 4:
      $initializer = 'initializeFullRange';
      break;
    case 2:
      $initializer = 'initializeMonthRange';
      break;
    case 1:
      $initializer = 'initializeSingleMonth';
      break;
    default:
      throw new InvalidArgumentException('Constructor accepts 1, 2 or 4 arguments');
    }
    call_user_func_array(array($this, $initializer), func_get_args());
  }

  private function initializeFullRange($aStartMonth, $aFinishMonth, $aStartDay, $aFinishDay) {
    $this->startMonth = $aStartMonth;
    $this->finishMonth = $aFinishMonth;
    $this->startDay = $aStartDay;
    $this->finishDay = $aFinishDay;
  }

  private function initializeMonthRange($aStartMonth, $aFinishMonth) {
    $this->startMonth = $aStartMonth;
    $this->finishMonth = $aFinishMonth;
    $this->startDay = 0;
    $this->finishDay = 0;
  }

  private function initializeSingleMonth($aMonth) {
    $this->startMonth = $aMonth;
    $this->finishMonth = $aMonth;
    $this->startDay = 0;
    $this->finishDay = 0;
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