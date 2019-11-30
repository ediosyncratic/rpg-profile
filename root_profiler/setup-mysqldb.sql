#
# Table structure for table `character_owners`
#

DROP TABLE IF EXISTS character_owners;
CREATE TABLE character_owners (
  pname varchar(20) NOT NULL default '',
  cid int(11) NOT NULL default '0',
  PRIMARY KEY  (pname,cid)
) ENGINE=InnoDB;

# --------------------------------------------------------

#
# Table structure for table `characters`
#

DROP TABLE IF EXISTS characters;
CREATE TABLE characters (
  cname varchar(20) NOT NULL default '',
  id int(11) unsigned NOT NULL auto_increment,
  lastedited timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  public enum('y','n') default 'n',
  data text,
  editedby varchar(20) default NULL,
  template_id int(11) NOT NULL default '1',
  owner varchar(20) NOT NULL,
  campaign integer null,
  inactive enum('y','n') default 'n',
  PRIMARY KEY  (id)
) ENGINE=InnoDB;

# --------------------------------------------------------

#
# Table structure for table `profiles`
#

DROP TABLE IF EXISTS profiles;
CREATE TABLE profiles (
  pname varchar(20) NOT NULL default '',
  pwd varchar(50) NOT NULL default '',
  email varchar(50) default NULL,
  lastlogin timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  pwd_key varchar(32) default NULL,
  sid varchar(32) default NULL,
  slength int(11) NOT NULL default '180',
  iplog text,
  ip varchar(15) default NULL,
  dm varchar(1) not null default 'N',
  PRIMARY KEY  (pname)
) ENGINE=InnoDB;

# --------------------------------------------------------

#
# Table structure for table `campaign`
#

DROP TABLE IF EXISTS campaign;
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

# --------------------------------------------------------

#
# Table structure for table `campaign_join`
#
# RJ : Requested to Join
# IJ : Invited to join
# DI, DJ : unused (presumably, declined invite, declined request)
#

drop table if exists campaign_join;
create table campaign_join(
    campaign_id integer not null,
    char_id integer not null,
    status enum ('RJ','IJ','DI','DJ') not null,
    primary key (campaign_id, char_id));

# --------------------------------------------------------

#
# Table structure for table `serialization_formats`
#

DROP TABLE IF EXISTS serialization_formats;
CREATE TABLE serialization_formats (
  title char(30) NOT NULL default '',
  identifier char(60) default NULL,
  imp_file char(64) default NULL,
  exp_file char(64) default NULL,
  id int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (id),
  UNIQUE KEY identifierindex (identifier)
) ENGINE=InnoDB;

INSERT INTO serialization_formats VALUES ('3EProfiler XML', '-//rpgprofiler.net//DTD 3EProfiler 1.0//EN', '3epxml/3epxml_imp.php', '3epxml/3epxml_exp.php', 1);

# --------------------------------------------------------

#
# Table structure for table `sheet_templates`
#

DROP TABLE IF EXISTS sheet_templates;
CREATE TABLE sheet_templates (
  id int(11) NOT NULL auto_increment,
  name char(32) NOT NULL default '',
  filename char(64) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=InnoDB;

INSERT INTO sheet_templates VALUES (1, '3EProfiler Standard', 'standard/v3.php');
INSERT INTO sheet_templates VALUES (2, 'd20 3.5 DnD', 'standard/v3.5-DD.php');
INSERT INTO sheet_templates VALUES (3, 'Serenity', 'standard/Serenity.php');
