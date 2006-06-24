<?php
  // del.php

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

  // Script that handles deleting a character from a user's profile.
  // Deletion is a two step process, first the user is asked if they are sure
  // they want to remove the character, then if they confirm, their profile
  // is removed from the character's permission list.

  // If there are no remaining profiles that have permission to edit the
  // given character after this profile's permission has been removed, the
  // character's data is permanently removed.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/error.php");

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Validate that the character exists, and the user has permission to
  // acess the character.
  $id = (int) $_POST['id'];
  if (!$sid->HasAccessTo($id))
    // Acess denied, give an error screen (omit line/file info since this is not a debug error).
    __printFatalErr("Access denied for user " . $sid->GetUserName() . ".");
  
  // Get the character name.
  $_r = mysql_query(sprintf("SELECT cname FROM %s WHERE id = %d",
    $TABLE_CHARS,
    (int) $id));
  if (!$_r)
    __printFatalErr("Failed to query database for character name.", __LINE__, __FILE__);
  $r = mysql_fetch_row($_r);
  $character = $r[0];
  
  // Is the user confirming the deletion?
  if ($_POST['confirm'] != "yes")
  {
    // Draw the confirmation screen.
    $title = 'Remove Character';
    draw_page('del_confirm.php');
  }
  else
  {
    // Confirmation received, delete the user's permission for the character.
    $_r = mysql_query(sprintf("DELETE FROM %s WHERE cid = %d AND pname = '%s' LIMIT 1",
      $TABLE_OWNERS,
      (int) $id,
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
    
    // If character no longer appears in the owners table, there are no
    // remaining users that have permission to edit the character, so
    // remove the character data.
    $removed = false;
    $_r = mysql_query(sprintf("SELECT COUNT(pname) FROM %s WHERE cid = %d",
      $TABLE_OWNERS,
      (int) $id));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    $row = mysql_fetch_row($_r);
    if ($row[0] == 0)
    {
      // Remove the character.
      $_r = mysql_query(sprintf("DELETE FROM %s WHERE id = %d LIMIT 1",
        $TABLE_CHARS,
        (int) $id));
      if (!$_r)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
      $removed = true;
    }

    // Draw the result screen.
    $title = 'Remove Character';
    draw_page('del.php');
  }
?>
