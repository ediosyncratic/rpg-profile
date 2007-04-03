<?php
  // save.php
  // Saves character data after checking if user has permission to.

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/character.class.php");

  // Respawn the session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Validate and clear the id from the data.
  // Don't bother creating a Character object since we don't actually need
  // to obtain any information about the character (saves a db query).
  $id = (int) $_POST['id'];
  unset($_POST['id']);

  // Verify permission.
  if (!$sid->HasAccessTo($id))
    __printFatalErr("Access denied.");

  // Package the data.
  $char = new Character($id);
  if (!$char->IsValid())
    __printFatalErr("Failed to retrieve existing data.");
  $char->SetData($_POST);
  if (!$char->Save($sid))
    __printFatalErr("Failed to update database.", __LINE__, __FILE__);

  $title = 'Character Updated';
  draw_page('save.php');
?>
