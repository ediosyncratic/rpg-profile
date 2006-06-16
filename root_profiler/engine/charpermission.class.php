<?php
  // charpermissions.class.php

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

  if (defined('_CHARPERMISSIONS_CLASS_INCLUDED_'))
    return;
  define ('_CHARPERMISSIONS_CLASS_INCLUDED_', true, true);

  require('db.php');
  require(dirname(__FILE__) . '/../error.php');

  class CharPermission
  {
    //////////////////////////////////////////////////////////////////////
    // Constructor. Pass a profile name OR a character id to retrieve acess
    // rights. Otherwise, nothing is done at construction.
    function CharPermission($pname, $cid)
    {
      $this->_pname = $pname;
      $this->_cid = $cid;

      if ($pname && !$cid)
        $this->get_characters_by_profile();
      else if ($cid && !$pname)
        $this->get_profiles_by_character();

      // Otherwise, we don't have a specific profile/character,
      // or both. In either case, nothing is done in the ctor.
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

    // Add a new permission entry to the table for the contained pname
    // and cid. Both parameters are checked against their foreign tables
    // to ensure they are valid before adding. Return true if the
    // permission was set. Note a false return value does not imply no
    // permission, since the addition can fail if the permission already
    // exists.
    function GrantPermission()
    {
      global $TABLE_OWNERS, $TABLE_CHARS, $TABLE_USERS;

      // Verify proper data.
      if (!($this->_pname && $this->_cid))
        return false;

      // Verify the user exists.
      $res = mysql_query(sprintf("SELECT pname FROM %s WHERE pname = '%s'",
        $TABLE_USERS,
        addslashes($this->_pname)));
      if (!$res)
        return false;
      if (mysql_num_rows($res) != 1)
        return false;

      // Verify the character exists.
      $res = mysql_query(sprintf("SELECT id FROM %s WHERE id = %d",
        $TABLE_CHARS,
        (int) $this->_cid));
      if (!$res)
        return false;
      if (mysql_num_rows($res) != 1)
        return false;

      // Grant permission.
      $res = mysql_query(sprintf("INSERT INTO %s SET pname = '%s', cid = %d",
        $TABLE_OWNERS,
        addslashes($this->_pname),
        (int) $this->_cid));
      if (!$res)
        return false;
      return mysql_affected_rows() == 1;
    }

    //////////////////////////////////////////////////////////////////////
    // Internal members. You should not modify, copy, or use any members
    // declared below this block.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Data

    var $_profiles = array();
    var $_characters = array();

    var $_pname = null;
    var $_cid = null;

    //////////////////////////////////////////////////////////////////////

    // Determine which profiles are allowed access to the current character.
    function get_profiles_by_character()
    {
      global $TABLE_OWNERS, $TABLE_CHARS;

      $this->_profiles = array();
      $res = mysql_query(sprintf("SELECT pname FROM %s WHERE cid = %d",
        $TABLE_OWNERS,
        (int) $this->_cid));
      if (!$res)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      while ($row = mysql_fetch_row($res))
        array_push($this->_profiles, $row[0]);
    }

    // Determine which characters are allowed for the given profile.
    function get_characters_by_profile()
    {
      global $TABLE_OWNERS, $TABLE_CHARS;

      $this->_characters = array();
      $res = mysql_query(sprintf("SELECT cid, cname, DATE_FORMAT(lastedited, '%%d/%%m/%%Y @ %%H:%%i'), editedby, public FROM %s, %s WHERE pname = '%s' AND cid = id ORDER BY cname",
        $TABLE_OWNERS,
        $TABLE_CHARS,
        addslashes($this->_pname)));
      if (!$res)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      while ($row = mysql_fetch_row($res))
        array_push($this->_characters, array('id' => $row[0], 'name' => $row[1], 'lastedited' => $row[2], 'editedby' => $row[3], 'public' => $row[4]));
    }
  }
?>
