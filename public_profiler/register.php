<?php
  // register.php

  // Handles new user registration.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");

  $sid = new SId();

  global $rpgDB;

  if( ! $OPEN_REGISTRATION ) {
    draw_page('register_closed.php');
    exit;
  }


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

    $title = 'Error';
    $error_page = 'register_error.php';

    // Check for errors.
    if (sizeof($err) > 0) {
      $messages = $err;
      draw_page($error_page);
      exit;
    }

    // Check to see if the profile name already exists.
    $_r = $rpgDB->query(sprintf("SELECT COUNT(pname) as cnt FROM %s WHERE pname = '%s'",
      $TABLE_USERS,
      addslashes($user)));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    $r = $rpgDB->fetch_row($_r);
    if ($r['cnt'] != 0)
    {
      array_push($err, "The selected username ($user) has already been registered by another user.");
      $messages = $err;
      draw_page($error_page);
    }

    // Attempt to add the new user.
    $_r = $rpgDB->query(sprintf("INSERT INTO %s SET pname = '%s', pwd = PASSWORD('%s'), email = '%s'",
      $TABLE_USERS,
      addslashes($user),
      addslashes($pwd1),
      addslashes($email)));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);

    // Show the user a success message.
    $title = 'Registration Complete';
    $pname = $user;
    draw_page('register_success.php');
  }
  else
  {
    // No data was sent:
    // Display the registration page.
    $title = 'Registration';
    $pname = $user;
    draw_page('register.php');
  }

?>
