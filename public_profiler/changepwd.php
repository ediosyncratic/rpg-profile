<?php
  // changepwd.php

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

  // Changes the user's password based off a supplied key that must have
  // been retrieved via email. The mail would have been sent out via resetpwd.php.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/engine/id.class.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/error.php");

  global $rpgDB;

  $sid = new SId();

  // Validate the profile name.
  $pname = $_POST['pname'];
  $err_dummy = array();
  if (!is_valid_pname($pname, $err_dummy))
    __printFatalErr("Invalid profile name.");
  
  // Validate the key.
  $key = $_POST['key'];
  $keygen = new Id();
  if (!$keygen->ValidateId($key))
    __printFatalErr("Invalid key.");
  
  // Validate the passwords.
  $pwd1 = $_POST['pwd1'];
  $pwd2 = $_POST['pwd2'];
  $err = array();
  if ($pwd1 != $pwd2)
    array_push($err, "Your passswords do not match.");
  is_valid_password($pwd1, $err);
  is_valid_password($pwd2, $err);

  // Verify against the db.
  $_r = $rpgDB->query(sprintf("SELECT pname FROM %s WHERE pname = '%s' AND pwd_key = '%s'",
    $TABLE_USERS,
    addslashes($pname),
    addslashes($key)));
  if (!$_r)
    __printFatalErr("Failed to query database.", __LINE__, __FILE__);
  if ($rpgDB->num_rows($_r) != 1)
    array_push($err, "The supplied key for the specified profile is not valid.");

  if (sizeof($err))
  {
    // Something's wrong with the passwords, print an error message.
    $title = 'Error';
    $messages = $err;
    draw_page('changepwd_error.php');
  }
  else
  {
    // Change the passwords.
    $_r = $rpgDB->query(sprintf("UPDATE %s SET pwd = PASSWORD('%s'), pwd_key = NULL WHERE pname = '%s' LIMIT 1",
      $TABLE_USERS,
      addslashes($pwd1),
      addslashes($pname)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows() != 1)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);

    $title = 'New Password';
    draw_page('changepwd.php');
  }
?>
