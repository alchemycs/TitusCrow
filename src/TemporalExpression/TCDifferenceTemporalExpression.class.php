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
 * Temporal expressions can be combined to create more complex behaviour. This
 * file provides a Difference for temporal exressions
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression whose result is the Difference of one or two temporal
 * expressions.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCDifferenceTemporalExpression implements ITCTemporalExpression {

  /**
   *
   * @var ITCTemporalExpression The first operand in the difference (what is included)
   */
  protected $includeExpression;
  /**
   *
   * @var ITCTemporalExpression The second operand in the difference (what is not included)
   */
  protected $excludeExpression;

  /**
   *
   * @param ITCTemporalExpression $anInclude The temporal expression of included dates
   * @param ITCTemporalExpression $anExclude The temporal expression of excluded dates
   */
  public function __construct(ITCTemporalExpression $anInclude, ITCTemporalExpression $anExclude) {
    $this->includeExpression = $anInclude;
    $this->excludeExpression = $anExclude;
  }

  /**
   * Evaluates if a date occurs as part of the difference of the two reference
   * temporal expressions.
   *
   * That is, if the queried date satisfies any in the included temporal
   * expression and does not satisfy any dates in the excluded temporal
   * expression
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs as part of the difference, FALSE
   * otherwise
   */
  public function includes(TCDate $aDate) {
    return ($this->includeExpression->includes($aDate) && !($this->excludeExpression->includes($aDate)));
  }

}

?>