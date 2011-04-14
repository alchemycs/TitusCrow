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
 * describe when they occur. This file provides a concrete class that implements
 * the {@link ITCSchedulElement} interface that simply maps events to temporal
 * expressions.
 *
 * @package TitusCrow
 * @subpackage Schedule
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * This class provides a concrete class that implements the
 * {@link ITCScheduledEvent} interface that simply maps events to temporal
 * expressions.
 *
 * @package TitusCrow
 * @subpackage Schedule
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class TCScheduledEvent implements ITCScheduledEvent {

    /**
     * The event this element maps
     *
     * @var ITCEvent
     */
    protected $event;
    /**
     * The temporal expression this element maps
     *
     * @var ITCTemporalExpression
     */
    protected $temporalExpression;

    /**
     * Instantiates the TCSheduleElement with an {@link ITCEvent event} and
     * a {@link ITCTemporalExpression temporal expression} describing the event's
     * recurrence.
     *
     * @param ITCEvent $anEvent An event
     * @param ITCTemporalExpression $aTemporalExpression An expression defining
     * the recurrence of the event
     */
    public function __construct(ITCEvent $anEvent, ITCTemporalExpression $aTemporalExpression) {
        $this->event = $anEvent;
        $this->temporalExpression = $aTemporalExpression;
    }

    /**
     *
     * @return ITCEvent The event this element maps
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     *
     * @return ITCTemporalExpression The temporal expression describing the
     * recurrence of the mapped event
     */
    public function getTemporalExpression() {
        return $this->temporalExpression;
    }

    /**
     * Given an event and date this method determines if the element representing
     * the given event and if so if the event occurs on the given date.
     *
     * @param ITCEvent $anEvent
     * @param TCDate $aDate
     * @return boolean TRUE if this element represens the event and it occurs on
     * the given date
     */
    public function isOccuring(ITCEvent $anEvent, TCDate $aDate) {
        if ($this->event->equals($anEvent)) {
            return $this->temporalExpression->includes($aDate);
        }
        return false;
    }

    /**
     *
     * @return string The name of the event
     */
    public function __toString() {
        return $this->event->__toString();
    }
}
?>