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
?>

<h1>Campaign :: <?php echo $campaign->cname; ?></h1>

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
    <input type="checkbox" class="quick" name="active" <?php if( $campaign->active ) { ?>checked<?php } ?>/>
  </td>
</tr>
<tr>
  <td>Open for Registrations:</td>
  <td>
    <input type="checkbox" class="quick" name="open" <?php if( $campaign->open ) { ?>checked<?php } ?>/>
  </td>
</tr>
<tr>
  <td>Website</td>
  <td><input type="text" name="website" value="<?php echo $campaign->website; ?>"/></td>
</tr> 
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
<td><a href="<?php echo $URI_BASE . "view.php?id=" . $character['id']; ?>"><?php echo $character['name']; ?></a></td>
<td class="c"><?php echo $character['owner']; ?></td>
<td class="c"><?php echo $character['edited']; ?></td>
<td class="c"><?php echo $character['template']; ?></td>
<td class="c"><a href="">Remove</a></td>
</tr>
<?php 
  } // Foreach
?>
    </tbody>
  </table>
<?php
} // if
?>

