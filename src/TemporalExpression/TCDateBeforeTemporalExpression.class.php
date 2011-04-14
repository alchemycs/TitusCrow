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
 * Recurring events can be expressed by combining vaious temporal expressions.
 * This file provides a concrete class for determining dates that occur before
 * a given date.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression that determines if a date occurs before (exclusive) a
 * given date.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCDateBeforeTemporalExpression implements ITCTemporalExpression {

  /**
   *
   * @var TCDate The date to compare with
   */
  protected $date;

  /**
   *
   * @param TCDate $aDate The reference date for queries
   */
  public function __construct(TCDate $aDate) {
    if (is_null($aDate)) {
      throw new InvalidArgumentException('Expected TCDate but received null');
    }
        $this->date = $aDate;
  }

  /**
   * Retrieve the reference date this expression uses during evaluation.
   *
   * @return TCDate The reference date
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Evaluates if a date occurs before the reference date.
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs after the reference date, FALSE
   * otherwise
   */
  public function includes(TCDate $aDate) {
    return ($aDate->compareTo($this->date)<0);
  }

}

?>