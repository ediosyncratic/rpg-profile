<?php

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/engine/site.class.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  global $URI_BASE, $URI_HOME, $LOGO;

  $title = 'Stats';

  // Attempt to respawn a session.
  $sid = new SId();

  $site = new Site();

  draw_page('stats.php');

?>
