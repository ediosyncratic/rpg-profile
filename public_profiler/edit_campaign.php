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

  if( isset($_POST['update'])) {
    $campaign->cname = $_POST['name'];
    $campaign->active = isset($_POST['active']);
    $campaign->website = $_POST['website'];
    $campaign->open = isset($_POST['open']);
    $campaign->pc_level = $_POST['pc_level'];
    $campaign->desc = $_POST['desc'];
    $campaign->pc_alignment = $_POST['pc_alignment'];
    $campaign->max_players = $_POST['max_players'];

    $update_details = $campaign->Save() ? "Updated!" : "Update Failed!";
  }

  if( isset($_POST['remove_character'])) {
    $update_char = process_remove_character((int) $_POST['remove_character']);
  }

  draw_page('edit_campaign.php');

  function process_remove_character($char_id) {
    $character = new Character($char_id);
    if( $character->SetCampaign(null) ) {
      return "Removed character " . $character->cname . ".";
    }
    return "Unable to remove character " . $character->cname . ".";
  }

?>
