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
 * This file provides a concrete class for determining dates that occur between
 * two dates.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression that determines if a date occurs between (inclusive)
 * two dates.
 *
 * @todo Review the logic in this - perhaps using TWDate primitives instead of TEs
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCDateBetweenTemporalExpression implements ITCTemporalExpression {

  /**
   * Lower bound reference
   *
   * @var TCDateFromTemporalExpression
   */
  protected $startExpression;
  /**
   * Upper bound reference
   *
   * @var TCDateUntilTemporalExpression
   */
  protected $finishExpression;

  /**
   *
   * @param TCDate $aStartDate The lower bounding reference date for queries
   * @param TCDate $aFinishDate The upper bounding reference date for queries
   */
  public function __construct(TCDate $aStartDate, TCDate $aFinishDate) {

    if ($aFinishDate->compareTo($aStartDate) !== 1) {
      throw new RangeException('The start date must be earlier than the end date.');
    }

    $this->startExpression = new TCDateFromTemporalExpression($aStartDate);
    $this->finishExpression = new TCDateUntilTemporalExpression($aFinishDate);

  }

  /**
   * Retrieve the lower bound reference date this expression uses during
   * evaluation.
   *
   * @return TCDate The reference date
   */
  public function getStartDate() {
    return $this->startExpression->getDate();
  }

  /**
   * Retrieve the upper bound reference date this expression uses during
   * evaluation.
   *
   * @return TCDate The reference date
   */
  public function getFinishDate() {
    return $this->finishExpression->getDate();
  }

  /**
   * Evaluates if a date occurs on or between the reference dates.
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs between (inclusive) the dates, FALSE
   * otherwise
   */
  public function includes(TCDate $aDate) {
    return ($this->startExpression->includes($aDate) && $this->finishExpression->includes($aDate));
  }


}

?>