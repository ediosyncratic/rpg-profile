<?php
  // view.php

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

  // Handles all viewing of character sheets (both public and logged in
  // access). General strategy:
  //    - Check if user is logged in and has permission to access the sheet,
  //      if so, then show the sheet in edit mode.
  //    - If no, check to see if the character is public.
  //    - if so, show the public version, otherwise show an error.

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/character.class.php");

  $title = 'RPG Web Profiler Error';
  $error_page = 'view_error.php';

  // Attempt to respawn a session.
  $sid = new SId();

  // Validate input.
  $char = new Character((int) $_GET['id']);
  if (!$char->IsValid()) {
    draw_page($error_page);
    exit;
  }

  if ($sid->IsSessionValid())
  {
    // User is logged in, check to see if they have permission to access
    // character.
    if ($sid->HasAccessTo($char->id))
      draw_sheet_editable($char);
  }

  // We aren't in editable mode, check for public access.
  if ($char->public == 'y')
    draw_sheet_public($char);
  else {
    draw_page($error_page);
    exit;
  }

  ////////////////////////////////////////////////////////////////////////
  // Helper functions.

  // Note the drawing functions work by extracting a reference to the
  // data hash for the character. I'm unsure, but suspect that this will
  // save some time since we'll be working directly with the data hash,
  // and can avoid several hundred function calls which would be needed
  // if using the object (serval calls to Character::Get). Also note that
  // further performance may be gained by bypassing the functions defined
  // in the sheet_globals.php file, and manually extracting data from the
  // $DATA array. This can lead to rather messy templates though, so it
  // wasn't done for the official 3EProfiler release.

  function draw_sheet_editable(&$char)
  {
    global $INCLUDE_PATH, $READONLY, $SHOWSAVE, $DATA, $TITLE, $CHARID;

    $READONLY = $_GET['preview'] == 'true';
    $SHOWSAVE = $_GET['preview'] != 'true';
    $DATA = $char->GetData();
    $TITLE = "" . htmlspecialchars($char->cname);
    $CHARID = (int) $char->id;

    header("Cache-Control: no-store, no-cache, must-revalidate");

    // Include the sheet globals.
    include_once("$INCLUDE_PATH/engine/sheet_globals.php");

    // Include the template.
    include_once("$INCLUDE_PATH/sheets/" . get_sheet_path((int) $char->template_id));

    exit;
  }

  function draw_sheet_public(&$char)
  {
    global $INCLUDE_PATH, $READONLY, $SHOWSAVE, $DATA, $TITLE, $CHARID;

    $READONLY = true;
    $SHOWSAVE = false;
    $DATA = $char->GetData();
    $TITLE = "" . htmlspecialchars($char->cname) . " (Readonly)";
    $CHARID = (int) $char->id;

    header("Cache-Control: no-store, no-cache, must-revalidate");

    // Include the sheet globals.
    include_once("$INCLUDE_PATH/engine/sheet_globals.php");

    // Include the template.
    include_once("$INCLUDE_PATH/sheets/" . get_sheet_path((int) $char->template_id));

    exit;
  }
?>
