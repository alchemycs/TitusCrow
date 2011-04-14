<?
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
 * There are many things that can be events. This file defines an interface for
 * events that can then be assigned to a schedule and established with complex
 * recurrent temporal expressions.
 *
 * @package TitusCrow
 * @subpackage Event
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * There are many things that can be events. This file defines an interface for
 * events that can then be assigned to a {@link TCSchedule schedule} and
 * with complex periodicity describe by {@link ITCTemporalExpression} temporal
 * expressions.
 *
 * A basic concrete expression is provided as {@link TCSimpleEvent}. In 
 * most cases you will extends {@link TCSimpleEvent} in your own classes as it
 * already provides concrete methods for this interface.
 *
 * @package TitusCrow
 * @subpackage Event
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
interface ITCEvent {

  /**
   * Sets the name associated with an event
   *
   * @param string $aName Name used to represent an event
   */
  public function setName($aName);
  /**
   * Gets the name associated with an event
   *
   * @return string The name used to represent this event
   */
  public function getName();
  /**
   * Convenience magic method easily display the event
   *
   * @return string Displayable description of the event
   */
  public function __toString();

  /**
   * @param ITCEvent $anEvent TRUE if the events are the same, FALSE otherwise
   */
  public function equals(ITCEvent $anEvent);

}

?>