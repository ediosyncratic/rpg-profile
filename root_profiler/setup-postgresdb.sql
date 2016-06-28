--
-- enumerated types
--

CREATE TYPE yesno AS ENUM('y', 'n');
CREATE TYPE campaign_status AS ENUM('RJ','IJ','DI','DJ');

--
-- functions
--

--
-- Function: unix_timestamp(timestamp)
--

CREATE OR REPLACE FUNCTION unix_timestamp(t timestamp)
  RETURNS double precision AS $$
BEGIN
  RETURN EXTRACT(EPOCH FROM t);
END;
$$ LANGUAGE plpgsql;

--
-- Function: update_lastlogin()
--

CREATE OR REPLACE FUNCTION update_lastlogin()
  RETURNS TRIGGER AS $$
BEGIN
	  NEW.lastlogin = NOW();
	  RETURN NEW;
END;
$$ language 'plpgsql';

--
-- Function: update_lastedited()
--

CREATE OR REPLACE FUNCTION update_lastedited()
  RETURNS TRIGGER AS $$
BEGIN
	  NEW.lastedited = NOW();
	  RETURN NEW;
END;
$$ language 'plpgsql';

--
-- Tables
--

--
-- character_owners
--

DROP TABLE IF EXISTS character_owners;
CREATE TABLE character_owners (
  pname varchar(20) NOT NULL DEFAULT '',
  cid integer NOT NULL default '0',
  PRIMARY KEY  (pname,cid)
);

--
-- characters
--

DROP TABLE IF EXISTS characters;
CREATE TABLE characters (
  cname varchar(20) NOT NULL default '',
  id SERIAL,
  lastedited timestamp NOT NULL default now(),
  public yesno default 'n',
  data text,
  editedby varchar(20) default NULL,
  template_id integer NOT NULL default '1',
  owner varchar(20) NOT NULL,
  campaign integer null,
  inactive yesno default 'n',
  PRIMARY KEY  (id)
);

CREATE TRIGGER refresh_lastedited_onupdate
  BEFORE UPDATE
  ON characters
  FOR EACH ROW
  EXECUTE PROCEDURE update_lastedited();

--
-- profiles
--

DROP TABLE IF EXISTS profiles;
CREATE TABLE profiles (
  pname varchar(20) NOT NULL default '',
  pwd varchar(50) NOT NULL default '',
  email varchar(50) default NULL,
  lastlogin timestamp NOT NULL default now(),
  pwd_key varchar(32) default NULL,
  sid varchar(32) default NULL,
  slength integer NOT NULL default '180',
  iplog text,
  ip varchar(15) default NULL,
  dm varchar(1) not null default 'N',
  PRIMARY KEY  (pname)
);

CREATE TRIGGER refresh_lastlogin_onupdate
  BEFORE UPDATE
  ON profiles
  FOR EACH ROW
  EXECUTE PROCEDURE update_lastlogin();

--
-- campaign
--

DROP TABLE IF EXISTS campaign;
CREATE TABLE campaign (
  id SERIAL PRIMARY KEY,
  name varchar(40) not null,
  owner varchar(20) not null,
  active varchar(1) not null default 'Y',
  open varchar(1) not null default 'N',
  website varchar(250),
  pc_level varchar(250),
  description text,
  pc_alignment varchar(250),
  max_players integer
);

--
-- campaign_join
--

DROP TABLE IF EXISTS campaign_join;
CREATE TABLE campaign_join(
  campaign_id integer not null,
  char_id integer not null,
  status campaign_status not null,
  PRIMARY KEY (campaign_id, char_id)
);

--
-- serialization_formats
--

DROP TABLE IF EXISTS serialization_formats;
CREATE TABLE serialization_formats (
  title varchar(30) NOT NULL default '',
  identifier varchar(60) default NULL,
  imp_file varchar(64) default NULL,
  exp_file varchar(64) default NULL,
  id SERIAL,
  PRIMARY KEY  (id),
  CONSTRAINT identifierindex UNIQUE (identifier)
);

INSERT INTO serialization_formats VALUES ('3EProfiler XML', '-//rpgprofiler.net//DTD 3EProfiler 1.0//EN', '3epxml/3epxml_imp.php', '3epxml/3epxml_exp.php', 1);

--
-- sheet_templates
--

DROP TABLE IF EXISTS sheet_templates;
CREATE TABLE sheet_templates (
  id SERIAL,
  name varchar(32) NOT NULL default '',
  filename varchar(64) NOT NULL default '',
  PRIMARY KEY  (id)
);

INSERT INTO sheet_templates VALUES (1, '3EProfiler Standard', 'standard/v3.php');
INSERT INTO sheet_templates VALUES (2, 'd20 3.5 DnD', 'standard/v3.5-DD.php');
INSERT INTO sheet_templates VALUES (3, 'Serenity', 'standard/Serenity.php');
