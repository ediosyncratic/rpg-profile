<?php
// search.php

// Performs a search based on character name.

include_once("config.php");
include_once("$INCLUDE_PATH/engine/db.php");
include_once("$INCLUDE_PATH/engine/sid.class.php");
include_once("$INCLUDE_PATH/engine/templates.php");
include_once("$INCLUDE_PATH/error.php");
include_once("$INCLUDE_PATH/system.php");

// Try to respawn a session to keep the menu nav in context.
$sid = new SId();

if( $REQUIRE_LOGIN && !$sid->IsSessionValid() ) {
  draw_page('login_required.php');
  exit;
}

if( $_GET['cname'] || $_GET['type'] == 'all' ) {
  // Search name entered, do search.
  $recordsPerPage = 15;

  $name = $_GET['cname'];
  $type = $_GET['type'];
  $page = $_GET['page'];

  $sql = sprintf("SELECT c.id, c.name, c.owner, count(ch.id) as cnt ".
                 "FROM %s c LEFT JOIN %s ch on ch.campaign = c.id ".
                 "WHERE c.active = 'Y' AND c.open = 'Y' ",
             $TABLE_CAMPAIGNS,
             $TABLE_CHARS);

  if( $type == 'begins' ) {
    $sql .= "AND UPPER(c.name) LIKE UPPER('" . $name . "%') ";
  } else if( $type == 'contains' ) {
    $sql .= "AND UPPER(c.name) LIKE UPPER('%" . $name . "%') ";
  } else if( $type == 'ends' ) {
    $sql .= "AND UPPER(c.name) LIKE UPPER('%" . $name . "') ";
  }

  $sql .= "GROUP BY c.id ";
  $sql .= "ORDER BY UPPER(c.name) ";

  // Limit
  $sql .= "LIMIT " . $recordsPerPage . " ";

  // Offset
  if( $page ) {
    $start = 1 + ((((int) $page) - 1) * $recordsPerPage);

    $sql .= "OFFSET " . $start . " ";
  } else {
     $page = 1;
  }

  global $rpgDB;
  $res = $rpgDB->query($sql);
  if (!$res) {
     __printFatalErr("Failed to query database: $sql", __LINE__, __FILE__);
  }

  $campaigns = array();

  while ($row = $rpgDB->fetch_row($res)) {
    array_push($campaigns, array( "id" => $row['id'], "name" => $row['name'],
                                  "owner" => $row['owner'], "characters" => $row['cnt'] ));
  }


  if( count($campaigns) == $recordsPerPage ) {
    $nextpage = $page + 1;
  }
  if( $page > 1 ) {
    $prevpage = $page - 1;
  }

  draw_page('campaign_search_results.php');
} else {
  // No query string, show the search page.
  draw_page('search.php');
}
?>
