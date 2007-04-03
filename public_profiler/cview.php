<?php
  // cview.php

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // Check to see if we need to log the user in (check this before the
  // session cookie, because a new login should always override an
  // existing session).

  // The session object that will be used through the script.
  $sid = null;

  if (isset($_POST['user']) || isset($_POST['pwd']))
  {
    // Login info was passed to the script.

    // Attempt to generate a new session.
    $sid = new SId(false);
    if (!$sid->SpawnSession())
    {
      // Login has failed, show an error.
      $title = 'RPG Web Profiler Error';
      draw_page('login_error.php');
      exit;
    }
  }

  // At this point, either the user has successfully logged in, or is
  // returning to the page from another page.

  // Respawn the session if necessary and draw the character options (the
  // session may already exist from checking _POST info).
  if ($sid == null) {
    $sid = RespawnSession(__LINE__, __FILE__);
  }

  if( !$sid || !$sid->IsSessionValid() ) {
    draw_page('login_required.php');
    exit;
  }

  $title = 'Character Options';
  $characters = $sid->GetCharacters();
  $icharacters = $sid->GetInactiveCharacters();
  $templates = generate_template_array();
  draw_page('cview.php');
?>
