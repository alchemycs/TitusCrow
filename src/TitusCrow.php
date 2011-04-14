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
 * Pre-initialization script.
 *
 * This file simply provides a convenient way to include all of the classes
 * presented by the TitusCrow library.
 *
 * @package TitusCrow
 * @author  Michael McHugh <alchemist@alchemycs.net.au>
 * @copyright Michael McHugh, 2011
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

require_once(dirname(__FILE__).'/Date/TCDate.class.php');
require_once(dirname(__FILE__).'/Event/ITCEvent.class.php');
require_once(dirname(__FILE__).'/Event/TCSimpleEvent.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/ITCTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCAlwaysTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCNeverTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCNotTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDateEqualsTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDateFromTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDateAfterTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDateBeforeTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDateUntilTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDateBetweenTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDateInbetweenTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDayInMonthTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCRangeEveryWeekTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCRangeEveryMonthTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCRangeEveryYearTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCUnionTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCIntersectionTemporalExpression.class.php');
require_once(dirname(__FILE__).'/TemporalExpression/TCDifferenceTemporalExpression.class.php');
require_once(dirname(__FILE__).'/Schedule/ITCScheduledEvent.class.php');
require_once(dirname(__FILE__).'/Schedule/TCSchedule.class.php');
require_once(dirname(__FILE__).'/Schedule/TCScheduledEvent.class.php');


?>