<?php
  // charpermissions.class.php

  if (defined('_CHARPERMISSIONS_CLASS_INCLUDED_'))
    return;
  define ('_CHARPERMISSIONS_CLASS_INCLUDED_', true, true);

  require_once('db.php');
  require_once(dirname(__FILE__) . '/../error.php');

  class CharPermission
  {
    //////////////////////////////////////////////////////////////////////
    // Constructor. Pass a profile name OR a character id to retrieve acess
    // rights. Otherwise, nothing is done at construction.
    public function __construct($pname, $cid)
    {
      $this->_pname = $pname;
      $this->_cid = $cid;

      if ($pname && !$cid) {
        $this->get_characters_by_profile();
        $this->get_campaigns();
      }
      else if ($cid && !$pname)
        $this->get_profiles_by_character();

      // Otherwise, we don't have a specific profile/character,
      // or both. In either case, nothing is done in the ctor.
    }
    function CharPermission($pname, $cid)
    {
        self::__construct($pname, $cid);
    }

    //////////////////////////////////////////////////////////////////////
    // Public members.
    //////////////////////////////////////////////////////////////////////

    // Return an array of profiles that are allowed access to this
    // instance's character. Each element in the array is a string with
    // the profile's name.
    function GetProfiles()
    {
      return $this->_profiles;
    }

    // Return an array of characters that this profile has permission to
    // access. Each element in the array is a hash, with 'id' and 'name'
    // keys describing the a character. Array is ordered by name.
    function GetCharacters()
    {
      return $this->_characters;
    }

    function GetInactiveCharacters()
    {
      return $this->_inactive_characters;
    }

    function GetCampaigns()
    {
      return $this->_campaigns;
    }

    function GetInactiveCampaigns()
    {
      return $this->_inactive_campaigns;
    }

    // Add a new permission entry to the table for the contained pname
    // and cid. Both parameters are checked against their foreign tables
    // to ensure they are valid before adding. Return true if the
    // permission was set. Note a false return value does not imply no
    // permission, since the addition can fail if the permission already
    // exists.
    function GrantPermission()
    {
      global $TABLE_OWNERS, $TABLE_CHARS, $TABLE_USERS, $rpgDB;

      // Verify proper data.
      if (!($this->_pname && $this->_cid))
        return false;

      // Verify the user exists.
      $res = $rpgDB->query(sprintf("SELECT pname FROM %s WHERE pname = %s",
        $TABLE_USERS,
        $rpgDB->quote($this->_pname)));
      if (!$res)
        return false;
      if ($rpgDB->num_rows() != 1)
        return false;

      // Verify the character exists.
      $res = $rpgDB->query(sprintf("SELECT id FROM %s WHERE id = %d",
        $TABLE_CHARS,
        (int) $this->_cid));
      if (!$res)
        return false;
      if ($rpgDB->num_rows() != 1)
        return false;

      // Grant permission.
      $res = $rpgDB->query(sprintf("INSERT INTO %s (pname, cid) VALUES (%s, %d)",
        $TABLE_OWNERS,
        $rpgDB->quote($this->_pname),
        (int) $this->_cid));
      if (!$res)
        return false;
      return $rpgDB->num_rows() == 1;
    }

    function RemovePermission()
    {
      global $TABLE_OWNERS, $rpgDB;

      // Verify proper data.
      if (!($this->_pname && $this->_cid))
        return false;

      $res = $rpgDB->query(sprintf("DELETE FROM %s WHERE pname = %s AND cid = %d",
            $TABLE_OWNERS, $rpgDB->quote($this->_pname),
            (int) $this->_cid));

      if (!$res)
        return false;
      return $rpgDB->num_rows() == 1;
    }

    //////////////////////////////////////////////////////////////////////
    // Internal members. You should not modify, copy, or use any members
    // declared below this block.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Data

    var $_profiles = array();
    var $_characters = array();
    var $_inactive_characters = array();

    var $_campaigns = array();
    var $_inactive_campaigns = array();

    var $_pname = null;
    var $_cid = null;

    //////////////////////////////////////////////////////////////////////

    // Determine which profiles are allowed access to the current character.
    function get_profiles_by_character()
    {
      global $TABLE_OWNERS, $TABLE_CHARS, $rpgDB;

      $this->_profiles = array();
      $res = $rpgDB->query(sprintf("SELECT pname FROM %s WHERE cid = %d",
        $TABLE_OWNERS,
        (int) $this->_cid));
      if (!$res)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      while ($row = $rpgDB->fetch_row($res))
        array_push($this->_profiles, $row['pname']);
    }

    // Determine which characters are allowed for the given profile.
    function get_characters_by_profile()
    {
      global $TABLE_OWNERS, $TABLE_CHARS, $TABLE_TEMPLATES, $TABLE_CAMPAIGNS, $rpgDB;

      $this->_characters = array();
      $this->_inactive_characters = array();

      $sql = sprintf("SELECT c.id, c.cname, c.lastedited, c.editedby, ".
                     "c.public, st.name as tname, ca.name as caname, c.campaign, c.inactive ".
                     "FROM %s st, %s c ".
                     "LEFT JOIN %s ca ON ca.id = c.campaign ".
                     "WHERE c.owner = %s ".
                     "AND c.template_id = st.id ORDER BY c.cname",
        $TABLE_TEMPLATES,
        $TABLE_CHARS,
        $TABLE_CAMPAIGNS,
        $rpgDB->quote($this->_pname));
      $res = $rpgDB->query($sql);
      if (!$res)
        __printFatalErr("Failed to query database: $sql", __LINE__, __FILE__);
      while ($row = $rpgDB->fetch_row($res)) {
        if( $row['inactive'] == 'y' ) {
          array_push($this->_inactive_characters, array('id' => $row['id'], 'name' => $row['cname'],
                  'lastedited' => $row['lastedited'], 'editedby' => $row['editedby'],
                  'public' => $row['public'], 'template' => $row['tname'], 'campaign' => $row['caname'],
                  'campaign_id' => $row['campaign'], 'inactive' => $row['inactive']));
        } else {
          array_push($this->_characters, array('id' => $row['id'], 'name' => $row['cname'],
                  'lastedited' => $row['lastedited'], 'editedby' => $row['editedby'],
                  'public' => $row['public'], 'template' => $row['tname'], 'campaign' => $row['caname'],
                  'campaign_id' => $row['campaign'], 'inactive' => $row['inactive']));
        }
      }

      $sql = sprintf("SELECT c.id, c.cname, c.lastedited, c.editedby, ".
                     "c.public, st.name as tname, ca.name as caname, c.campaign, c.inactive ".
                     "FROM %s st, %s o, %s c ".
                     "LEFT JOIN %s ca ON ca.id = c.campaign ".
                     "WHERE c.id = o.cid AND o.pname = %s ".
                     "AND c.template_id = st.id ORDER BY c.cname",
        $TABLE_TEMPLATES,
        $TABLE_OWNERS,
        $TABLE_CHARS,
        $TABLE_CAMPAIGNS,
        $rpgDB->quote($this->_pname));
      $res = $rpgDB->query($sql);
      if (!$res)
        __printFatalErr("Failed to query database: $sql", __LINE__, __FILE__);
      while ($row = $rpgDB->fetch_row($res)) {
        if( $row['inactive'] == 'y' ) {
          array_push($this->_inactive_characters, array('id' => $row['id'], 'name' => '*' . $row['cname'],
                  'lastedited' => $row['lastedited'], 'editedby' => $row['editedby'],
                  'public' => $row['public'], 'template' => $row['tname'], 'campaign' => $row['caname'],
                  'campaign_id' => $row['campaign'], 'inactive' => $row['inactive']));
        } else {
          array_push($this->_characters, array('id' => $row['id'], 'name' => '*' . $row['cname'],
                  'lastedited' => $row['lastedited'], 'editedby' => $row['editedby'],
                  'public' => $row['public'], 'template' => $row['tname'], 'campaign' => $row['caname'],
                  'campaign_id' => $row['campaign'], 'inactive' => $row['inactive']));
        }
      }

    }

    function get_campaigns()
    {
      global $TABLE_CAMPAIGNS, $TABLE_CHARS, $rpgDB;

      $this->_campaigns = array();
      $sql = sprintf("SELECT ca.id, ca.name, ca.active, ca.open, count(ch.id) as chars ".
                     "FROM %s ca LEFT JOIN %s ch ON ca.id = ch.campaign ".
                     "WHERE ca.owner = %s GROUP BY ca.id ".
                     "ORDER BY UPPER(ca.name)",
                     $TABLE_CAMPAIGNS,
                     $TABLE_CHARS,
                     $rpgDB->quote($this->_pname));
      $res = $rpgDB->query($sql);
      if (!$res)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      while ($row = $rpgDB->fetch_row($res)) {
        if( $row['active'] == 'Y' ) {
          array_push($this->_campaigns, array('id' => $row['id'], 'name' => $row['name'],
                                            'active' => ($row['active'] == 'Y'), 'open' => ($row['open'] == 'Y'),
                                            'pcs' => $row['chars']));
        } else {
          array_push($this->_inactive_campaigns, array('id' => $row['id'], 'name' => $row['name'],
                                            'active' => ($row['active'] == 'Y'), 'open' => ($row['open'] == 'Y'),
                                            'pcs' => $row['chars']));

        }
      }
    }
  }
?>
