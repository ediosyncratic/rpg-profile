<?php
  // new.php

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

  // Attempts to create a new character for a logged in user, and displays
  // the result to the user.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/template.class.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // Respawn the session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Verify the new name is valid.
  $name = $_POST['newname'];
  $err = array();
  if (!is_valid_cname($name, $err))
  {
    $T = new Template();
    $T->assign('title', 'Error');
    $T->SetBodyTemplate('new_badname.tpl');
    $T->AssignSession($sid);
    $T->send();
    exit;
  }

  // Verify we got a proper template for the character.
  $template = (int) $_POST['template'];
  if (!is_valid_template_id($template))
    __printFatalErr("Invalid template id.");

  // Add the character to the master list.
  $_r = mysql_query(sprintf("INSERT INTO %s SET cname = '%s', editedby = '%s', template_id = %d",
    $TABLE_CHARS,
    addslashes($name),
    addslashes($sid->GetUserName()),
    (int) $template));
  if (!$_r)
    __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  if (mysql_affected_rows() != 1)
    __printFatalErr("Failed to update character list.", __LINE__, __FILE__);
  
  // Get the character's id (the character should be the most recent character
  // edited by this profile, and just to be sure, we restrict the select by
  // cname as well).
  $_r = mysql_query(sprintf("SELECT id FROM %s WHERE editedby = '%s' AND cname = '%s' ORDER BY lastedited DESC LIMIT 1",
    $TABLE_CHARS,
    addslashes($sid->GetUserName()),
    addslashes($name)));
  if (!$_r)
    __printFatalErr("Failed to query database for new character id.", __LINE__, __FILE__);
  $r = mysql_fetch_row($_r);
  $charID = $r[0];

  // Add the the user as an owner to the character.
  $_r = mysql_query(sprintf("INSERT INTO %s SET cid = %d, pname = '%s'",
    $TABLE_OWNERS,
    (int) $charID,
    addslashes($sid->GetUserName())));
  if (!$_r)
    __printFatalErr("Failed to update database.", __LINE__, __FILE__);
  if (mysql_affected_rows() != 1)
    __printFatalErr("Failed to set profile permissions for new character.", __LINE__, __FILE__);

  // Everything should be fine, generate the success message.
  $T = new Template();
  $T->assign('title', 'New Character');
  $T->SetBodyTemplate('new_success.tpl');
  $T->AssignSession($sid);
  $T->assign('name', $name);
  $T->assign('id', $charID);
  $T->send();
?>
