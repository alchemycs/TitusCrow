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
 * file provides a Union for temporal exressions
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * A temporal expression whose result is the union of one or more temporal
 * expressions.
 *
 * @package TitusCrow
 * @subpackage TemporalExpression
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCUnionTemporalExpression implements ITCTemporalExpression {

  /**
   *
   * @var array An array of temporal expressions
   */
  protected $expressions;

  public function __construct() {
    $this->expressions = array();
  }

  /**
   * Removes all the temporal expressions from this union.
   *
   * @return TCUnionTemporalExpression A reference to $this to allow method
   * chaining
   */
  public function clear() {
    $this->expressions = array();
    return $this;
  }

  /**
   *
   * @param ITCTemporalExpression $aTemporalExpression A temporal expression to
   * be added to the union operation
   * @return TCUnionTemporalExpression A reference to $this to allow method
   * chaining
   */
  public function add(ITCTemporalExpression $aTemporalExpression) {
    $this->expressions[spl_object_hash($aTemporalExpression)] = $aTemporalExpression;
    return $this;
  }

  /**
   *
   * @param ITCTemporalExpression $aTemporalExpression A temporal expression to
   * be removed from the union
   * @return TCUnionTemporalExpression A reference to $this to allow method
   * chaining
   */
  public function remove(ITCTemporalExpression $aTemporalExpression) {
    if (isset($this->expressions[spl_object_hash($aTemporalExpression)])) {
	unset($this->expressions[spl_object_hash($aTemporalExpression)]);
      }
      return $this;
  }


  /**
   * Evaluates if a date occurs in any of the temporal expressions that are part
   * of this union.
   *
   * That is, if the queried date satisfies any of the temporal expressions that
   * have been added to this union the result will be TRUE.
   *
   * @param TCDate $aDate
   * @return bool TRUE if the date occurs as part of the union, FALSE
   * otherwise
   */
  public function includes(TCDate $aDate) {
    foreach($this->expressions as $expression) {
      if ($expression->includes($aDate)) {
	return true;
      }
    }
    return false;
  }

}

?>