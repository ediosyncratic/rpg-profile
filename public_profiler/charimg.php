<?php
  // char.php

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

  // Defines the character permissions page and also implements some
  // basic permission methods.

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/character.class.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/serialization.php");

  $sid = RespawnSession(__LINE__, __FILE__);


function listImages($dirname=".") {
   $ext = array("jpg", "png", "jpeg", "gif");
   $files = array();
   if($handle = opendir($dirname)) {
       while(false !== ($file = readdir($handle)))
           for($i=0;$i<sizeof($ext);$i++)
               if(strstr($file, ".".$ext[$i]))
                   $files[] = $file;

       closedir($handle);
   }
   return($files);
}
function pagelist($pg, $pg_limit, $img_ttl){
        $out = "";
        $pg_ttl = floor($img_ttl/$pg_limit)+2;
        $pg_st = $pg - 3;
        if ($pg_st < 1 ) {
                $pg_st = 1;
        }
        if ($pg > 1){
                $out .= "<a href='$PHP_SELF?pagenum=1'>&lt;&lt;&nbsp;</a> ";
        }
        $pg_bk = $pg - 1;
        if ($pg_bk > 0){
                $out .= "<a href='$PHP_SELF?pagenum=$pg_bk'>&lt;&nbsp;</a> ";
        }


        $pg_ed = $pg + 4;
        if ($pg_ed > $pg_ttl ) {
                $pg_ed = $pg_ttl;
        }
        $pg_eb = $pg + 1;
        if ($pg_eb < $pg_ttl){
                $out2 .= "<a href='$PHP_SELF?pagenum=$pg_eb'>&nbsp;&gt;</a> ";
        }
        if ($pg < ($pg_ttl-1)){
                $out2 .= "<a href='$PHP_SELF?pagenum=" . ($pg_ttl - 1) . "'>&nbsp;&gt;&gt;</a> ";
        }
        for($a=$pg_st; $a<$pg_ed; $a++){
                if ($pg == $a ) {
                        $out .= $a . " ";
                }else{
                        $out .= "<a href='$PHP_SELF?pagenum=$a'>$a</a> ";
                }
        }
        $out .= $out2 . " Total Pages: " . ($pg_ttl - 1);
	return $out;
}


$dir = $WEB_INSTALL . "/charimg/";
$url = $URI_BASE . "charimg/";
$pagelimit = "4";

$pagenum = $_GET["pagenum"];
If ((!$pagenum)||(!is_numeric($pagenum))){
	$pagenum = 1;
}

$mylist = array();
$mylist = listImages($dir);

$ttl_imgs = sizeof($mylist);
$pg_st = ($pagenum - 1) * $pagelimit;
$pg_ed = $pagenum * $pagelimit;

If ($pg_ed > $ttl_imgs ) {
	$pg_ed = $ttl_imgs;
}
$pg_out = "";

$pg_out .= "<div align='center'> Page:";
$pg_out .= pagelist($pagenum, $pagelimit, $ttl_imgs);
$pg_out .= "</div>\n";
$pg_out .= "<div align='center'><table border='1' cellspacing='10' cellpadding='10' bordercolor='#666666' bordercolordark='#FFFFFF'>\n";
$ln = 1;
for($l=$pg_st; $l<$pg_ed; $l++){
	if ($ln=='1'){
		$pg_out .= "<tr><td align='center'><img src='" . $url . $mylist[$l] . "' width='125' height='193' border='0'><br>";
		$pg_out .= "<div id='foot'>" . $url . $mylist[$l] . "</div></td>\n";
		$ln = 0;
	}else{
	if ($ln=='2'){
		$pg_out .= "<td align='center'><img src='" . $url . $mylist[$l] . "' width='125' height='193' border='0'><br>";
		$pg_out .= "<div id='foot'>" . $url . $mylist[$l] . "</div></td>\n";
		$ln = 0;
	}else{
		$pg_out .= "<td align='center'><img src='" . $url . $mylist[$l] . "' width='125' height='193' border='0'><br>";
		$pg_out .= "<div id='foot'>" . $url . $mylist[$l] . "</div></td></tr>\n";
		$ln = 1;
	}
	}
}
$pg_out .= "</table></div>\n";
$pg_out .= "<div align='center'> Page:";
$pg_out .= pagelist($pagenum, $pagelimit, $ttl_imgs);
$pg_out .= "</div>\n";


$title = 'Character Images';
$output = $pg_out;
draw_page('charimg.php');

?>
