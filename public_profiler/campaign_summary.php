<?php

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/campaign.class.php");
  include_once("$INCLUDE_PATH/engine/character.class.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/serialization.php");

  // Try to respawn a session to keep the menu nav in context.
  $sid = new SId();

  if( $REQUIRE_LOGIN && !$sid->IsSessionValid() ) {
    draw_page('login_required.php');
    exit;
  }

  // Validate permission for the requested character.
  $id = (int) $_POST['id'];

  if (!$id) {
    $id = (int) $_GET['id'];
  }

  $campaign = new Campaign($id);

  if( $sid->GetUserName() != $campaign->owner ) {
    draw_page('view_campaign_error.php');
    exit;
  }

  $title = $campaign->cname;
  draw_page('campaign_summary.php');
?>
