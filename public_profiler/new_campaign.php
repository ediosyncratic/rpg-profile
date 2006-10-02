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
  $_r = $rpgDB->query(sprintf("INSERT INTO %s SET name = '%s', owner = '%s', website = '%s'",
    $TABLE_CAMPAIGNS,
    addslashes($name),
    addslashes($sid->GetUserName()),
    addslashes($website)));
  if (!$_r)
    __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  if ($rpgDB->num_rows() != 1)
    __printFatalErr("Failed to update campaign list.", __LINE__, __FILE__);
  
  // Get the character's id (the character should be the most recent character
  // edited by this profile, and just to be sure, we restrict the select by
  // cname as well).
  $_r = $rpgDB->query(sprintf("select last_insert_id() as id from %s where owner='%s'",
    $TABLE_CAMPAIGNS,
    addslashes($sid->GetUserName())));
  if (!$_r)
    __printFatalErr("Failed to query database for new campaign id.", __LINE__, __FILE__);
  $r = $rpgDB->fetch_row($_r);
  $campaignID = $r['id'];

  // Everything should be fine, generate the success message.
  $title = 'New Campaign';
  $id = $campaignID;
  $success = true;
  draw_page('new_campaign.php');
?>
