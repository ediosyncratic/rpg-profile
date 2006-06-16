<?php
  // search.php

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

  // Performs a search based on character name.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/db.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/template.class.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/system.php");

  // Try to respawn a session to keep the menu nav in context.
  $sid = new SId();


    $resx = mysql_query("SELECT id, name, filename FROM sheet_templates");
    if (!$resx)
      __printFatalErr(mysql_error()."<br>Failed to query database.", __LINE__, __FILE__);
    $resultsx = array();
    while ($rowx = mysql_fetch_row($resx))
      array_push($resultsx, array('id' => $rowx[0], 'name' => $rowx[1], 'filename' => $rowx[2]));

function dotemplatename($passed){
	GLOBAL $resultsx;
	for($l=0; $l<sizeof($resultsx); $l++){
		if ($resultsx[$l]['id']==$passed)
			$out = $resultsx[$l]['name'];
	}
	return $out;
}

  $cname = $_GET['cname'];

  $T = new Template();
  $T->assign('title', 'Character Search');
  if ($sid->IsSessionValid())
    $T->AssignSession($sid);

  if ((($ch)||($type=='all')) || ((strlen($cname) > 0) && (strlen($cname) < 21)))
  {
    // Generate the search string.
    $type = $_GET['type'];
    if ($ch){
      if($orby=="DESC"){
          $neworby = "ASC";
      }else{
          $neworby = "DESC";
      }
      $ch_name = "<a href='$PHP_SELF?ch=1&orby=$neworby&cname=$cname&type=$type'>Character Name</a>";
      $ls_mod = "<a href='$PHP_SELF?ch=2&orby=$neworby&cname=$cname&type=$type'>Last Modified</a>";
    }else{
      $neworby = "ASC";
      $neworby2 = "DESC";
      $ch_name = "<a href='$PHP_SELF?ch=1&orby=$neworby2&cname=$cname&type=$type'>Character Name</a>";
      $ls_mod = "<a href='$PHP_SELF?ch=2&orby=$neworby&cname=$cname&type=$type'>Last Modified</a>";
}
$np = "&ch=$ch&orby=$orby";
    if ($ch=='1'){
       $orderby = "cname";
    }else if ($ch=='2'){
       $orderby = "lastedited";
    }else{
       $orderby = "cname";
    }
    if ($orby){
       $orderby .= " " . $orby;
    }else{
       $orderby .= " ASC";
    }
    if ($type == "begins")
      $qname = "WHERE cname LIKE '" . addslashes($cname) . "%'";
    else if ($type == "ends")
      $qname = "WHERE cname LIKE '%" . addslashes($cname) . "'";
    else if ($type == "contains")
      $qname = "WHERE cname LIKE '%" . addslashes($cname) . "%'";
    else if ($type == "all") {
      $qname = "";
    }else{
      // Invalid search type.
      __printFatalErr("Invalid search type.");
    }


    // Determine which rows to return.
    $rowsperpage = 20;
    $page = (int) $_GET['page'];
    if ($page < 1)
      $page = 1;
    $offset = ($page - 1) * $rowsperpage;

//echo sprintf("SELECT id, cname, DATE_FORMAT(lastedited, '%%W %%M %%D %%Y') FROM %s %s ORDER BY %s LIMIT %d OFFSET %d",
//      $TABLE_CHARS,
//      $qname,
//      $orderby,
//      $rowsperpage,
//      $offset);

    $res = mysql_query(sprintf("SELECT id, cname, DATE_FORMAT(lastedited, '%%W %%M %%D %%Y'), template_id FROM %s %s ORDER BY %s LIMIT %d OFFSET %d",
      $TABLE_CHARS,
      $qname,
      $orderby,
      $rowsperpage,
      $offset));
    if (!$res)
      __printFatalErr(mysql_error()."<br>Failed to query database.", __LINE__, __FILE__);
    $results = array();
    while ($row = mysql_fetch_row($res))
      array_push($results, array('id' => $row[0], 'cname' => $row[1], 'lastedited' => $row[2], 'template' => dotemplatename($row[3])));

    $T->SetBodyTemplate('adminsearch_results.tpl');
    $T->assign('ch_name', $ch_name);
    $T->assign('ls_mod', $ls_mod);
    $T->assign('characters', $results);

    $T->assign('type', $_GET['type']);
    $T->assign('cname', $_GET['cname']);

    $T->assign('np',$np);

    if ($page > 1)
      $T->assign('prevpage', $page - 1);

    if (sizeof($results) == $rowsperpage)
      $T->assign('nextpage', $page + 1);
  }
  else
  {
    // No query string, show the search page.
    $T->SetBodyTemplate('adminsearch.tpl');
  }

  $T->send();
?>
