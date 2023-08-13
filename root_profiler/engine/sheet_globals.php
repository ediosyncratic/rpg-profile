<?php
  // sheet_globals.php

  // Defines globals useful for character sheet templates.

  if (defined('_SHEET_GLOBALS_INCLUDED_'))
    return;
  define ('_SHEET_GLOBALS_INCLUDED_', true);

  function backwardsCompatLookup($name)
  {
      global $DATA;
      // Kludge-around: 'Weapon' + i + 'Crit' used to have a stray 1 between i and Crit.
      if (!isset($DATA[$name]) && substr($name, 0, 6) == 'Weapon' && substr($name, 7) == 'Crit')
          return $DATA[$name.substr(0, 7) . '1Crit'];
      return $DATA[$name];
  }
  function backwardsCompatIsSet($name)
  {
      global $DATA;

      if (isset($DATA[$name]))
          return true;
      if (substr($name, 0, 6) == 'Weapon' && substr($name, 7) == 'Crit')
          return isset($DATA[$name.substr(0, 7) . '1Crit']);
      return false;
  }


  // Echoes the name/value attributes for a tag, in addition to a readonly
  // atribute if necessary.
  function getnv($name, $setread = true)
  {
    global $READONLY;

    $value = backwardsCompatLookup($name);
    echo "name=\"$name\" value=\"$value\" title=\"$value\"";
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

    echo "name=\"$name\" title=\"" . backwardsCompatLookup($name) . '"';
    if ($setread && $READONLY)
      echo " readonly=\"readonly\"";
  }

  // Echoes the value of some data.
  function getv($name)
  {
    echo backwardsCompatLookup($name);
  }

  // Echoes the name attribute for a tag, a checked attribute if data
  // is found, and a readonly attribute if necessary.
  function getnc($name, $setread = true)
  {
    global $READONLY;

    echo "name=\"$name\"";
    if (backwardsCompatIsSet($name))
      echo ' checked="checked"';
    if ($setread && $READONLY)
      echo " readonly=\"readonly\"";
  }
?>
