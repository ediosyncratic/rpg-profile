<?php
  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  global $rpgDB;

  // Respawn the session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Verify the new name is valid.
  $name = $_POST['newname'];
  $website = $_POST['website'];
  $err = array();
  if (!is_valid_cname($name, $err))
  {
    $title = 'Error';
    $success = false;
    draw_page('new_campaign.php');
    exit;
  }

  // Add the campaign to the database
  $_r = $rpgDB->query(sprintf("INSERT INTO %s (name, owner, website) VALUES (%s, %s, %s)",
    $TABLE_CAMPAIGNS,
    $rpgDB->quote($name),
    $rpgDB->quote($sid->GetUserName()),
    $rpgDB->quote($website)));
  if (!$_r)
    __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  if ($rpgDB->num_rows() != 1)
    __printFatalErr("Failed to update campaign list.", __LINE__, __FILE__);
  
  // Everything should be fine, generate the success message.
  $title = 'New Campaign';
  $success = true;
  draw_page('new_campaign.php');
?>
