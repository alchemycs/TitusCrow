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
 * Provides a temporal expression that inverts the results of another temporal
 * expression.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression that inverts the result of another temporal expression.
 *
 * This temporal expression acts as a logical modifer. It inverts the result of
 * the temporal expression passed in the constructor.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCNotTemporalExpression implements ITCTemporalExpression {

  /**
   * The temporal expression this expression modifies
   *
   * @var ITCTemporalExpression
   */
  protected $temporalExpression;

  /**
   *
   * @param ITCTemporalExpression $aTemporalExpression A temporal expression to modify
   */
  public function __construct(ITCTemporalExpression $aTemporalExpression) {
    $this->temporalExpression = $aTemporalExpression;
  }

  /**
   * Determine if the temporal expression includes a certain date.
   *
   * This implementation is a NOT operator on the temporal expression used in the
   * constructor.
   *
   * @param TCDate $aDate The date to test
   * @return bool TRUE if the temporal expression is not included by the temporal
   * expression in the constructor, FALSE if it is
   */
  public function includes(TCDate $aDate) {
    return !($this->temporalExpression->includes($aDate));
  }


}

?>