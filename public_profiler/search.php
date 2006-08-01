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

  $sort = $_GET['sort'];
  $page = $_GET['page'];

  $sql = sprintf("SELECT c.id, c.cname, DATE_FORMAT(c.lastedited, '%%d %%M %%Y @ %%H:%%i'), c.owner, st.name, ca.name ".
                 "FROM %s st, %s c LEFT JOIN %s ca on ca.id = c.campaign ".
                 "WHERE c.public = 'y' AND c.template_id = st.id ",
             $TABLE_TEMPLATES,
             $TABLE_CHARS,
             $TABLE_CAMPAIGNS);
  
  if( $type == 'begins' ) {
    $sql .= "AND UPPER(c.cname) LIKE UPPER('" . $name . "%') ";
  } else if( $type == 'contains' ) {
    $sql .= "AND UPPER(c.cname) LIKE UPPER('%" . $name . "%') ";
  } else if( $type == 'ends' ) {
    $sql .= "AND UPPER(c.cname) LIKE UPPER('%" . $name . "') ";
  }

  // Order by
  if( $sort == 'date' ) {
    $sql .= "ORDER BY c.lastedited DESC ";
  } else if( $sort == 'template' ) {
    $sql .= "ORDER BY UPPER(st.name), UPPER(c.cname) ";
  } else if( $sort == 'campaign' ) {
    $sql .= "ORDER BY UPPER(ca.name), UPPER(c.cname) ";
  } else if( $sort == 'owner' ) {
    $sql .= "ORDER BY UPPER(c.owner), UPPER(c.cname) ";
  } else {
    $sql .= "ORDER BY UPPER(c.cname), UPPER(c.cname) ";
  }

  // Limit
  $sql .= "LIMIT " . $recordsPerPage . " ";

  // Offset
  if( $page ) {
    $start = 1 + ((((int) $page) - 1) * $recordsPerPage);
    
    $sql .= "OFFSET " . $start . " ";
  } else {
     $page = 1;
  }

  $res = mysql_query($sql);
  if (!$res) {
     __printFatalErr("Failed to query database: $sql", __LINE__, __FILE__);
  }

  $characters = array();

  while ($row = mysql_fetch_row($res)) {
    array_push($characters, array( "id" => $row[0], "name" => $row[1], "lastedited" => $row[2],
                                   "owner" => $row[3], "template" => $row[4], "campaign" => $row[5] ));
  }


  if( count($characters) == $recordsPerPage ) {
    $nextpage = $page + 1;
  }
  if( $page > 1 ) {
    $prevpage = $page - 1;
  }

  draw_page('search_results.php');
} else {
  // No query string, show the search page.
  draw_page('search.php');
}
?>
