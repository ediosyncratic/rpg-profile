<?php
  // download.php

  // Generates a file download with serialized character data.

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/character.class.php");
  include_once("$INCLUDE_PATH/engine/sid.php");

  global $rpgDB;

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Validate the data.
  $id = (int) $_POST['id'];
  $format = (int) $_POST['format'];

  // Verify access to the character.
  if (!$sid->HasAccessTo($id))
    __printFatalErr("Access denied.");

  // Get the charcter data.
  $char = new Character($id);
  if (!$char->IsValid())
    __printFatalErr("Invalid character data (?)");

  // Determine which script to include.
  $_r = $rpgDB->query(sprintf("SELECT exp_file FROM %s where exp_file != '' AND id = %d LIMIT 1",
    $TABLE_SERIALIZE,
    (int) $format));
  if (!$_r)
    __printFatalErr("Failed to query database.", __LINE__, __FILE__);
  $row = $rpgDB->fetch_row($_r);

  // Verify we have a path.
  $path = $INCLUDE_PATH . '/serialization/' . $row['exp_file'];
  if (!is_file($path))
    __printFatalErr("Failed to locate export script.", __LINE__, __FILE__);

  // Include the script.
  include_once($path);

  // Attempt the export.
  $data = export_character($char);
  if (strlen($data))
  {
    header("Cache-Control: no-store, no-cache, must-revalidate");
    echo $data;
  }
  else
    __printFatalErr("Export routine failed.");
?>
