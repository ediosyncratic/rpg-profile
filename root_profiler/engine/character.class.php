<?php
  // character.class.php

  // Encompasses access to a character. This class isnt designed to hide
  // access to the character data, but rather to provide succinct and easy
  // access to it. Data that isnt part of the characters table though,
  // should be accessed using the accessor functions.

  if (defined('_CHARACTER_CLASS_INCLUDED_'))
    return;
  define ('_CHARACTER_CLASS_INCLUDED_', true, true);

  require_once('db.php');
  require_once('charpermission.class.php');
  require_once(dirname(__FILE__) . '/../system.php');

  class Character
  {
    //////////////////////////////////////////////////////////////////////
    // CTOR
    //////////////////////////////////////////////////////////////////////

    public function __construct($id = 0)
    {
      global $TABLE_CHARS, $rpgDB;

      $this->id = (int) $id;
      $this->_valid = false;

      // Retrieve the character information if requested.
      if ($this->id)
      {
        $res = $rpgDB->query(sprintf("SELECT cname, lastedited, public, editedby, template_id, data, owner, campaign, inactive ".
                                   "FROM $TABLE_CHARS WHERE id = %d",
          (int) $this->id));
        if (!$res)
          return;
        if ($rpgDB->num_rows($res) != 1)
          return;
        $row = $rpgDB->fetch_row($res);

        $this->cname = $row['cname'];
        $this->lastedited = $row['lastedited'];
        $this->public = $row['public'];
        $this->editedby = $row['editedby'];
        $this->template_id = $row['template_id'];
        $this->_data = unserialize($row['data']);
        $this->owner = $row['owner'];
        $this->campaign_id = $row['campaign'];
        $this->inactive = $row['inactive'];

        while (list($key, $val) = @each($this->_data))
          $this->_data[$key] = stripslashes($val);
        @reset($this->_data);

        $this->_permissions = new CharPermission(null, $this->id);
        $this->_valid = true;
      }
    }
    function Character($id = 0)
    {
        self::__construct($id);
    }

    //////////////////////////////////////////////////////////////////////
    // Public members.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Data.

    var $id;
    var $cname;
    var $lastedited;
    var $public;
    var $inactive;
    var $editedby;
    var $template_id;
    var $owner;
    var $campaign_id;

    //////////////////////////////////////////////////////////////////////
    // Accessors

    // Retrieve the data hash.
    function & GetData()
    {
      return $this->_data;
    }

    // Retrieve a data value from a key.
    function Get($key)
    {
      return $this->_data[$key];
    }

    // Validate and set the data hash (overwrites the existing hash).
    function SetData(&$unvalidated)
    {
      $this->_data = array();
      @reset($unvalidated);
      while (list($key, $val) = @each($unvalidated))
        if (strlen($val))
          $this->_data[$key] = htmlspecialchars($val);
    }

    // Set a data key value.
    function Set($key, $val)
    {
      $this->_data[$key] = htmlspecialchars($val);
    }

    //////////////////////////////////////////////////////////////////////
    // General methods.

    // Returns an array of all profiles that have access to the character.
    function GetProfiles()
    {
      return $this->_permissions->GetProfiles();
    }

    // Get a pending campaign for the user.
    function GetPendingCampaign() {
      global $TABLE_CAMPAIGN_REQUESTS, $rpgDB;

      $res = $rpgDB->query(sprintf("SELECT campaign_id, status ".
                                 "FROM $TABLE_CAMPAIGN_REQUESTS WHERE char_id = %d",
          (int) $this->id));
      if (!$res)
        return;
      if ($rpgDB->num_rows($res) != 1)
        return;
      $row = $rpgDB->fetch_row($res);

      return array('campaign_id' => $row['campaign_id'], 'status' => $row['status'], 'user_id' => (int) $this->id );
    }

    // Set the characters campaign ID.
    function SetCampaign($id)
    {
      global $TABLE_CHARS, $rpgDB;

      if( $id == null ) {
        $id = 'null';
        $this->campaign_id = null;
      } else {
        $this->campaign_id = (int) $id;
      }

      // Update the db.
      // - Note, owner is never updated, and campaign is updated in a separate process.
      $res = $rpgDB->query(sprintf("UPDATE %s SET campaign = %d WHERE id = %d",
        $TABLE_CHARS,
        (int) $id,
        (int) $this->id));
      return $res ? true : false;
    }

    // Create a request/invitation to join a campaign.
    function JoinCampaign($campaign_id, $join_type)
    {
      global $TABLE_CAMPAIGN_REQUESTS, $rpgDB;

      $sql = sprintf("INSERT INTO %s (campaign_id, char_id, status) VALUES (%d, %d, '%s')",
        $TABLE_CAMPAIGN_REQUESTS,
        (int) $campaign_id,
        (int) $this->id,
        $join_type);

      // Update the db.
      $res = $rpgDB->query($sql);

      return $res ? true : false;
    }

    function Transfer($profile)
    {
      global $TABLE_CHARS, $rpgDB;

      $sql = sprintf("UPDATE %s SET owner = '%s' WHERE id = %d",
        $TABLE_CHARS,
        $profile,
        (int) $this->id);

      // Update the db.
      $res = $rpgDB->query($sql);

      return $res ? true : false;
    }

    function RemoveJoinRequest()
    {
      global $TABLE_CAMPAIGN_REQUESTS, $rpgDB;

      $sql = sprintf("DELETE FROM %s WHERE char_id = %d",
        $TABLE_CAMPAIGN_REQUESTS,
        (int) $this->id);

      // Update the db.
      $res = $rpgDB->query($sql);

      return $res ? true : false;
    }

    // Grant permission to specified profile. Return true on success.
    function GrantAccessTo($name)
    {
      // Modify the table.
      $cp = new CharPermission($name, $this->id);
      if ($cp->GrantPermission())
      {
        // Refresh this object's permissions object.
        $this->_permissions = new CharPermission(null, $this->id);
        return true;
      }
      else
        return false;
    }

    function RemoveAccessFrom($name)
    {
      $cp = new CharPermission($name, $this->id);
      if ($cp->RemovePermission())
      {
        // Refresh this object's permissions object.
        $this->_permissions = new CharPermission(null, $this->id);
        return true;
      }
      else
        return false;

    }

    function IsValid()
    {
      return $this->_valid;
    }

    // Save character data to the db. $sid must be a session id for the
    // user who is editing the character. Return true on success.
    function Save(&$sid)
    {
      global $TABLE_CHARS, $rpgDB;

      // Update the db.
      // - Note, owner is never updated, and campaign is updated in a separate process.
      $res = $rpgDB->query(sprintf("UPDATE %s SET editedby = %s, public = '%s', inactive = '%s', template_id = %d, data = %s WHERE id = %d",
        $TABLE_CHARS,
        $rpgDB->quote($sid->GetUserName()),
        $this->public == 'y' ? 'y' : 'n',
        $this->inactive == 'y' ? 'y' : 'n',
        (int) $this->template_id,
        $rpgDB->quote(serialize($this->_data)),
        (int) $this->id));
      return $res ? true : false;
    }

    //////////////////////////////////////////////////////////////////////
    // Internal members. Members defined below this line should not be
    // modified or called through instances of an object.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Data members.

    // Is the character valid? (Has data been retrieved successfully by
    // the ctor?)
    var $_valid;

    // Profiles that have permission to access this character.
    var $_permissions;

    // The main character data hash.
    var $_data = array();
  }
?>
