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
 * Schedules are collections of events and events have temporal expressions to
 * describe when they occur. This file provides the interface for the schedule
 * elements which are simply mappings of events to temporal expressions.
 *
 * @package TitusCrow
 * @subpackage Schedule
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * Describes the interface used by {@link TCSchedule} to manage collections of
 * {@link ITCEvent}s and their associated {@link ITCTemporalExpression}s.
 *
 * @package TitusCrow
 * @subpackage Schedule
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
interface ITCScheduledEvent {

  /**
   *
   * @return ITCEvent The event mapped by this element
   */
  public function getEvent();
  /**
   *
   * @return ITCTemporalExpression The temporal expression mapped by the element
   */
  public function getTemporalExpression();
  /**
   * Given an event and date the concrete class determines if this element
   * represents the given event and if so if the event occurs on the given date.
   *
   * @param ITCEvent $anEvent An event to check
   * @param TCDate $aDate A date to check
   * @return bool TRUE if the event occurs on the date, otherwise FALSE
   */
  public function isOccuring(ITCEvent $anEvent, TCDate $aDate);

}

?>