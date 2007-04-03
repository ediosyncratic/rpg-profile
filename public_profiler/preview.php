<?php
  // preview.php

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
