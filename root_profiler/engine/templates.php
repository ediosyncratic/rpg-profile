<?php
  // templates.php

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

  // Global handling functions for retrieving information relating to
  // character sheet templates (NOT Smarty templates!).

  if (defined('_TEMPLATES_INCLUDED_'))
    return;
  define ('_TEMPLATES_INCLUDED_', true, true);

  require('db.php');
  require(dirname(__FILE__) . '/../error.php');

  // Return an array of hashes of available templates. Each hash has the keys
  // 'id', 'name', and 'filename'. May produce a terminal error if db query
  // fails.
  function generate_template_array()
  {
    global $TABLE_TEMPLATES;

    $res = mysql_query("SELECT id, name, filename FROM $TABLE_TEMPLATES");
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    $templates = array();
    while ($row = mysql_fetch_row($res))
      array_push($templates, array('id' => $row[0], 'name' => $row[1], 'filename' => $row[2]));
    return $templates;
  }

  // Determine if the supplied template index is a valid one. May produce
  // a terminal error if db query fails.
  function is_valid_template_id($id)
  {
    global $TABLE_TEMPLATES;

    $res = mysql_query(sprintf("SELECT name FROM %s WHERE id = %d",
      $TABLE_TEMPLATES,
      (int) $id));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);

    return mysql_num_rows($res) == 1;
  }


  // Gets the id of a template based off a name. Terminal if db fails...
  function get_sheet_id($name)
  {
    global $TABLE_TEMPLATES;

    $res = mysql_query(sprintf("SELECT id FROM %s WHERE name = '%s' LIMIT 1",
      $TABLE_TEMPLATES, addslashes($name)));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if (mysql_num_rows($res) == 1)
    {
      $row = mysql_fetch_row($res);
      return (int) $row[0];
    }
    else
      // Return the default (first) template if the name is not found.
      return 1;
  }

  // Gets the name of a template from a given id. Terminal if db fails...
  function get_sheet_name($id)
  {
    global $TABLE_TEMPLATES;

    $res = mysql_query(sprintf("SELECT name FROM %s WHERE id = %d",
      $TABLE_TEMPLATES,
      (int) $id));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if (mysql_num_rows($res))
    {
      $row = mysql_fetch_row($res);
      return $row[0];
    }
    else
      return "Unknown template";
  }

  // Gets the path of a template from a given id. Terminal if db fails...
  function get_sheet_path($id)
  {
    global $TABLE_TEMPLATES;

    $res = mysql_query(sprintf("SELECT filename FROM %s WHERE id = %d",
      $TABLE_TEMPLATES,
      (int) $id));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if (mysql_num_rows($res))
    {
      $row = mysql_fetch_row($res);
      return $row[0];
    }
    else
      return __printFatalErr("Invalid character sheet identifier");
  }
?>
