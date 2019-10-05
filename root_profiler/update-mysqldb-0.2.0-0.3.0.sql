
-----------------------------------------------------------------
-- Version 0.3.0
-----------------------------------------------------------------

-- Fix to some column character sets
alter table characters modify column cname varchar(20) character set latin1;
alter table character_owners modify column pname varchar(20) character set latin1;
alter table profiles modify column pname varchar(20) character set latin1;
alter table profiles modify column pwd varchar(40) character set latin1;
alter table profiles modify column email varchar(50) character set latin1;
alter table profiles modify column sid varchar(32) character set latin1;

-- Add DM flag to profile
alter table profiles add ( dm varchar(1) not null default 'N' );

-- Add campaign id and owner to characters
alter table characters add ( campaign integer null,
                             owner varchar(20));

update characters set owner = editedby, lastedited = lastedited;

-- Alter character_owners to remove owners.
alter table character_owners add ( coid int(11) );
set @rownum = 1;
update character_owners set coid = @rownum:=@rownum+1;
update characters, character_owners set coid = 0 where id = cid and owner = pname;
delete from character_owners where coid = 0;
alter table character_owners drop column coid;

-- Create campaign table
create table campaign (
    id integer primary key auto_increment,
    name varchar(40) not null,
    owner varchar(20) not null,
    active varchar(1) not null default 'Y',
    open varchar(1) not null default 'N',
    website varchar(250),
    pc_level varchar(250),
    description text,
    pc_alignment varchar(250),
    max_players integer);

-- Create campaign join status table
create table campaign_join(
    campaign_id integer not null,
    char_id integer not null,
    status enum ('RJ','IJ','DI','DJ') not null);
