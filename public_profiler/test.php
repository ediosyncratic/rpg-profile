<?
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
	$pg_st = $pg - 5;
	if ($pg_st < 1 ) {
		$pg_st = 1;
	}
	if ($pg > 1){
		$out .= "<a href='$PHP_SELF?pagenum=1'>&lt;&lt;</a> ";
	}
	$pg_bk = $pg - 10;
	if ($pg_bk > 0){
		$out .= "<a href='$PHP_SELF?pagenum=$pg_bk'>&lt;</a> ";
	} 


	$pg_ed = $pg + 5;
	if ($pg_ed > $pg_ttl ) {
                $pg_ed = $pg_ttl;
        }
	$pg_eb = $pg + 10;
        if ($pg_eb < $pg_ttl){
                $out2 .= "<a href='$PHP_SELF?pagenum=$pg_eb'>&gt;</a> ";
        }
	if ($pg < ($pg_ttl-1)){
                $out2 .= "<a href='$PHP_SELF?pagenum=" . ($pg_ttl - 1) . "'>&gt;&gt;</a> ";
        }
	for($a=$pg_st; $a<$pg_ed; $a++){
		if ($pg == $a ) {
			$out .= $a . " ";
		}else{
			$out .= "<a href='$PHP_SELF?pagenum=$a'>$a</a> ";
		}
	}
	$out .= $out2;
	return $out;
}


$dir = "/home/snikbot/public_html/3eprofiler/charimg/";
$url = "http://www.sylnae.net/3eprofiler/charimg/";
$pagelimit = "4";
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
		$pg_out .= "<tr><td align='center'><img src='" . $url . $mylist[$l] . "' width='125' height='193' border='0'><br>" . $url . $mylist[$l] . "</td>\n";
		$ln = 2;
	}else{
	if ($ln=='2'){
		$pg_out .= "<td align='center'><img src='" . $url . $mylist[$l] . "' width='125' height='193' border='0'><br>" . $url . $mylist[$l] . "</td>\n";
		$ln = 0;
	}else{
		$pg_out .= "<td align='center'><img src='" . $url . $mylist[$l] . "' width='125' height='193' border='0'><br>" . $url . $mylist[$l] . "</td></tr>\n";
		$ln = 1;
	}
	}
}
$pg_out .= "</table></div>\n";
$pg_out .= "<div align='center'> Page:";
$pg_out .= pagelist($pagenum, $pagelimit, $ttl_imgs);
$pg_out .= "</div>\n";

echo $pg_out;
?>
