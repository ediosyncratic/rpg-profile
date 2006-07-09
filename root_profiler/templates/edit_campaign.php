<!--

ID
Name                 (text field)
Website              (text field)
Active               (tick box)
Open for Joining     (tick box)

================================
Current Player List

Name      Player    Edited   Template
---------------------------------------------
_Bob_     Fred      date     3.5       _Remove_
_Sam_     Jane      date     3.0       _Remove_


[ if requests ]
================================
Current Requests/Invites to Join

Name      Player    Edited   Template  Type
--------------------------------------------------------------------
_Tom_     Matt      date     3.5       Requested        _Allow_ _Deny_
_Chad_    Sarah     date     3.5       Invited          _Uninvite_
Wacko     John      date     3.5       Declined Invite  _Remove_

[ end if ]

[ if open ]
================================
Invite Player

Player ID:   [text field]
[Invite]

[ end if ]

-->

<?php
global $sid, $campaign, $URI_BASE;
global $update_invite, $update_details, $update_char;

?>
<form action="edit_campaign.php" method="post">
  <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
  <input type="hidden" name="update" value="true"/>

<h1>Campaign :: <?php echo $campaign->cname; ?><span class="notice"> <?php echo $update_details; ?></span></h1>

<table>
<tr>
  <td>ID</td>
  <td><?php echo $campaign->id; ?></td>
</tr>
<tr>
  <td>Name</td>
  <td><input type="text" name="name" value="<?php echo $campaign->cname; ?>"/></td>
</tr>
<tr>
  <td>Active:</td>
  <td>
    <input type="checkbox" class="quick" name="active" value="yes" <?php if( $campaign->active ) { ?>checked<?php } ?>/>
  </td>
</tr>
<tr>
  <td>Website</td>
  <td><input type="text" name="website" value="<?php echo $campaign->website; ?>"/></td>
</tr> 
<tr><td colspan="2"></td></tr>
<tr>
  <td></td>
  <td align="right"><input type="submit" value="Save" class="go"/></td>
</tr>
</table>

</form>

<!-- Character List -->
<?php
if( count( $campaign->GetCharacters() ) > 0 ) {
?>
  <h1>Registered Characters <span class="notice"><?php echo $update_char; ?></span></h1>
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
<td class="c">
  <form action="edit_campaign.php" method="post" style="margin:0px; padding:0px;">
    <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
    <input type="hidden" name="remove_character" value="<?php echo $character['id']; ?>"/>
    <input type="submit" class="go" value="Remove" onclick="return confirm('Are you sure you want to remove this character.');"/>
  </form>
</td>
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
  <form action="edit_campaign.php" method="post" style="margin:0px; padding:0px;">
    <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
    <input type="hidden" name="cancel_join" value="<?php echo $character['id']; ?>"/>
    <input type="submit" class="go" value="Cancel"/>
  </form>
</td>
<?php } else { ?>
<td class="c">Request</td>
<td class="c">
  <form action="edit_campaign.php" method="post" style="margin:0px; padding:0px;">
    <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
    <input type="hidden" name="accept_join_request" value="<?php echo $character['id']; ?>"/>
    <input type="submit" class="go" value="Accept"/>
  </form>
</td>
<td class="c">
  <form action="edit_campaign.php" method="post" style="margin:0px; padding:0px;">
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

<h1>Invite Character</h1>
<p>To invite a character to join this campaign, enter the character ID in the field, and click Invite. 
   Invitations must be accepted by the character owner.</p>
<form action="edit_campaign.php" method="post">
<p>
  <input type="hidden" name="id" value="<?php echo $campaign->id; ?>"/>
  <input type="text" name="invite_character" class="quick" maxlength="20" />
  <input type="submit" value="Invite" class="go"/>
</p>
</form>

