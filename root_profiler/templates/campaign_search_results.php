<!--
  search_results.php
-->

<?php
global $campaigns, $nextpage, $prevpage, $name, $type;
?>

<h1>Campaign Search Results</h1>
<table>
<?php if( count($campaigns) > 0 ) { ?>
    <tr>
      <th>Campaign</th>
      <th>Owner</th>
      <th>Characters</th>
    </tr>
<?php foreach( $campaigns as $campaign ) { ?>
      <tr>
        <td style="text-align:left; padding-right:10px;">
          <a href="view_campaign.php?id=<?php echo $campaign['id']; ?>"><?php echo $campaign['name']; ?></a>
        </td>
        <td style="text-align:center; padding-right:10px;"><?php echo $campaign['owner']; ?></td>
        <td style="text-align:center; padding-right:10px;"><?php echo $campaign['characters']; ?></td>
      </tr>
<?php } ?>
<?php } else { ?>
      <tr><td colspan="2">No campaigns found!</td></tr>
<?php } ?>
</table>

<?php if( $prevpage ) { ?>
  <a href="campaign_search.php?type=<?php echo $type; ?>&amp;cname=<?php echo $name; ?>&amp;page=<?php echo $prevpage; ?>">&lt; Previous</a>
  <?php if( $nextpage ) { echo '|'; } ?>
<?php } ?>
<?php if( $nextpage ) { ?>
  <a href="campaign_search.php?type=<?php echo $type; ?>&amp;cname=<?php echo $name; ?>&amp;page=<?php echo $nextpage; ?>">Next &gt;</a>
<?php } ?>
<br><br>
<h1>Campaign Search</h1>
<form action="campaign_search.php" method="get">
<p>
  Search for a campaign whose name <select name="type" class="quick">
 <option value="begins">begins with</option>
 <option value="contains">contains</option>
 <option value="ends">ends with</option>
 <option value="all">all entries</option>
  </select>
 <input type="text" name="cname" maxlength="20" class="quick" />
 <input type="submit" value="Search" class="go" />
</p>
