<?php
  // upload.php

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

  // Restores a character sheet's data from an uploaded file.
  
  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/character.class.php");
  include_once("$INCLUDE_PATH/engine/serialization.php");

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  $title = '';
  $formats = null;
  $formatname = '';

  // Get the character id and ensure permission.
  $id = (int) $_POST['id'];
  if (!$sid->HasAccessTo($id))
    __printFatalErr("Access denied.");

  // The format of the uplaoded file.
  $format = (int) $_POST['format'];

  // Get the file contents.
  $newname = $INCLUDE_PATH . '/uploads/' . basename($_FILES['userfile']['tmp_name']);
  if (!$_FILES['userfile']['size'])
    __printFatalErr("Uploaded file contains no data.");
  if (!is_uploaded_file($_FILES['userfile']['tmp_name']))
    __printFatalErr("Nice try...");
  if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $newname))
    __printFatalErr("Failed to move uploaded file.", __LINE__, __FILE__);
  // The file has been moved, to a local directory that is accessible in
  // safe mode. Read the contents and delete the file.
  $contents = file_get_contents($newname);
  // Since the user can't do anything if unlinking fails, we ignore any
  // error.
  unlink($newname);
  // Verify the file_get_contents call succeeded now that we've deleted the
  // file.
  if (!$contents)
    __printFatalErr("Failed to read file contents.", __LINE__, __FILE__);

  // Now, check the contents.
  if (!$format) // 0 == autodetect.
  {
    // All autodetect compatible files should have a doctype declaration
    // in them. The declaration should be similar to an xml doctype, but
    // rather than force xml formats, all that need be present is a string
    // conforming to the following regular expression.
    $matches = array();
    if (!preg_match('/!DOCTYPE[^"]+"([^"]*)"/', $contents, $matches))
      print_autodetect_failed($sid, $id);
    
    if (!strlen($matches[1]))
      print_autodetect_failed($sid, $id);

    if (strlen($matches[1]) > 255)
      print_autodetect_failed($sid, $id);

    // Try to obtain the import script to use based on the identifier.
    $res = mysql_query(sprintf("SELECT imp_file, title FROM %s WHERE imp_file != '' AND identifier = '%s' LIMIT 1",
      $TABLE_SERIALIZE,
      addslashes($matches[1])));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if (!mysql_num_rows($res))
      print_autodetect_failed($sid, $id);
    $row = mysql_fetch_row($res);
  }
  else
  {
    // Attempt to apply a specific format.
    // Obtain the import script for the format.
    $res = mysql_query(sprintf("SELECT imp_file, title FROM %s WHERE id = %d",
      $TABLE_SERIALIZE,
      (int) $format));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if (mysql_num_rows($res) != 1)
      __printFatalErr("Failed to obtain import script location.", __FILE__, __LINE__);
    $row = mysql_fetch_row($res);
  }

  // Include the proper script.
  include_once("$INCLUDE_PATH/serialization/" . $row[0]);

  // Call the import routine.
  $char = new Character($id);
  if (!$char->IsValid())
    __printFatalErr("Failed to obtain current character data.");
  if (import_character($contents, $char))
    if ($char->Save($sid))
      print_upload_success($sid);

  // By now, we've  failed if we got here.
  print_upload_failed($sid, $row[1]);

  ////////////////////////////////////////////////////////////////////////
  // Helper functions

  // Show that the autodetect has failed.
  function print_autodetect_failed($sid, $id)
  {
    global $title, $formats;

    $title = 'Data Upload';
    $formats = get_import_scripts();
    draw_page('upload_autodetect_failed.php');
    exit;
  }

  // Show that upload has failed.
  function print_upload_failed($sid, $format)
  {
    global $title, $formatname; 

    $title = 'Data Upload';
    $formatname = $format;
    draw_page('upload_failed.php');
    exit;
  }

  // Show that the upload has succeeded.
  function print_upload_success($sid)
  {
    global $title;

    $title = 'Data Upload';
    draw_page('upload_success.php');
    exit;
  }
?>
