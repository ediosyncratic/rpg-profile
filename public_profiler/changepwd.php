<?php
  // changepwd.php
  // Changes the users password based off a supplied key that must have
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
    $_r = $rpgDB->query(sprintf("UPDATE %s SET pwd = '%s', pwd_key = NULL WHERE pname = '%s'",
      $TABLE_USERS,
      addslashes(sha1(sha1($pwd1, true))),
      addslashes($pname)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows() != 1)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);

    $title = 'New Password';
    draw_page('changepwd.php');
  }
?>
