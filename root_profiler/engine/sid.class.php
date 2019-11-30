<?php
  // sid.class.php

  // The Sid class is used to generate and retrieve sessions and session ids.

  if (defined('_SID_CLASS_INCLUDED_'))
    return;
  define('_SID_CLASS_INCLUDED_', true, true);

  require_once('id.class.php');
  require_once('db.php');
  require_once('validation.php');
  require_once('charpermission.class.php');
  require_once(dirname(__FILE__) . '/../system.php');

  class SId extends Id
  {
    //////////////////////////////////////////////////////////////////////
    // CTOR
    //////////////////////////////////////////////////////////////////////

    // Initialize the object with existing session data if requested, or
    // create a null session.
    public function __construct($retrieve_existing = true)
    {
      // Instantiate the base class.
      parent::__construct();

      // Instantiate the data that is always valid for any SId object
      // (just the ip address for now).
      $this->_ip = $this->determine_ip();

      // Validate an existing session if requested.
      if ($retrieve_existing)
        $this->retrieve_session();
    }
    function SId($retrieve_existing = true)
    {
        self::__construct($retrieve_existing);
    }

    //////////////////////////////////////////////////////////////////////
    // Public members.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Accessor methods.

    function GetAddress()
    {
      return $this->_ip;
    }

    function GetEmail()
    {
      return $this->_email;
    }

    function GetSLength()
    {
      return $this->_slength;
    }

    function GetUserName()
    {
      return $this->_username;
    }

    function IsDM()
    {
      return $this->_dm;
    }

    //////////////////////////////////////////////////////////////////////
    // General methods.

    // Clears the session id cookie and database data.
    function ClearSession()
    {
      global $TABLE_USERS, $FORUM, $rpgDB;

      if( $FORUM ) {
        return;
      }

      // We can only clear a session if it's valid.
      if (!$this->_is_session_valid)
        return;

      // Clear the cookie.
      setcookie('sid', '');

      // Clear the db entry.
      $res = $rpgDB->query(sprintf("UPDATE %s SET sid = NULL WHERE pname = %s",
        $TABLE_USERS,
        $rpgDB->quote($this->_username)));
      if (!$res)
        __printFatalErr("Failed to update database.", __LINE__, __FILE__);
      if ($rpgDB->num_rows() != 1)
        __printFatalErr("Failed to update user data.", __LINE__, __FILE__);
    }

    // Return an array of characters data.
    function GetCharacters()
    {
      return $this->_permission->GetCharacters();
    }

    function GetInactiveCharacters()
    {
      return $this->_permission->GetInactiveCharacters();
    }

    function GetCampaigns()
    {
      return $this->_permission->GetCampaigns();
    }

    function GetInactiveCampaigns()
    {
      return $this->_permission->GetInactiveCampaigns();
    }

    // Determine if the user has access to the specified character.
    function HasAccessTo($id)
    {
      global $TABLE_CHARS, $TABLE_CAMPAIGNS, $TABLE_OWNERS, $rpgDB;

      $name = $this->_username;
      $sql = sprintf("select c.id as id from %s c where c.owner = '%s' and c.id = %d ".
		     "union select c.id as id from %s c, %s n where c.campaign = n.id and n.owner = '%s' and c.id = %d ".
		     "union select cid as id from %s where pname = '%s' and cid = %d ",
		     $TABLE_CHARS, $name, $id,
		     $TABLE_CHARS, $TABLE_CAMPAIGNS, $name, $id,
		     $TABLE_OWNERS, $name, $id);

      $res = $rpgDB->query($sql);
      if( !$res ) {
        __printFatalErr("Failed to query database: $sql", __LINE__, __FILE__);
      }

      return $rpgDB->fetch_row($res);
    }

    // Determine if the session is valid or not (this is really just another
    // accessor, but named differently).
    function IsSessionValid()
    {
      return $this->_is_session_valid;
    }

    // Generate a new session, which includes setting the session id cookie.
    // The function examines POST info for login data and compares it against
    // the db. Returns true if a session was spawned, or false if it fails.
    // This function can terminate with an error if db queries fail.
    function SpawnSession()
    {
      global $TABLE_USERS, $FORUM, $rpgDB;

      // If forum software is being used for authentication, don't create sessions.
      if( $FORUM ) {
        return;
      }

      // Ensure the session state is set correctly.
      $this->_is_session_valid = false;

      // Ensure we have both a username and password.
      if (!(isset($_POST['user']) && isset($_POST['pwd'])))
        return false;

      // Validate the data.
      $err = array();
      if (!(is_valid_pname($_POST['user'], $err)
        && is_valid_password($_POST['pwd'], $err)))
        return false;

      // Check the user against the db.
      $res = $rpgDB->query(sprintf("SELECT iplog, slength, email, dm FROM %s WHERE pname = %s ".
                                 "AND pwd = %s",
        $TABLE_USERS,
        $rpgDB->quote($_POST['user']),
        $rpgDB->quote(sha1(sha1($_POST['pwd'], true)))));
      if (!$res)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      if ($rpgDB->num_rows() != 1)
        return false;
      $row = $rpgDB->fetch_row($res);

      // Record the userdata.
      $this->_username = $_POST['user'];
      $this->_iplog = unserialize(stripslashes($row['iplog']));
      $this->_slength = $row['slength'];
      $this->_email = $row['email'];
      $this->_dm = $row['dm'] == 'Y';

      // Update the iplog.
      $this->update_iplog();

      // Generate the sid.
      $this->_sid = $this->GenerateId();

      // Set the session cookie.
      setcookie('sid', $this->_sid);

      // Determine character access permissions.
      $this->_permission = new CharPermission($this->_username, null);

      // Update the db.
      $res = $rpgDB->query(sprintf("UPDATE %s SET iplog = %s, ip = %s, sid = %s, pwd_key = NULL WHERE pname = %s",
        $TABLE_USERS,
        $rpgDB->quote(serialize($this->_iplog)),
        $rpgDB->quote($this->_ip),
        $rpgDB->quote($this->_sid),
        $rpgDB->quote($this->_username)));
      if (!$res)
        __printFatalErr("Failed to update database.", __LINE__, __FILE__);
      if ($rpgDB->num_rows() != 1)
        __printFatalErr("Failed to update user data.", __LINE__, __FILE__);

      // Now record that this session is valid.
      $this->_is_session_valid = true;

      // Return success.
      return true;
    }

    //////////////////////////////////////////////////////////////////////
    // Internal members. Members defined below this line should not be
    // modified or called through instances of an object.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Data members.

    // The session id.
    var $_sid = null;

    // Is the session valid?
    var $_is_session_valid = false;

    // The username for the session.
    var $_username = null;

    // The iplog for the user.
    // A hash containing a key for each ip address, where each key's value
    // is an integer logging how many times the given ip has been used to
    // access the profile.
    var $_iplog = null;

    // The ip the user is logged in from.
    var $_ip = null;

    // The session length (integer);
    var $_slength = null;

    // The user's email address.
    var $_email = null;

    // CharPermission object, reflecting this sessions access rights.
    var $_permission = null;

    // Enable DM functionality.
    var $_dm = false;

    //////////////////////////////////////////////////////////////////////
    // Methods.

    // Determine which characters the profile has access too.
    function get_characters()
    {
      return $this->_permission->GetCharacters();
    }

    // Determine the ip (or at least an ip of some type) for the user.
    function determine_ip()
    {
      if (getenv("HTTP_CLIENT_IP"))
        return getenv("HTTP_CLIENT_IP");
      else if (getenv("HTTP_FORWARDED_FOR"))
        return getenv("HTTP_FORWARDED_FOR");
      else
        return getenv("REMOTE_ADDR");
    }

    // Attempt to retrieve a session that was referenced in the cookie.
    // This function can terminate with an error if db queries fail.
    function retrieve_session()
    {
      global $TABLE_USERS, $FORUM, $rpgDB;

      // Ensure the session state is initially correct.
      $this->_is_session_valid = false;

      if( $FORUM ) {
        require('authentication/' . $FORUM . '.php');
      } else {
	require_once('authentication/cookie.php');
      }

      if( !authenticate($this) ) {
        return;
      }

      // Determine character access permissions.
      $this->_permission = new CharPermission($this->_username, null);

      // Flag the session as valid.
      $this->_is_session_valid = true;
    }

    // Increment the iplog for the current user's ip.
    function update_iplog()
    {
      if ($this->_iplog[$this->_ip]) {
        $this->_iplog[$this->_ip]++;
      } else {
        $this->_iplog[$this->_ip] = 1;
      }
    }
  }
?>
