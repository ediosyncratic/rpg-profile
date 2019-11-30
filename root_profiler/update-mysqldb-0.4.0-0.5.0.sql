
-----------------------------------------------------------------
-- Version 0.5.0
-----------------------------------------------------------------

-- Add the inactive flag to characters
alter table characters add ( inactive enum('y','n') default 'n' );

