<?php
  // 3epxml_exp.php

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

  // Define an export function of the prototype:
  // & String export_character(& Character)

  if (defined('_3EPXML_EXP_INCLUDED_'))
    return;
  define ('_3EPXML_EXP_INCLUDED_', true, true);

  require_once(dirname(__FILE__) . '/../../system.php');
  require_once(dirname(__FILE__) . '/../../engine/templates.php');
  require_once(dirname(__FILE__) . '/../../engine/character.class.php');

  // Return a string representing the serialized character data, or null
  // on an error.
  function & export_character(&$char)
  {
    global $URI_BASE;

    // Modify the header for the appropriate content type, and to force
    // a download prompt with the appropriate filename (in most browsers).
    header("Content-type: text/xml", true);
    header("Content-Disposition: attachment; filename=" . $char->cname . ".xml", true);

    $out  = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
    $out .= "<!DOCTYPE character PUBLIC \"-//rpgprofiler.net//DTD 3EProfiler 1.0//EN\"\n";
    $out .= "  \"http://www.rpgprofiler.net/2003/3EProfiler.dtd\">\n";
    $out .= "<character xmlns=\"http://www.rpgprofiler.net/2003/3EProfiler\">\n";
    $out .= "  <source>$URI_BASE</source>\n";
    $out .= "  <cname>" . $char->cname . "</cname>\n";
    $out .= "  <template>" . get_sheet_name($char->template_id) . "</template>\n";
    $out .= "  <public>" . $char->public . "</public>\n";
    $out .= "  <data>\n";

    $data = $char->GetData();
    while (list($key, $val) = @each($data))
      $out .= "    <node name=\"$key\">$val</node>\n";

    $out .= "  </data>\n";
    $out .= "</character>\n";

    return $out;
  }
?>
