#Known Issues

The following are known issues:

- `TCDate` does not work with pre unix epoch dates. Fairly minor since we are
  most probably concerned with being reminded about future dates, but we should
  fix this for completeness.

- `TCRangeEveryYearTemporalExpression` when constructed using a full range where
  the start and finish months are the same will incorrectly return TRUE when 
  calling `ITCTemporalExpression::includes()` on any date in that month.

  Thinking of changing this to only handle month ranges: if you need specific
  parts of the month then use a union with an appropriate temporal expression.

- If the graph of a temporal expression is cyclic we end up in an endless loop!