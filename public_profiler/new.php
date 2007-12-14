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
  $err = array();
  if (!is_valid_cname($name, $err))
  {
    $title = 'Error';
    draw_page('new_badname.php');
    exit;
  }

  // Verify we got a proper template for the character.
  $template = (int) $_POST['chartemplate'];
  if (!is_valid_template_id($template))
    __printFatalErr("Invalid template id.");

  // Add the character to the master list.
  $sql = sprintf("INSERT INTO %s SET cname = '%s', editedby = '%s', template_id = %d, owner = '%s'",
    $TABLE_CHARS,
    addslashes($name),
    addslashes($sid->GetUserName()),
    (int) $template,
    addslashes($sid->GetUserName()));
  $_r = $rpgDB->query($sql);
  if (!$_r)
    __printFatalErr("Failed to update database: $sql", __LINE__, __FILE__);
  if ($rpgDB->num_rows() != 1)
    __printFatalErr("Failed to update character list.", __LINE__, __FILE__);

  // Get the character's id (the character should be the most recent character
  // edited by this profile, and just to be sure, we restrict the select by
  // cname as well).
  $_r = $rpgDB->query(sprintf("SELECT id FROM %s WHERE editedby = '%s' AND cname = '%s' ORDER BY lastedited DESC LIMIT 1",
    $TABLE_CHARS,
    addslashes($sid->GetUserName()),
    addslashes($name)));
  if (!$_r)
    __printFatalErr("Failed to query database for new character id.", __LINE__, __FILE__);
  $r = $rpgDB->fetch_row($_r);
  $charID = $r['id'];

  // Everything should be fine, generate the success message.
  $title = 'New Character';
  $id = $charID;
  draw_page('new_success.php');
?>
