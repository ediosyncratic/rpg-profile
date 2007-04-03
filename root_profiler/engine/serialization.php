<?php
  // serialization.php

  // Defines functions useful for dealing with the serialization table.

  if (defined('_SERIALIZATION_INCLUDED_'))
    return;
  define ('_SERIALIZATION_INCLUDED_', true, true);

  require_once('db.php');

  // Return an array of all available export scripts. Each element will
  // be a hash containing the title and id of each script.
  function & get_export_scripts()
  {
    global $TABLE_SERIALIZE, $rpgDB;

    $scripts = array();
    $_r = $rpgDB->query("SELECT id, title FROM $TABLE_SERIALIZE WHERE exp_file != ''");
    if ($_r)
      while($row = $rpgDB->fetch_row($_r))
        array_push($scripts, array('id' => $row['id'], 'title' => $row['title']));
    return $scripts;
  }

  // Return an array of all available import scripts. Each element will
  // be a hash containing the title and id of each script.
  function & get_import_scripts()
  {
    global $TABLE_SERIALIZE, $rpgDB;

    $scripts = array();
    $_r = $rpgDB->query("SELECT id, title FROM $TABLE_SERIALIZE WHERE imp_file != ''");
    if ($_r)
      while ($row = $rpgDB->fetch_row($_r))
        array_push($scripts, array('id' => $row['id'], 'title' => $row['title']));
    return $scripts;
  }
?>
