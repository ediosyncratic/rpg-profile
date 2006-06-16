<?php
  // preview.php

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

  // Shows a preview of an empty character sheet.
  // Accepts two GET arguments:
  //   tpl: numeric id of a sheet template.
  //   readonly: if specified (does not need to be set) the sheet is set to
  //             readonly mode.

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/engine/templates.php");

  // Validate inputs and instantiate the global data.
  $READONLY = isset($_GET['readonly']);
  $tpl = (int) $_GET['tpl'];
  $DATA = array();
  $SHOWSAVE = false;
  $TITLE = get_sheet_name($tpl);

  // Include the sheet globals.
  include_once("$INCLUDE_PATH/engine/sheet_globals.php");

  // Include the template.
  include_once("$INCLUDE_PATH/sheets/" . get_sheet_path($tpl));
?>
