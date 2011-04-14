#TODO

The following items have been identified as "todo" items:

- Create better implementation of `TCDate::unixtojd()`

- Refactor `TCDate` to 'flyweight'

- Create iterator/collection for `ITCEvent`

- Create iterator/collection for `ITCScheduledEvent`

- Refactor internal storage of `ITCScheduledEvent` in `TCSchedule`

- Refactor `TCUnionTemporalExpression` constructor to accept multiple
  `ITCTemporalExpression`s

- Refactor `TCIntersectionTemporalExpression` constructor to accept multiple
  `ITCTemporalExpression`s

- Add `__toString()` to Temporal Expressions

- Create Temporal Expression for "...every nth day..." `TCRepeatingDayTemporalExpression`

- Create Temporal Expression for "...every nth week..." `TCRepeatingWeekTemporalExpression`

- Create Temporal Expression for "...every nth month..." `TCRepeatingMonthTemporalExpression`

- Create Temporal Expression for "...every nth year..." `TCRepeatingYearTemporalExpression`

- Refactor test cases: general assertions should be `assert(expected, actual)`
  but we have mainly used `assert(actual, expected)`

- Consider providing a _context_ for the temporal expressions. This will help
  in the future building a language parser. Also at the moment we get into an
  endless loop if have a temporal expression that is a cyclic graph!

- Consider refactoring classes to be immutable and extending to provide mutable
  counterparts

- Build a sample playground to allow people to try out the usability on the web

- Build examples and tutorials