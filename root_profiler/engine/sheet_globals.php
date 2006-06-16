<?php
  // sheet_globals.php

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

  // Defines globals useful for character sheet templates.

  if (defined('_SHEET_GLOBALS_INCLUDED_'))
    return;
  define ('_SHEET_GLOBALS_INCLUDED_', true, true);

  // Echoes the name/value attributes for a tag, in addition to a readonly
  // atribute if necessary.
  function getnv($name, $setread = true)
  {
    global $DATA, $READONLY;

    echo "name=\"$name\" value=\"" . $DATA[$name] . "\"";
    echo ' title="' . $DATA[$name] . '"';
    if ($setread && $READONLY)
	 {
      echo " readonly=\"readonly\"";
	 }
  }

  // Echoes the name attribute for a tag, in addition to a readonly
  // attribute if necessary.
  function getn($name, $setread = true)
  {
    global $READONLY;

    echo "name=\"$name\"";
    echo ' title="' . $DATA[$name] . '"';
    if ($setread && $READONLY)
      echo " readonly=\"readonly\"";
  }

  // Echoes the value of some data.
  function getv($name)
  {
    global $DATA;

    echo $DATA[$name];
  }

  // Echoes the name attribute for a tag, a checked attribute if data
  // is found, and a readonly attribute if necessary.
  function getnc($name, $setread = true)
  {
    global $DATA, $READONLY;

    echo "name=\"$name\"";
    if (isset($DATA[$name]))
      echo " checked=\"checked\"";
    if ($setread && $READONLY)
      echo " readonly=\"readonly\"";
  }
?>
