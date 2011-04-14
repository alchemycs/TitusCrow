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
 * This file provides a concrete class for determining dates that occur on a
 * range of days in a month.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression that determines if a date occurs in a range of days in
 * a month.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCRangeEveryMonthTemporalExpression implements ITCTemporalExpression {

  /**
   *
   * @var int The starting day of the range
   */
  protected $startDayIndex;
  /**
   *
   * @var int The finish day of the range
   */
  protected $finishDayIndex;

  /**
   * Construct the expression with the start and finish day of the month.
   *
   * @param int $aStartDayIndex The day of the week the range starts
   * @param int $aFinishDayIndex The day of the week the range ends
   */
  public function __construct($aStartDayIndex, $aFinishDayIndex = null) {
    if (is_null($aFinishDayIndex)) {
        $aFinishDayIndex = $aStartDayIndex;
    }
    if (!(is_int($aStartDayIndex) && is_int($aFinishDayIndex))) {
      throw new InvalidArgumentException("Integer values expected");
    }
    $this->startDayIndex = $aStartDayIndex;
    $this->finishDayIndex = $aFinishDayIndex;
  }

  /**
   * Evaluates if a date occurs on a day in the reference day range.
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs in the reference day range
   * ordinal position, FALSE otherwise
   */
  public function includes(TCDate $aDate) {
      if ($this->startDayIndex > $this->finishDayIndex) {
        return (($aDate->getDayInMonth() >= $this->startDayIndex)) ||
                (($aDate->getDayInMonth() <= $this->finishDayIndex));
      } else {
        return (($aDate->getDayInMonth() >= $this->startDayIndex) &&
                ($aDate->getDayInMonth() <= $this->finishDayIndex));
      }
  }


}

?>