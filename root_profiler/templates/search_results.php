<!--
  search_results.php
-->

<?php
global $characters, $nextpage, $prevpage, $name, $type;
?>

<h1>Search Results</h1>
<table>
<?php $sort_url = "search.php?type=".$type."&cname=".$name."&sort="; ?>
<?php if( count($characters) > 0 ) { ?>
    <tr>
      <th><a style="color: white;" href="<?php echo $sort_url; ?>cname">Character Name</a></th>
      <th><a style="color: white;" href="<?php echo $sort_url; ?>date">Last Edited</a></th>
      <th><a style="color: white;" href="<?php echo $sort_url; ?>owner">Owner</a></th>
      <th><a style="color: white;" href="<?php echo $sort_url; ?>template">Template</a></th>
      <th><a style="color: white;" href="<?php echo $sort_url; ?>campaign">Campaign</a></th>
    </tr>
<?php foreach( $characters as $character ) { ?>
      <tr>
        <td style="text-align:left; padding-right:10px;">
          <a href="view.php?id=<?php echo $character['id']; ?>"><?php echo $character['name']; ?></a>
        </td>
        <td style="text-align:center; padding-right:10px;"><?php echo $character['lastedited']; ?></td>
        <td style="text-align:center; padding-right:10px;"><?php echo $character['owner']; ?></td>
        <td style="text-align:center; padding-right:10px;"><?php echo $character['template']; ?></td>
        <td style="text-align:center; padding-right:10px;"><?php echo $character['campaign']; ?></td>
      </tr>
<?php } ?>
<?php } else { ?>
      <tr><td colspan="2">No characters found!</td></tr>
<?php } ?>
</table>

<?php if( $prevpage ) { ?>
  <a href="search.php?type=<?php echo $type; ?>&amp;cname=<?php echo $name; ?>&amp;page=<?php echo $prevpage; ?>">&lt; Previous</a>
  <?php if( $nextpage ) { echo '|'; } ?>
<?php } ?>
<?php if( $nextpage ) { ?>
  <a href="search.php?type=<?php echo $type; ?>&amp;cname=<?php echo $name; ?>&amp;page=<?php echo $nextpage; ?>">Next &gt;</a>
<?php } ?>
<br><br>
<h1>Character Search</h1>
<form action="search.php" method="get">
<p>
  Search for a character whose name <select name="type" class="quick">
 <option value="begins">begins with</option>
 <option value="contains">contains</option>
 <option value="ends">ends with</option>
 <option value="all">all entries</option>
  </select>
 <input type="text" name="cname" maxlength="20" class="quick" />
 <input type="submit" value="Search" class="go" />
</p>
