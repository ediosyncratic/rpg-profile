<?php
  // details.php

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

  // Script for changing the profile details of user (password,
  // email and session length).

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/template.class.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/validation.php");

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  $err = array();

  // Validate the passwords (if supplied).
  if ($_POST['pwd1'] || $_POST['pwd2'])
  {
    // Verify passwords.
    if ($_POST['pwd1'] != $_POST['pwd2'])
      array_push($err, "Your passwords to not match.");
    is_valid_password($_POST['pwd1'], $err);
  }

  // Validate the email.
  is_valid_email($_POST['email'], $err);
  
  // Validate the session length.
  is_valid_slength($_POST['slength'], $err);
  
  if (sizeof($err))
  {
    $T = new Template();
    $T->assign('title', 'Camberra :: Error');
    $T->SetBodyTemplate('details_error.tpl');
    $T->AssignSession($sid);
    $T->assign('messages', $err);
    $T->send();
  }
  else
  {
    if ($_POST['pwd1'] && $_POST['pwd2'])
      update_password(addslashes($_POST['pwd1']), $sid);
    update_email(addslashes($_POST['email']), $sid);
    update_slength(addslashes($_POST['slength']), $sid);

    $T = new Template();
    $T->assign('title', 'Camberra :: Profile Updated');
    $T->SetBodyTemplate('details.tpl');
    $T->AssignSession($sid);
    $T->send();
  }

  ////////////////////////////////////////////////////////////////////////
  // Supporting functions.

  // Updates the db with the user's new password.
  function update_password($pwd, &$sid)
  {
    global $TABLE_USERS;

    $_r = mysql_query(sprintf("UPDATE %s SET pwd = PASSWORD('%s') WHERE pname = '%s' LIMIT 1",
      $TABLE_USERS,
      addslashes($pwd),
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  }

  // Updates the db with the user's new email address.
  function update_email($email, &$sid)
  {
    global $TABLE_USERS;

    $_r = mysql_query(sprintf("UPDATE %s SET email = '%s' WHERE pname = '%s' LIMIT 1",
      $TABLE_USERS,
      addslashes($email),
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  }

  // Updates the db with the user's new session length.
  function update_slength($slength, &$sid)
  {
    global $TABLE_USERS;

    $_r = mysql_query(sprintf("UPDATE %s SET slength = %d WHERE pname = '%s' LIMIT 1",
      $TABLE_USERS,
      (int) $slength,
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  }
?>