<?php
  // serialization.php

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

  // Defines functions useful for dealing with the serialization table.

  if (defined('_SERIALIZATION_INCLUDED_'))
    return;
  define ('_SERIALIZATION_INCLUDED_', true, true);

  require('db.php');

  // Return an array of all available export scripts. Each element will
  // be a hash containing the title and id of each script.
  function & get_export_scripts()
  {
    global $TABLE_SERIALIZE;

    $scripts = array();
    $_r = mysql_query("SELECT id, title FROM $TABLE_SERIALIZE WHERE exp_file != ''");
    if ($_r)
      while($row = mysql_fetch_row($_r))
        array_push($scripts, array('id' => $row[0], 'title' => $row[1]));
    return $scripts;
  }

  // Return an array of all available import scripts. Each element will
  // be a hash containing the title and id of each script.
  function & get_import_scripts()
  {
    global $TABLE_SERIALIZE;

    $scripts = array();
    $_r = mysql_query("SELECT id, title FROM $TABLE_SERIALIZE WHERE imp_file != ''");
    if ($_r)
      while ($row = mysql_fetch_row($_r))
        array_push($scripts, array('id' => $row[0], 'title' => $row[1]));
    return $scripts;
  }
?>
