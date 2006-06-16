<?php
  // register.php

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

  // Handles new user registration.

  include_once("config.php");
  include_once("$INCLUDE_PATH/template.class.php");

  if (isset($_POST['user']))
  {
    // User data was sent:
    // Attempt to register the new user.

    include_once("$INCLUDE_PATH/engine/validation.php");
    include_once("$INCLUDE_PATH/engine/db.php");
    include_once("$INCLUDE_PATH/error.php");

    // Collect the user data.
    $user = $_POST['user'];
    $pwd1 = $_POST['pwd1'];
    $pwd2 = $_POST['pwd2'];
    $email = $_POST['email'];

    // The error array.
    $err = array();

    // Validate the user data.
    is_valid_pname($user, $err);
    is_valid_password($pwd1, $err);
    is_valid_password($pwd2, $err);
    is_valid_email($email, $err);

    // Check the passwords for consistency.
    if ($pwd1 != $pwd2)
      array_push($err, "Your passwords do not match.");

    // Check for errors.
    if (sizeof($err) > 0)
      __printRegistrationErr($err);

    // Check to see if the profile name already exists.
    $_r = mysql_query(sprintf("SELECT COUNT(pname) FROM %s WHERE pname = '%s'",
      $TABLE_USERS,
      addslashes($user)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    $r = mysql_fetch_row($_r);
    if ($r[0] != 0)
    {
      array_push($err, "The selected username ($user) has already been registered by another user.");
      __printRegistrationErr($err);
    }

    // Attempt to add the new user.
    $_r = mysql_query(sprintf("INSERT INTO %s SET pname = '%s', pwd = PASSWORD('%s'), email = '%s'",
      $TABLE_USERS,
      addslashes($user),
      addslashes($pwd1),
      addslashes($email)));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);

    // Show the user a success message.
    $T = new Template();
    $T->assign('title', 'Camberra :: Registration Complete');
    $T->assign('pname', $user);
    $T->SetBodyTemplate('register_success.tpl');
    $T->send();
  }
  else
  {
    // No data was sent:
    // Display the registration page.
    $T = new Template();
    $T->assign('title', 'Camberra :: Registration');
    $T->assign('pname', $user);
    $T->SetBodyTemplate('register.tpl');
    $T->send();
  }

  ////////////////////////////////////////////////////////////////////////
  // Helper functions.

  // Print an error screen.
  function __printRegistrationErr($errmsgs = null)
  {
    $T = new Template();
    $T->assign('title', 'Camberra :: Error');
    $T->SetBodyTemplate('register_error.tpl');
    if ($errmsgs)
      $T->assign('messages', $errmsgs);
    $T->send();
    exit;
  }
?>