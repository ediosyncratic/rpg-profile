
-----------------------------------------------------------------
-- Version 0.6.0
-----------------------------------------------------------------

-- Add an index to the character table to improve SQL performance.
alter table characters add index (owner);
