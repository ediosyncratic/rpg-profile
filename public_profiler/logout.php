<?php
  // logout.php

  // Clears the session cookie and session data in the database.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // Clear the session cookie.
  $sid = new SId();
  $sid->ClearSession();
  $sid = null;

  $title = 'Logged Out';


  // Show the logged out page.
  draw_page('logout.php');
?>
