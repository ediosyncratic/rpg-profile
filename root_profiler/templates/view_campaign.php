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
  <td nowrap>Players</td>
  <td><?php echo count( $campaign->GetCharacters() ); ?></td>
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
if( count( $campaign->GetCharacters() ) > 0 ) {
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
<?php if( ($sid->GetUserName() == $campaign->owner) || ($character['public'] == 'y') ) { ?>
<td><a href="<?php echo $URI_BASE . "view.php?id=" . $character['id']; ?>"><?php echo $character['name']; ?></a></td>
<?php } else { ?>
<td><?php echo $character['name']; ?></td>
<?php } ?>
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

<!-- Pending Characters -->
<?php
if( count( $campaign->GetJoinRequests() ) > 0 ) {
?>
  <h1>Pending Characters<span class="notice"> <?php echo $update_invite; ?></span></h1>
  <table class="clist indent">
    <thead>
      <tr>
        <th align="left">Name</th>
        <th>Player</th>
        <th>Edited</th>
        <th>Template</th>
        <th>Join Type</th>
      </tr>
    </thead>
    <tbody>
<?php
  foreach( $campaign->GetJoinRequests() as $character ) {
?>
<tr>
<td align="left"><a href="<?php echo $URI_BASE . "view.php?id=" . $character['id']; ?>"><?php echo $character['name']; ?></a></td>
<td class="c"><?php echo $character['owner']; ?></td>
<td class="c"><?php echo $character['edited']; ?></td>
<td class="c"><?php echo $character['template']; ?></td>
<?php if( $character['type'] == 'IJ' ) { ?>
<td class="c">Invite</td>
<td class="c">
  <form action="view_campaign.php" method="post" style="margin:0px; padding:0px;">
    <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
    <input type="hidden" name="cancel_join" value="<?php echo $character['id']; ?>"/>
    <input type="submit" class="go" value="Cancel"/>
  </form>
</td>
<?php } else { ?>
<td class="c">Request</td>
<td class="c">
  <form action="view_campaign.php" method="post" style="margin:0px; padding:0px;">
    <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
    <input type="hidden" name="accept_join_request" value="<?php echo $character['id']; ?>"/>
    <input type="submit" class="go" value="Accept"/>
  </form>
</td>
<td class="c">
  <form action="view_campaign.php" method="post" style="margin:0px; padding:0px;">
    <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
    <input type="hidden" name="cancel_join" value="<?php echo $character['id']; ?>"/>
    <input type="submit" class="go" value="Decline"/>
  </form>
</td>
<?php } ?>
</tr>
<?php
  } // Foreach
?>
    </tbody>
  </table>
<?php
} // if
?>

<?php if( $campaign->open ) { ?>
<h1>Invite Character</h1>
<p>To invite a character to join this campaign, enter the character ID in the field, and click Invite.
   Invitations must be accepted by the character owner.</p>
<form action="view_campaign.php" method="post">
<p>
  <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
  <input type="text" name="invite_character" class="quick" maxlength="20" />
  <input type="submit" value="Invite" class="go"/>
</p>
</form>
<?php } ?>

