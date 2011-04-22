#TitusCrow - A Recurring Event Library

##Introduction
A common problem in both business and personal lives is recurring events. Things
like birthdays, bills due, compliance tasks, homework, meetings and a whole
swag of things have recurring patterns.

This library has been stewing in my brain for quite some time and I
decided it was time to bring this from abstract thought to concrete code.

Date calculations are painful at the best of times, and the language
of recurring events can be quite complicated. There are a range of
special conditions with dates that are not logical but are simply
cultural or political. Things like day light savings, public holidays
(federal, state, occupational, religious), seasons that are different depending
on the hemisphere you live in etc all add to the complexity.

##Requirements
PHP 5.3.0 or greater.

##Background
This library does not attempt to solve every possible combination of recurrence,
however it provides the base tools to build schedules of events that have a
recurrence description. In the context of this library, this description is
referenced as a 'Temporal Expression'. These temporal expressions can be
combined, extended or be created from scratch to resolve the particular
requirement of you recurring events.

##Terminology and Usage
The following is a very quick attempt to describe the terminology used in this
library with some hint at how to use the various classes. I hope to have better
documentation with examples and tutorials at a later date. Also be sure to read
the API documentation.

###What Makes a Schedule
A schedule is simply a collection of _events_ that occur at various _points in
time_. We represent schedules with the `TCSchedule` class.

###What Makes an Event
An event is something of interest that happens at various _points in time_. We
represent events by implementing the `ITCEvent` interface. A simple concrete
class is provided with the `TCSimpleEvent` class.

###How To Represent Dates
Dates are represented with the `TCDate` class. Time is not stored in these
objects, just the date.

###How To Specify Recurring Dates
We use _Temporal Expressions_ to describe what dates a particular event occurs
on. The language of date recurrence is quite complex, so we use the _Expression_
pattern that is defined by the `ITCTemporalExpression` interface. Temporal
expressions can be easily extended to handle new types of recurrence as the
need arrises.

There are 3 powerful _set temporal expressions_ that allow complex combinations
of other temporal expressions. These set expressions provide:
- Union `TCUnionTemporalExpression`
- Intersection `TCIntersectionTemporalExpression`
- Differences `TCDifferenceTemporalExpression`

##Interface and Classes

###Schedule
This is the main class used to manage a schedule.

Create a schedule for the subject which can manage which days an
event occurs.

###Scheduled Event
A Scheduled Event is a map between an event and a temporal expression. Temporal
expressions have an individual instance method to determine if dates
match.

###Temporal Expressions
Define the mechanics of the recurring event by combining various Temporal Expressions
as needed, or create your own for your unique requirements.

###Set Expressions
Combine Temporal Expressions by using these specialised Temporal Expressions.

Set combinations exist for union, intersection and difference.
