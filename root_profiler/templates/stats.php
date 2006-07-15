<h1>Site Statistics</h1>

<?php
global $site;
//    var $charsPerTemplate = array();
?>

<table>
<tr><td>Users:</td><td><?php echo $site->totalUsers; ?></td></tr>
<tr><td>Characters:</td><td><?php echo $site->totalCharacters; ?></td></tr>
<tr><td>Average Characters Per User:</td><td><?php echo $site->averageCharactersPerUser; ?></td></tr>
<tr><td>Public Characters:</td><td><?php echo $site->publicCharacters; ?></td></tr>
<tr><td colspan="s">&nbsp;</td></tr>
<tr><td>Campaigns:</td><td><?php echo $site->totalCampaigns; ?></td></tr>
<tr><td>Characters in Campaigns:</td><td><?php echo $site->charactersInCampaigns; ?></td></tr>
<tr><td>Average Characters Per Campaign:</td><td><?php echo $site->averageCharactersPerCampaign; ?></td></tr>
<tr><td colspan="s">&nbsp;</td></tr>
<tr><td>Active Campaigns:</td><td><?php echo $site->activeCampaigns; ?></td></tr>
<tr><td>Open Campaigns:</td><td><?php echo $site->openCampaigns; ?></td></tr>
<tr><td colspan="s">&nbsp;</td></tr>
<tr valign="top"><td>Template Usage:</td><td>

<table width="200">
<?php foreach( $site->charsPerTemplate as $row ) { ?>
<tr><td><?php echo $row['template']; ?></td><td><?php echo $row['count']; ?></td></tr>
<?php } ?>
</table>

</td></tr>
</table>
