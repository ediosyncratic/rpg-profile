<?php
  // download.php

  // 3EProfiler (tm) source file.
  // Copyright (C) 2003 Michael J. Eggertson.

  // This program is free software; you can redistribute it and/or modify
  // it under the terms of the GNU General Public License as published by
  // the Free Software Foundation; either version 2 of the License, or
  // (at your option) any later version.

  // This program is distributed in the hope that it will be useful,
  // but WITHOUT ANY WARRANTY; without even the implied warranty of
  // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  // GNU General Public License for more details.

  // You should have received a copy of the GNU General Public License
  // along with this program; if not, write to the Free Software
  // Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  // **

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
