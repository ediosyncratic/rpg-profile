<?php
global $sid, $campaign, $URI_BASE;
global $update_invite, $update_details, $update_char;

?>
<h1>Campaign :: <?php echo $campaign->cname; ?></h1>


<!-- Character List -->
<?php
if( count( $campaign->GetCharacters() ) > 0 ) {
    $templateCharacters = array();
    foreach( $campaign->GetCharacters() as $character ) {
        $char = new Character($character['id']);
        $temp = $templateCharacters[$char->template_id];
        if( $temp == null ) {
            $temp = array();  
        }
        array_push($temp, $char);
        $templateCharacters[$char->template_id] = $temp;
    }

    foreach( $templateCharacters as $key => $characters) {
        $sheet = "$INCLUDE_PATH/sheets/" . get_sheet_path($key);
        $sheet = preg_replace("/\.php/", "-Summary.php", $sheet);
        
        $summaryAvailable = false;
        if( file_exists($sheet) ) {
            include($sheet);
            $summaryAvailable = true;
        }
?>
        <h3><?php echo get_sheet_name($key); ?><? if( !$summaryAvailable ) { ?><span class="notice">No summary sheet available.</span><? } ?></h3>
        <ul class="character">
            <li>
                <ul class="characterattribute">
                    <li><strong>Player</strong></li>
                    <li><strong>Name</strong></li>
                    <? if( $summaryAvailable ) { foreach( $summaryTitles as $title ) { ?>
                        <li><strong><?= $title ?></strong></li>
                    <? } } ?>
                </ul>
            </li>
<?
        $i = 1;
        foreach( $characters as $character ) { 
            $data = $character->GetData();
?>
            <li class="row">
                <ul class="characterattribute<? if( $i++ % 2 == 1 ) { ?> oddbg<? } ?>">
                    <li><?php echo $character->owner; ?></li>
                    <li><a href="<?php echo $URI_BASE . "view.php?id=" . $character->id; ?>"><?php echo $character->cname; ?></a></li>
                    <? if( $summaryAvailable ) { foreach( $summaryAttributes as $attr ) { ?>
                    <li><?= $data[$attr] ?></li>
                    <? } } ?>
                </ul>
            </li>
<?php 
        }
?>
        </ul>
<?php
    }
} // if
?>
