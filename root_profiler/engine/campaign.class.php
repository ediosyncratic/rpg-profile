<?php
  if (defined('_CAMPAIGN_CLASS_INCLUDED_'))
    return;
  define ('_CAMPAIGN_CLASS_INCLUDED_', true, true);

  require('db.php');
  require(dirname(__FILE__) . '/../system.php');

  class Campaign
  {
    //////////////////////////////////////////////////////////////////////
    // CTOR
    //////////////////////////////////////////////////////////////////////

    function Campaign($id = 0)
    {
      global $TABLE_CAMPAIGNS;

      $this->id = (int) $id;
      $this->_valid = false;
      
      // Retrieve the character information if requested.
      if ($this->id)
      {
        $sql = sprintf("SELECT name, owner, active, open, website, ".
                       "pc_level, max_players, pc_alignment, description ".
                       "FROM $TABLE_CAMPAIGNS WHERE id = %d", (int) $this->id);
        $res = mysql_query($sql);
        if (!$res)
          return;
        if (mysql_num_rows($res) != 1)
          return;
        $row = mysql_fetch_row($res);

        $this->cname = $row[0];
        $this->owner = $row[1];
        $this->active = $row[2] == 'Y';
        $this->open = $row[3] == 'Y';
        $this->website = $row[4];
        $this->pc_level = $row[5];
        $this->max_players = $row[6];
        $this->pc_alignment = $row[7];
        $this->desc = $row[8];

        $this->_valid = true;
      }
    }

    //////////////////////////////////////////////////////////////////////
    // Public members.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Data.

    var $id;
    var $cname;
    var $owner;
    var $active;
    var $open;
    var $website;
    var $pc_level;
    var $max_players;
    var $pc_alignment;
    var $description;

    //////////////////////////////////////////////////////////////////////
    // General methods.

    // Returns an array of all characters in this campaign
    function GetCharacters()
    {
      global $TABLE_CHARS, $TABLE_TEMPLATES;

      $characters = array();

      $sql = sprintf("SELECT c.cname, c.owner, DATE_FORMAT(c.lastedited, '%%d/%%m/%%Y %%H:%%i'), st.name, c.id ".
                     "FROM %s c, %s st WHERE campaign = %d AND st.id = c.template_id ".
                     "ORDER BY UPPER(c.cname)",
                     $TABLE_CHARS,
                     $TABLE_TEMPLATES,
                     (int) $this->id);

      $res = mysql_query($sql);
      if( !$res ) {
        __printFatalErr("Query Failed: $sql");
      } 
 
      while ($row = mysql_fetch_row($res)) {
        array_push($characters, array('name' => $row[0], 'owner' => $row[1],
                                      'edited' => $row[2], 'template' => $row[3], 'id' => $row[4]));
      }

      return $characters;
    }

    function GetJoinRequests() 
    {
      global $TABLE_CHARS, $TABLE_TEMPLATES, $TABLE_CAMPAIGN_REQUESTS;

      $characters = array();

      $sql = sprintf("SELECT c.cname, c.owner, DATE_FORMAT(c.lastedited, '%%d/%%m/%%Y %%H:%%i'), st.name, c.id, cj.status ".
                     "FROM %s c, %s st, %s cj WHERE cj.campaign_id = %d AND c.id = cj.char_id AND st.id = c.template_id ".
                     "ORDER BY UPPER(c.cname)",
                     $TABLE_CHARS,
                     $TABLE_TEMPLATES,
                     $TABLE_CAMPAIGN_REQUESTS,
                     (int) $this->id);

      $res = mysql_query($sql);
      if( !$res ) {
        __printFatalErr("Query Failed: $sql");
      }

      while ($row = mysql_fetch_row($res)) {
        array_push($characters, array('name' => $row[0], 'owner' => $row[1],
                                      'edited' => $row[2], 'template' => $row[3], 
                                      'id' => $row[4], 'type' => $row[5]));
      }

      return $characters;
    }

    function IsValid()
    {
      return $this->_valid;
    }

    // Save character data to the db. $sid must be a session id for the
    // user who is editing the character. Return true on success.
    function Save()
    {
      global $TABLE_CAMPAIGNS;

      // Update the db.
      $res = mysql_query(sprintf("UPDATE %s SET name = '%s', active = '%s', open = '%s', website = '%s', ".
                                 "pc_level = '%s', max_players = %d, pc_alignment = '%s', description = '%s' ".
                                 "WHERE id = %d LIMIT 1",
        $TABLE_CAMPAIGNS,
        addslashes($this->cname),
        $this->active ? 'Y' : 'N',
        $this->open ? 'Y' : 'N',
        addslashes($this->website),
        addslashes($this->pc_level),
        (int) $this->max_players,
        addslashes($this->pc_alignment),
        addslashes($this->desc),
        (int) $this->id));

      return $res ? true : false;
    }

    //////////////////////////////////////////////////////////////////////
    // Internal members. Members defined below this line should not be
    // modified or called through instances of an object.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Data members.

    var $_valid;

    
  }
?>
