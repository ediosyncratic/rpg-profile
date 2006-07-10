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

    $update_details = $campaign->Save() ? "Updated!" : "Update Failed!";
  }
  if( isset($_POST['invite_character'])) {
    $update_invite = process_invite_character($campaign, (int) $_POST['invite_character']);
  }
  if( isset($_POST['remove_character'])) {
    $update_char = process_remove_character((int) $_POST['remove_character']);
  } 
  if( isset($_POST['cancel_join'])) {
    $update_invite = process_cancel_join((int) $_POST['cancel_join']);
  }
  if( isset($_POST['accept_join_request'])) {
    $update_char = process_accept_join($campaign, (int) $_POST['accept_join_request']);
  }

  draw_page('edit_campaign.php');
 
  function process_invite_character(&$campaign, $char_id) {
    $character = new Character($char_id);
    if( $character->campaign_id > 0 || $character->GetPendingCampaign() ) {
      return "Character " . $character->cname . " is already in a campaign!";
    }
    if( $character->JoinCampaign($campaign->id, "IJ") ) {
      return "Character " . $character->cname . " invited to join the campaign.";
    }
    return "Unable to invite character " . $character->cname . ".";
  } 
 
  function process_cancel_join($char_id) {
    $character = new Character($char_id);
    if( $character->RemoveJoinRequest() ) {
      return "Join request for character " . $character->cname . " cancelled";
    }
    return "Unable to cancel request for character " . $character->cname . ".";
  }
 
  function process_remove_character($char_id) {
    $character = new Character($char_id);
    if( $character->SetCampaign(null) ) {
      return "Removed character " . $character->cname . ".";
    }
    return "Unable to remove character " . $character->cname . ".";
  }

  function process_accept_join(&$campaign, $char_id) {
    $character = new Character($char_id);

    $character->RemoveJoinRequest();
    if( $character->SetCampaign($campaign->id) ) {
      return "Character " . $character->cname . " added to campaign.";
    }
    return "Unable to add character " . $character->cname . " to campaign.";

  }
?>
