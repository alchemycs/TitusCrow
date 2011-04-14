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
 * describe when they occur. This file provides the TCSchedule class to manage
 * events and their temporal expressions.
 *
 * @package TitusCrow
 * @subpackage Schedule
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * Schedules are collections of events. The TCSchedule class manages events and
 * queries their temporal expressions to determine when or if they are occuring.
 *
 * This is the main entrypoint to querying and manipulating schedules. Schedules
 * can be implemented in developer applications by being associated with people,
 * resources or other things as seen fit.
 *
 * @package TitusCrow
 * @subpackage Schedule
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCSchedule implements Countable {

  /**
   *
   * @var array Collection of {@link ITCScheduledEvent} objects
   */
  protected $scheduledEvents;

  /**
   * Instantiate a schedule with an initial set of schedule elements.
   *
   * @param array $scheduledEvents An array of ITCScheduledEvent objects
   */
  public function __construct($scheduledEvents = array()) {
    $this->scheduledEvents = $scheduledEvents;
  }

  /**
   * Add a scheduled event to this schedule.
   *
   * Scheduled events that are already in the schedule will be replaced.
   *
   * @param ITCScheduledEvent $aScheduledEvent
   * @return TCSchedule Returns a reference to the schedule to allow method chaining
   */
  public function add(ITCScheduledEvent $aScheduledEvent) {
      $this->scheduledEvents[spl_object_hash($aScheduledEvent)] = $aScheduledEvent;
      return $this;
  }
  
  /**
   * Removes a scheduled event from this schedule.
   * 
   * @param ITCScheduledEvent $aScheduledEvent 
   * @return TCSchedule Returns a reference to the schedule to allow method chaining
   */
  public function remove(ITCScheduledEvent $aScheduledEvent) {
      if (isset($this->scheduledEvents[spl_object_hash($aScheduledEvent)])) {
          unset($this->scheduledEvents[spl_object_hash($aScheduledEvent)]);
      }
      return $this;
  }
  
  /**
   * Removes all the scheduled events from this schedule.
   * 
   * @return TCSchedule Returns a reference to the schedule to allow method chaining
   */
  public function clear() {
      $this->scheduledEvents = array();
      return $this;
  }

  /**
   *
   * @return int The number of scheduled events
   */
    public function count() {
        return count($this->scheduledEvents);
    }

  /**
   * Determines if an event occurs on a date.
   *
   * @param ITCEvent $anEvent An event to query
   * @param TCDate $aDate A date to query
   * @return bool Returns TRUE if the event occurs on the date, FALSE otherwise
   */
  public function isOccuring(ITCEvent $anEvent, TCDate $aDate) {
    foreach ($this->scheduledEvents as $index=>$scheduledEvent) {
      if ($scheduledEvent->isOccuring($anEvent, $aDate)) {
	  return true;
      }
    }
    return false;
  }

  /**
   * Find the scheduled events that occur on a given date.
   *
   * @param TCDate $aDate
   * @return ITCScheduledEvent[] An array of scheduled events
   */
  public function eventsForDate(TCDate $aDate) {
      $events = array();
      foreach($this->scheduledEvents as  $scheduledEvent) {
        /* @var $scheduledEvent ITCScheduledEvent */
          if ($scheduledEvent->getTemporalExpression()->includes($aDate)) {
              $events[] = $scheduledEvent;
          }
      }
      return $events;
  }

  /**
   * Determines the dates an event occurs given a range.
   *
   * @todo This method is not yet implemented
   * @param ITCEvent $anEvent An event to query
   * @param TCDateRange $aDate A date to query
   * @return TCDate[] Returns an array of TWDate objects
   */
  public function dates(ITCEvent $anEvent, TCDateRange $during) {
    throw new Exception('Method not yet implemented');
  }

  /**
   * Determines the date an event next occurs.
   *
   * @todo This method is not yet implemented
   * @param ITCEvent $anEvent An event to query
   * @return TCDate|NULL Returns the date the event next occurs, or NULL if it
   * never occurs again
   */
  public function nextOccurence(ITCEvent $anEvent) {
    throw new Exception('Method not yet implemented');
  }
}

?>