<?php
  // pview.php

  // Shows the users profile options.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Draw the profile options.
  $title = 'Profile Options';
  draw_page('pview.php');
?>
