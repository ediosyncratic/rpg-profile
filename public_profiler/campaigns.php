<?php
  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // The session object that will be used through the script.
  $sid = null;

  $sid = RespawnSession(__LINE__, __FILE__);

  if( !$sid || !$sid->IsSessionValid() ) {
    draw_page('login_required.php');
    exit;
  }

  $title = 'Campaign Options';
  $campaigns = $sid->GetCampaigns();
  
  draw_page('campaigns.php');
?>
