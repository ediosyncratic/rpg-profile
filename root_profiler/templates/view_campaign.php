<!--

Name
Website
Status
Available

================================
Current Player List

Name    Player    Edited   Template
------------------------------------
Bob     Fred      date     3.5
Sam     Jane      date     3.0

-->

<?php
global $sid, $campaign, $URI_BASE;
?>

<h1>Campaign :: <?php echo $campaign->cname; ?></h1>

<table>
<tr valign="top">
  <td nowrap>ID</td>
  <td><?php echo $campaign->id; ?></td>
</tr>
<tr valign="top">
  <td nowrap>Description</td>
  <td><?php echo $campaign->desc; ?></td>
</tr>
<tr valign="top">
  <td nowrap>Status</td>
  <td>
    <?php if( $campaign->active ) { ?>
      Active
    <?php } else { ?>
      Inactive
    <?php } ?></td>
</tr>
<tr valign="top">
  <td nowrap>Open for Registrations</td>
  <td>
    <?php if( $campaign->open ) { ?>
      Yes
    <?php } else { ?>
      No
    <?php } ?></td>
</tr>
<tr valign="top">
  <td nowrap>PC Level Requirements</td>
  <td><?php echo $campaign->pc_level; ?></td>
</tr>
<tr valign="top">
  <td nowrap>Alignment Requirements</td>
  <td><?php echo $campaign->pc_alignment; ?></td>
</tr>
<tr valign="top">
  <td nowrap>Max Players</td>
  <td><?php echo $campaign->max_players; ?></td>
</tr>
<?php if( $campaign->website ) { ?>
<tr valign="top">
  <td nowrap>Website</td>
  <td><a href="<?php echo $campaign->website; ?>">Click</a></td>
</tr>
<?php } ?>
</table>

<!-- Character List -->
<?php
if( ($sid->GetUserName() == $campaign->owner) && (count( $campaign->GetCharacters() ) > 0) ) {
?>
  <h1>Registered Characters</h1>
  <table class="clist indent">
    <thead>
      <tr>
        <th>Name</th>
        <th>Player</th>
        <th>Edited</th>
        <th>Template</th>
      </tr>
    </thead>
    <tbody>
<?php
  foreach( $campaign->GetCharacters() as $character ) {
?>
<tr>
<td><a href="<?php echo $URI_BASE . "view.php?id=" . $character['id']; ?>"><?php echo $character['name']; ?></a></td>
<td class="c"><?php echo $character['owner']; ?></td>
<td class="c"><?php echo $character['edited']; ?></td>
<td class="c"><?php echo $character['template']; ?></td>
</tr>
<?php
  } // Foreach
?>
    </tbody>
  </table>
<?php
} // if
?>

