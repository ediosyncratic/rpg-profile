<?php
  // templates.php

  // Global handling functions for retrieving information relating to
  // character sheet templates (NOT Smarty templates!).

  if (defined('_TEMPLATES_INCLUDED_'))
    return;
  define ('_TEMPLATES_INCLUDED_', true, true);

  require_once('db.php');
  require_once(dirname(__FILE__) . '/../error.php');
  include_once("$INCLUDE_PATH/engine/campaign.class.php");

  // Return an array of hashes of available templates. Each hash has the keys
  // 'id', 'name', and 'filename'. May produce a terminal error if db query
  // fails.
  function generate_template_array() {
    global $TABLE_TEMPLATES, $rpgDB;

    $res = $rpgDB->query("SELECT id, name, filename FROM $TABLE_TEMPLATES order by upper(name)");
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    $templates = array();
    while ($row = $rpgDB->fetch_row($res))
      array_push($templates, array('id' => $row['id'], 'name' => $row['name'], 'filename' => $row['filename']));
    return $templates;
  }

  // Determine if the supplied template index is a valid one. May produce
  // a terminal error if db query fails.
  function is_valid_template_id($id) {
    global $TABLE_TEMPLATES, $rpgDB;

    $res = $rpgDB->query(sprintf("SELECT name FROM %s WHERE id = %d",
      $TABLE_TEMPLATES,
      (int) $id));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);

    return $rpgDB->num_rows($res) == 1;
  }


  // Gets the id of a template based off a name. Terminal if db fails...
  function get_sheet_id($name) {
    global $TABLE_TEMPLATES, $rpgDB;

    $res = $rpgDB->query(sprintf("SELECT id FROM %s WHERE name = %s LIMIT 1",
      $TABLE_TEMPLATES, $rpgDB->quote($name)));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows($res) == 1)
    {
      $row = $rpgDB->fetch_row($res);
      return (int) $row['id'];
    }
    else
      // Return the default (first) template if the name is not found.
      return 1;
  }

  // Gets the name of a template from a given id. Terminal if db fails...
  function get_sheet_name($id) {
    global $TABLE_TEMPLATES, $rpgDB;

    $res = $rpgDB->query(sprintf("SELECT name FROM %s WHERE id = %d",
      $TABLE_TEMPLATES,
      (int) $id));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows())
    {
      $row = $rpgDB->fetch_row($res);
      return $row['name'];
    }
    else
      return "Unknown template";
  }

  // Gets the path of a template from a given id. Terminal if db fails...
  function get_sheet_path($id) {
    global $TABLE_TEMPLATES, $rpgDB;

    $res = $rpgDB->query(sprintf("SELECT filename FROM %s WHERE id = %d",
      $TABLE_TEMPLATES,
      (int) $id));
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows($res))
    {
      $row = $rpgDB->fetch_row($res);
      return $row['filename'];
    }
    else
      return __printFatalErr("Invalid character sheet identifier");
  }

  function draw_page($page) {
    global $INCLUDE_PATH;

    header("Cache-Control: no-store, no-cache, must-revalidate");

      // Include the sheet globals.
  //    include_once("$INCLUDE_PATH/engine/sheet_globals.php");

    // Include the header
    include_once("$INCLUDE_PATH/templates/header.php");

    // Include the template.
    include_once("$INCLUDE_PATH/templates/" . $page);

    // Include the footer
    include_once("$INCLUDE_PATH/templates/footer.php");

    exit;
  }

  // Create methods for variables used on most pages.
  function getUserName() {
    global $sid;
    return $sid->GetUserName();
  }

  function loggedIn() {
    global $sid;
    return $sid && $sid->IsSessionValid();
  }

  function getUriBase() {
    global $URI_BASE;
    return $URI_BASE;
  }

  function getUriHome() {
    global $URI_HOME;
    return $URI_HOME;
  }

  function getUriTos() {
    global $URI_TOS;
    return $URI_TOS;
  }

  function getUriWebmaster() {
    global $URI_WEBMASTER;
    return $URI_WEBMASTER;
  }

  function getLogo() {
    global $LOGO;
    return $LOGO;
  }

  function getTitle() {
    global $title;
    return $title;
  }

  function getHead() {
    global $head;
    return $head;
  }
?>
