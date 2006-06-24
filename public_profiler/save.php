<?php
  // save.php

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
