
-----------------------------------------------------------------
-- Version 0.3.0
-----------------------------------------------------------------

-- Add DM flag to profile
alter table profiles add ( dm varchar(1) not null default 'N' );

-- Add campaign id to characters
alter table characters add ( campaign integer null );

-- Create campaign table
create table campaign (
    id integer primary key auto_increment,
    name varchar(40) not null,
    owner varchar(20) not null,
    active varchar(1) not null default 'Y');
