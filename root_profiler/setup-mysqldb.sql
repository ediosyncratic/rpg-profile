#
# Table structure for table `character_owners`
#

DROP TABLE IF EXISTS character_owners;
CREATE TABLE character_owners (
  pname varchar(20) binary NOT NULL default '',
  cid int(11) NOT NULL default '0',
  PRIMARY KEY  (pname,cid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `characters`
#

DROP TABLE IF EXISTS characters;
CREATE TABLE characters (
  cname varchar(20) binary NOT NULL default '',
  id int(11) unsigned NOT NULL auto_increment,
  lastedited timestamp(14) NOT NULL,
  public enum('y','n') default 'n',
  data text,
  editedby varchar(20) default NULL,
  template_id int(11) NOT NULL default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `profiles`
#

DROP TABLE IF EXISTS profiles;
CREATE TABLE profiles (
  pname varchar(20) binary NOT NULL default '',
  pwd varchar(40) binary NOT NULL default '',
  email varchar(50) default NULL,
  lastlogin timestamp(14) NOT NULL,
  pwd_key varchar(32) binary default NULL,
  sid varchar(32) binary default NULL,
  slength int(11) NOT NULL default '180',
  iplog text,
  ip varchar(15) default NULL,
  PRIMARY KEY  (pname)
) TYPE=MyISAM;

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
) TYPE=MyISAM;

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
) TYPE=MyISAM;

INSERT INTO sheet_templates VALUES (1, '3EProfiler Standard', 'standard/v3.php');
INSERT INTO sheet_templates VALUES (2, 'd20 3.5 DnD', 'standard/v3.5-DD.php');
INSERT INTO sheet_templates VALUES (3, 'Serenity', 'standard/Serenity.php');
