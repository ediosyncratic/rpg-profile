<?php
  // details.php

  // Script for changing the profile details of user (password,
  // email and session length).

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/validation.php");

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  $err = array();

  global $FORUM;

  if( !$FORUM ) {
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
  }

  if (sizeof($err))
  {
    $title = 'Error';
    $messages = $err;
    draw_page('details_error.php');
  }
  else
  {
    if( !$FORUM ) {
      if ($_POST['pwd1'] && $_POST['pwd2'])
        update_password(addslashes($_POST['pwd1']), $sid);
      update_email(addslashes($_POST['email']), $sid);
      update_slength(addslashes($_POST['slength']), $sid);
    }
    update_dm($_POST['dm'], $sid);

    $title = 'Profile Updated';
    draw_page('details.php');
  }

  ////////////////////////////////////////////////////////////////////////
  // Supporting functions.

  // Updates the db with the user's new password.
  function update_password($pwd, &$sid)
  {
    global $TABLE_USERS, $rpgDB;

    $_r = $rpgDB->query(sprintf("UPDATE %s SET pwd = '%s' WHERE pname = '%s'",
      $TABLE_USERS,
      addslashes(sha1(sha1($pwd, true))),
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  }

  // Updates the db with the user's new email address.
  function update_email($email, &$sid)
  {
    global $TABLE_USERS, $rpgDB;

    $_r = $rpgDB->query(sprintf("UPDATE %s SET email = '%s' WHERE pname = '%s'",
      $TABLE_USERS,
      addslashes($email),
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  }

  // Updates the db with the user's new session length.
  function update_slength($slength, &$sid)
  {
    global $TABLE_USERS, $rpgDB;

    $_r = $rpgDB->query(sprintf("UPDATE %s SET slength = %d WHERE pname = '%s'",
      $TABLE_USERS,
      (int) $slength,
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  }

  // Updates the db with the user's dm setting
  function update_dm($dm, &$sid)
  {
    global $TABLE_USERS, $rpgDB;

    $dm = $dm == 'on' ? 'Y' : 'N';

    $_r = $rpgDB->query(sprintf("UPDATE %s SET dm = '%s' WHERE pname = '%s'",
      $TABLE_USERS,
      $dm,
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  }

?>
