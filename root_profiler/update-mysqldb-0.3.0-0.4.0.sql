
-----------------------------------------------------------------
-- Version 0.4.0
-----------------------------------------------------------------

-- Fix to some column character sets
alter table characters modify column cname varchar(20) character set latin1;
alter table character_owners modify column pname varchar(20) character set latin1;
alter table profiles modify column pname varchar(20) character set latin1;
alter table profiles modify column pwd varchar(50) character set latin1;
alter table profiles modify column email varchar(50) character set latin1;
alter table profiles modify column sid varchar(32) character set latin1;

