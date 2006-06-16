<?php
  // sid.class.php

  // 3EProfiler (tm) source file.
  // Copyright (C) 2003 Michael J. Eggertson.

  // This program is free software; you can redistribute it and/or modify
  // it under the terms of the GNU General Public License as published by
  // the Free Software Foundation; either version 2 of the License, or
  // (at your option) any later version.

  // This program is distributed in the hope that it will be useful,
  // but WITHOUT ANY WARRANTY; without even the implied warranty of
  // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  // GNU General Public License for more details.

  // You should have received a copy of the GNU General Public License
  // along with this program; if not, write to the Free Software
  // Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  // **

  // The Sid class is used to generate and retrieve sessions and session ids.

  if (defined('_SID_CLASS_INCLUDED_'))
    return;
  define('_SID_CLASS_INCLUDED_', true, true);

  require('id.class.php');
  require('db.php');
  require('validation.php');
  require('charpermission.class.php');
  require(dirname(__FILE__) . '/../system.php');

  class SId extends Id
  {
    //////////////////////////////////////////////////////////////////////
    // CTOR
    //////////////////////////////////////////////////////////////////////

    // Initialize the object with existing session data if requested, or
    // create a null session.
    function SId($retrieve_existing = true)
    {
      // Instantiate the base class.
      $this->Id();

      // Instantiate the data that is always valid for any SId object
      // (just the ip address for now).
      $this->_ip = $this->determine_ip();

      // Validate an existing session if requested.
      if ($retrieve_existing)
        $this->retrieve_session();
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

    //////////////////////////////////////////////////////////////////////
    // General methods.

    // Clears the session id cookie and database data.
    function ClearSession()
    {
      global $TABLE_USERS;

      // We can only clear a session if it's valid.
      if (!$this->_is_session_valid)
        return;

      // Clear the cookie.
      setcookie('sid', '');

      // Clear the db entry.
      $res = mysql_query(sprintf("UPDATE %s SET sid = NULL WHERE pname = '%s'",
        $TABLE_USERS,
        addslashes($this->_username)));
      if (!$res)
        __printFatalErr("Failed to update database.", __LINE__, __FILE__);
      if (mysql_affected_rows() != 1)
        __printFatalErr("Failed to update user data.", __LINE__, __FILE__);
    }

    // Return an array of characters data.
    function GetCharacters()
    {
      return $this->_permission->GetCharacters();
    }

    // Determine if the user has access to the specified character.
    function HasAccessTo($id)
    {
      $allowed = false;
      $chars = &$this->_permission->GetCharacters();
      for ($i = 0; $i < sizeof($chars); $i++)
        $allowed |= $chars[$i]['id'] == $id;
      return $allowed;
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
      global $TABLE_USERS;

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
      $res = mysql_query(sprintf("SELECT iplog, slength, email FROM %s WHERE pname = '%s' AND pwd = PASSWORD('%s')",
        $TABLE_USERS,
        addslashes($_POST['user']),
        addslashes($_POST['pwd'])));
      if (!$res)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      if (mysql_num_rows($res) != 1)
        return false;
      $row = mysql_fetch_row($res);

      // Record the userdata.
      $this->_username = $_POST['user'];
      $this->_iplog = unserialize(stripslashes($row[0]));
      $this->_slength = $row[1];
      $this->_email = $row[2];

      // Update the iplog.
      $this->update_iplog();

      // Generate the sid.
      $this->_sid = $this->GenerateId();

      // Set the session cookie.
      setcookie('sid', $this->_sid);

      // Determine character access permissions.
      $this->_permission = new CharPermission($this->_username, null);

      // Update the db.
      $res = mysql_query(sprintf("UPDATE %s SET iplog = '%s', ip = '%s', sid = '%s', pwd_key = NULL WHERE pname = '%s'",
        $TABLE_USERS,
        addslashes(serialize($this->_iplog)),
        addslashes($this->_ip),
        addslashes($this->_sid),
        addslashes($this->_username)));
      if (!$res)
        __printFatalErr("Failed to update database.", __LINE__, __FILE__);
      if (mysql_affected_rows() != 1)
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
      global $TABLE_USERS;

      // Ensure the session state is initially correct.
      $this->_is_session_valid = false;

      // Record the session id.
      if (!isset($_COOKIE['sid']))
        return;
      $this->_sid = $_COOKIE['sid'];

      // Ensure a valid sid.
      if (!$this->ValidateId($this->_sid))
        return;

      // Attempt to retrieve the session details from the db.
      $res = mysql_query(sprintf("SELECT pname, iplog, slength, email FROM %s WHERE UNIX_TIMESTAMP(lastlogin) + (slength * 60) > UNIX_TIMESTAMP(NOW()) AND ip = '%s' AND sid = '%s'",
        $TABLE_USERS,
        addslashes($this->_ip),
        addslashes($this->_sid)));
      if (!$res)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      if (mysql_num_rows($res) != 1)
        return;

      // Record the user data.
      $row = mysql_fetch_row($res);
      $this->_username = $row[0];
      $this->_iplog = unserialize(stripslashes($row[1]));
      $this->_slength = $row[2];
      $this->_email = $row[3];

      // Update the iplog.
      $this->update_iplog();

      // Determine character access permissions.
      $this->_permission = new CharPermission($this->_username, null);

      // Update the db.
      $res = mysql_query(sprintf("UPDATE %s SET iplog = '%s', ip = '%s' WHERE pname = '%s'",
        $TABLE_USERS,
        addslashes(serialize($this->_iplog)),
        addslashes($this->_ip),
        addslashes($this->_username)));
      if (!$res)
        __printFatalErr("Failed to update database.", __LINE__, __FILE__);
      if (mysql_affected_rows() != 1)
        __printFatalErr("Failed to update user data.", __LINE__, __FILE__);

      // Flag the session as valid.
      $this->_is_session_valid = true;
    }

    // Increment the iplog for the current user's ip.
    function update_iplog()
    {
      if ($this->_iplog[$this->_ip])
        $this->_iplog[$this->_ip]++;
      else
        $this->_iplog[$this->_ip] = 1;
    }
  }
?>
