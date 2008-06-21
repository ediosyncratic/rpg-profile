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
  if (!$sid->HasAccessTo($id)) {
      print("Access denied.");
      exit;
  }

  // Package the data.
  $char = new Character($id);
  if (!$char->IsValid()) {
      print("Couldn't find character.");
      exit;
  }
  $char->SetData($_POST);
  if (!$char->Save($sid)) {
      print("Couldn't save character.");
      exit;
  }

  print("SUCCESS");
?>