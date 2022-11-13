<?php
  // 3epxml_exp.php

  // Define an export function of the prototype:
  // & String export_character(& Character)

  if (defined('_3EPXML_EXP_INCLUDED_'))
    return;
  define ('_3EPXML_EXP_INCLUDED_', true);

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
    foreach ($data as $key => $val)
      $out .= "    <node name=\"$key\">$val</node>\n";

    $out .= "  </data>\n";
    $out .= "</character>\n";

    return $out;
  }
?>
