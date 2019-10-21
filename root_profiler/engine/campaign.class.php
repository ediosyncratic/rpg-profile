<?php
  if (defined('_CAMPAIGN_CLASS_INCLUDED_'))
    return;
  define ('_CAMPAIGN_CLASS_INCLUDED_', true, true);

  require_once('db.php');
  require_once(dirname(__FILE__) . '/../system.php');

  class Campaign
  {
    //////////////////////////////////////////////////////////////////////
    // CTOR
    //////////////////////////////////////////////////////////////////////

    public function __construct($id = 0)
    {
      global $TABLE_CAMPAIGNS, $rpgDB;

      $this->id = (int) $id;
      $this->_valid = false;
 
      // Retrieve the character information if requested.
      if ($this->id)
      {
        $sql = sprintf("SELECT name, owner, active, open, website, ".
                       "pc_level, max_players, pc_alignment, description ".
                       "FROM %s WHERE id = %d", $TABLE_CAMPAIGNS, (int) $this->id);
        $res = $rpgDB->query($sql);

        if (!$res) {
          __printFatalErr('Failed to query database: ' . $rpgDB->error() . '\n' . $sql);
        }
        if ($rpgDB->num_rows($res) != 1)
          return;
        $row = $rpgDB->fetch_row($res);
        
        $this->cname = $row['name'];
        $this->owner = $row['owner'];
        $this->active = $row['active'] == 'Y';
        $this->open = $row['open'] == 'Y';
        $this->website = $row['website'];
        $this->pc_level = $row['pc_level'];
        $this->max_players = $row['max_players'];
        $this->pc_alignment = $row['pc_alignment'];
        $this->desc = $row['description'];

        $this->_valid = true;
      }
    }
    function Campaign($id = 0)
    {
        self::__construct();
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
      global $TABLE_CHARS, $TABLE_TEMPLATES, $rpgDB;

      $characters = array();

      $sql = sprintf("SELECT c.cname, c.owner, c.lastedited, st.name, c.id, c.public ".
                     "FROM %s c, %s st WHERE campaign = %d AND st.id = c.template_id ".
                     "ORDER BY UPPER(c.cname)",
                     $TABLE_CHARS,
                     $TABLE_TEMPLATES,
                     (int) $this->id);

      $res = $rpgDB->query($sql);
      if( !$res ) {
        __printFatalErr("Query Failed: $sql");
      } 
 
      while ($row = $rpgDB->fetch_row($res)) {
        array_push($characters, array('name' => $row['cname'], 'owner' => $row['owner'],
                                      'edited' => $row['lastedited'], 'template' => $row['name'], 'id' => $row['id'], 'public' => $row['public']));
      }

      return $characters;
    }

    function GetJoinRequests() {
    
      global $TABLE_CHARS, $TABLE_TEMPLATES, $TABLE_CAMPAIGN_REQUESTS, $rpgDB;

      $characters = array();

      $sql = sprintf("SELECT c.cname, c.owner, c.lastedited, st.name, c.id, cj.status ".
                     "FROM %s c, %s st, %s cj WHERE cj.campaign_id = %d AND c.id = cj.char_id AND st.id = c.template_id ".
                     "ORDER BY UPPER(c.cname)",
                     $TABLE_CHARS,
                     $TABLE_TEMPLATES,
                     $TABLE_CAMPAIGN_REQUESTS,
                     (int) $this->id);

      $res = $rpgDB->query($sql);
      if( !$res ) {
        __printFatalErr("Query Failed: $sql");
      }

      while ($row = $rpgDB->fetch_row($res)) {
        array_push($characters, array('name' => $row['cname'], 'owner' => $row['owner'],
                                      'edited' => $row['lastedited'], 'template' => $row['name'], 
                                      'id' => $row['id'], 'type' => $row['status']));
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
      global $TABLE_CAMPAIGNS, $rpgDB;

      // Update the db.
      $res = $rpgDB->query(sprintf("UPDATE %s SET name = %s, active = '%s', open = '%s', website = %s, ".
                                 "pc_level = %s, max_players = %d, pc_alignment = %s, description = %s ".
                                 "WHERE id = %d",
        $TABLE_CAMPAIGNS,
        $rpgDB->quote($this->cname),
        $this->active ? 'Y' : 'N',
        $this->open ? 'Y' : 'N',
        $rpgDB->quote($this->website),
        $rpgDB->quote($this->pc_level),
        (int) $this->max_players,
        $rpgDB->quote($this->pc_alignment),
        $rpgDB->quote($this->desc),
        (int) $this->id), $rpgDB);

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
