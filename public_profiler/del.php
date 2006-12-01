<?php
  // del.php

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

  global $rpgDB;

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Validate that the character exists, and the user has permission to
  // acess the character.
  $id = (int) $_POST['id'];
  if (!$sid->HasAccessTo($id))
    // Acess denied, give an error screen (omit line/file info since this is not a debug error).
    __printFatalErr("Access denied for user " . $sid->GetUserName() . ".");
  
  // Get the character name.
  $_r = $rpgDB->query(sprintf("SELECT cname FROM %s WHERE id = %d",
    $TABLE_CHARS,
    (int) $id));
  if (!$_r)
    __printFatalErr("Failed to query database for character name.", __LINE__, __FILE__);
  $r = $rpgDB->fetch_row($_r);
  $character = $r['cname'];
  
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
    $_r = $rpgDB->query(sprintf("DELETE FROM %s WHERE cid = %d AND pname = '%s' LIMIT 1",
      $TABLE_OWNERS,
      (int) $id,
      addslashes($sid->GetUserName())));
    if (!$_r)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
    
    // If the user is the owner of the character remove the character data.
    $removed = false;
    $_r = $rpgDB->query(sprintf("select owner from %s where id = %d",
      $TABLE_CHARS,
      (int) $id));
    if (!$_r)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    $row = $rpgDB->fetch_row($_r);
    if ($row['owner'] == $sid->GetUserName())
    {
      // Remove the character.
      $_r = $rpgDB->query(sprintf("DELETE FROM %s WHERE id = %d LIMIT 1",
        $TABLE_CHARS,
        (int) $id));
      if (!$_r)
        __printFatalErr("Failed to query database.", __LINE__, __FILE__);
     
      // Delete all editors
      $_r = $rpgDB->query(sprintf("DELETE FROM %s WHERE cid = %d",
        $TABLE_OWNERS,
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
