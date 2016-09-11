<?php
  // resetpwd.php

  // Handles resetting a users password in case they forget/misplace it.
  // Three cases are handled:
  //  1: No _GET info is passed -> A general form is shown.
  //  2: Content is passed to _GET['p'] -> An email is sent to the user specified
  //     by the profile in the query string.
  //  3: Content is passed to _GET['p'] and _GET['k'] -> Key is compared to db,
  //     and user is shown a form for changing the password. Actual password change
  //     is done by the changepwd.php script.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/id.class.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/error.php");

  $sid = new SId();

  global $rpgDB;

  ////////////////////////////////////////////////////////////////////////
  if ($_GET['p'] && $_GET['k'])
  {
    // Got a profile name and a key, show the reset password form.

    $pname = $_GET['p'];
    $err_dummy = array();
    if (!is_valid_pname($pname, $err_dummy))
      __printFatalErr("Invalid profile name.");

    $key = $_GET['k'];
    $keygen = new Id();
    if (!$keygen->ValidateId($key))
      __printFatalErr("Invalid key.");

    // Check the key against the db.
    $_r = $rpgDB->query(sprintf("SELECT pname FROM %s WHERE pname = %s AND pwd_key = %s",
      $TABLE_USERS,
      $rpgDB->quote($pname),
      $rpgDB->quote($key)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows($_r) != 1)
    {
      // The key is no longer valid.
      $title = 'Error';
      draw_page('resetpwd_invalidkey.php');
    }
    else
    {
      // The key is still valid, show the change password form.
      $title = 'New Password';
      draw_page('resetpwd_passwordform.php');
    }
  }

  ////////////////////////////////////////////////////////////////////////
  else if ($_GET['p'])
  {
    // Only got a profile name: send off an email message and show the
    // user a message saying to check their mail.

    $pname = $_GET['p'];
    $err_dummy = array();
    if (!is_valid_pname($pname, $err_dummy))
      __printFatalErr("Invalid profile name.");

    // Attempt to retrieve the email for the profile.
    $_r = $rpgDB->query(sprintf("SELECT email FROM %s WHERE pname = %s",
      $TABLE_USERS,
      $rpgDB->quote($pname)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows() != 1)
      __printFatalErr("Profile not found.");

    // Make sure the email address is not null.
    $r = $rpgDB->fetch_row($_r);
    $email = $r['email'];
    if (!is_valid_email($email, $err_dummy))
      __printFatalErr("An invalid or non-existent email address was found in your profile.");

    // Generate a key and put it in the db.
    $keygen = new Id();
    $id = $keygen->GenerateId();
    $_r = $rpgDB->query(sprintf("UPDATE %s SET pwd_key = %s WHERE pname = %s",
      $TABLE_USERS,
      $rpgDB->quote($id),
      $rpgDB->quote($pname)), $rpgDB);
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows() != 1)
      __printFatalErr("Failed to update profile.", __LINE__, __FILE__);

    // Send off the message.
    $to = $email;
    $from = "From: $EMAIL_WEBMASTER";
    $subject = "RPG Web Profiler password reset.";
    $body = "$pname,\n\nYour RPG Web Profiler password at $URI_HOME was recently requested to be reset. To complete the process, visit the link below and follow the directions that 3EProfiler asks.\n\n$URI_BASE/resetpwd.php?p=$pname&k=$id\n\nIf you never requested your password to be reset, please disregard this message. No information was given to the person requesting your password.";
    if (!mail($to, $subject, $body, $from))
      __printFatalErr("Failed to send email to address listed in profile.");

    // Send a success message.
    $title = 'Reset Password';
    draw_page('resetpwd_checkmail.php');
  }

  ////////////////////////////////////////////////////////////////////////
  else
  {
    // No proper query received: show a form allowing the user to give
    // their profile name.
    $title = 'Reset Password';
    draw_page('resetpwd.php');
  }
?>
