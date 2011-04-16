#Known Issues

The following are known issues:

- `TCDate` does not work with pre unix epoch dates. Fairly minor since we are
  most probably concerned with being reminded about future dates, but we should
  fix this for completeness. Also `jdtounix()` will return a local timestamp.

  The `jdtounix()` and `unixtojd()` functions expect the dates to be in the unix
  epoch between 1970 and 2037 or 2440588 <= jday <= 2465342.

- If the graph of a temporal expression is cyclic we end up in an endless loop!