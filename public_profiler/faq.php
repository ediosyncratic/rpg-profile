<?php
  // faq.php

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // Try to respawn a session, only for the sake of the main nav bar
  // showing the proper buttons.
  $sid = new SId();
  $title = 'Frequently Asked Questions';
  draw_page('faq.php');
?>
