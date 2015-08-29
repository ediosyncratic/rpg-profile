<?php
  // sheet_globals.php

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
    global $DATA, $READONLY;

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
