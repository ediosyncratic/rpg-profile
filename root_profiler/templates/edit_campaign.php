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
<tr valign="top">
  <td>ID</td>
  <td><?php echo $campaign->id; ?></td>
</tr>
<tr valign="top">
  <td>Name</td>
  <td><input type="text" name="name" value="<?php echo $campaign->cname; ?>"/></td>
</tr>
<tr valign="top">
  <td>Description</td>
  <td><textarea name="desc" style="width:350px; height:120px;"><?php echo $campaign->desc; ?></textarea></td>
</tr>
<tr valign="top">
  <td>Active</td>
  <td>
    <input type="checkbox" class="quick" name="active" value="yes" <?php if( $campaign->active ) { ?>checked<?php } ?>/>
  </td>
</tr>
<tr valign="top">
  <td>Open for Registration</td>
  <td>
    <input type="checkbox" class="quick" name="open" value="yes" <?php if( $campaign->open ) { ?>checked<?php } ?>/>
  </td>
</tr>
<tr valign="top">
  <td>PC Level Requirements</td>
  <td><input type="text" name="pc_level" value="<?php echo $campaign->pc_level; ?>"/></td>
</tr>
<tr valign="top">
  <td>Alignment Requirements</td>
  <td><input type="text" name="pc_alignment" value="<?php echo $campaign->pc_alignment; ?>"/></td>
</tr>
<tr valign="top">
  <td>Max Players</td>
  <td><input type="text" name="max_players" value="<?php echo $campaign->max_players; ?>"/></td>
</tr>
<tr valign="top">
  <td>Website</td>
  <td><input type="text" name="website" style="width:350px;" value="<?php echo $campaign->website; ?>"/></td>
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
