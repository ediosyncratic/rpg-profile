<!--
  char.php

  3EProfiler (tm) template file.
  Copyright (C) 2003 Michael J. Eggertson.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  **
  
  Defines the character permissions page.
-->

<?php

global $public_updated, $inactive_updated, $profiles_updated, $template_updated, $campaign_updated;
global $is_public, $profiles, $templates, $current_template, $exp_formats, $imp_formats;
global $is_owner, $character, $campaign, $pending_campaign, $is_inactive;

?>
<script>
function confirm_leave() {
  return confirm('Are you sure you want to leave this campaign?');
}
</script>

<h1><?php echo $username . ' :: ' . $character->cname; ?> :: Permissions</h1>

<?php if( $is_owner ) { ?>
<h1>Public Character<?php if( $public_updated ) { ?><span class="notice"><?php echo $public_updated; ?></span><?php } ?></h1>
<form action="char.php" method="post">
<?php if( $is_public ) { ?>
  <p>
    This character is a public character. This means that anyone can
    view (but not edit) the character sheet. The uri of your character
    is: <a href="view.php?id=<?php echo $character->id; ?>"><?php echo getUriBase(); ?>view.php?id=<?php echo $character->id; ?></a>
  </p>
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="hidden" name="public" value="false" />
    <input type="submit" value="Remove Public Permission" class="go" />
  </p>
<?php } else { ?>
  <p>
    You can make your character a public character. Anyone can view
    (but not edit) a public character, regardless of whether they're
    logged in to 3EProfiler. This is very useful if you wish to share
    your character in a public forum, for example.
  </p>
  <p>
    Your character is not a public character.
  </p>
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="hidden" name="public" value="true" />
    <input type="submit" value="Apply Public Permission" class="go" />
  </p>
<?php } ?>
</form>

<h1>Campaign<?php if( $campaign_updated ) { ?><span class="notice"><?php echo $campaign_updated; ?></span><?php } ?></h1>
<form action="char.php" method="post">
  <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
<?php if( $character->campaign_id ) { ?>
  <p>This character is currently in the campaign <b><?php echo $campaign->cname; ?></b>, which is owned by <b><?php echo $campaign->owner; ?></b>.</p>
  <p><input type="submit" value="Leave Campaign" class="go" onclick='return confirm_leave();'/></p>
  <input type="hidden" name="leave_campaign" value="true"/>
<?php } else if( $pending_campaign ) { ?>
  <?php if( $pending_campaign['status'] == 'RJ' ) { ?>
    This character has requested to join the campaign <b><?php echo $campaign->cname; ?></b>, which is owned by <b><?php echo $campaign->owner; ?></b>.</p>
    <input type="hidden" name="cancel_join_campaign" value="true"/>
    <p><input type="submit" value="Cancel Request" class="go"/></p>
  <?php } else if( $pending_campaign['status'] == 'IJ' ) { ?>
    This character has been invited to join the campaign <b><?php echo $campaign->cname; ?></b>, which is owned by <b><?php echo $campaign->owner; ?></b>.</p>
    <input type="hidden" name="accept_join_campaign" value="true"/>
    <p><input type="submit" value="Accept Invitation" class="go"/></p>
</form>
<form action="char.php" method="post">
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="hidden" name="cancel_join_campaign" value="true"/>
    <p><input type="submit" value="Decline Invitation" class="go"/></p>
  <?php } ?>
<?php } else { ?>
  <p>This character is not currently in any campaigns. To request to join a campaign, enter the campaign ID in the box below. 
     Join requests must be approved by the campaign owner.</p>
  <p>
  <input type="text" name="join_campaign" class="quick" maxlength="20" />
  <input type="submit" value="Join Campaign" class="go"/>
  </p>
<?php } ?> 

</form>

<h1>Active Character<?php if( $inactive_updated ) { ?><span class="notice"><?php echo $inactive_updated; ?></span><?php } ?></h1>
<form action="char.php" method="post">
<?php if( $is_inactive ) { ?>
  <p>
    This character is inactive. This means that it will not appear in your main character list,
    but will appear further down the page. Activate the character to move it back to the main list.
  </p>
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="hidden" name="inactive" value="false" />
    <input type="submit" value="Activate" class="go" />
  </p>
<?php } else { ?>
  <p>
    This character is active. This means that it will appear in your main character list.
    Deactivating the character will move it to a secondary list at the bottom of your characters page.
  </p>
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="hidden" name="inactive" value="true" />
    <input type="submit" value="Deactivate" class="go" />
  </p>
<?php } ?>
</form>


<h1>Access Permissions<?php if( $profiles_updated ) { ?><span class="notice"><?php echo $profiles_updated; ?></span><?php } ?></h1>
    The following profiles have permission to edit this character:
<table>
<?php foreach( $profiles as $profile ) { ?>
<tr>
<td><b><?php echo $profile; ?></b></td>
<td><a href="char.php?id=<?php echo $character->id; ?>&remove_profile=<?php echo $profile; ?>">Remove</a></td>
</tr>
<?php } ?>
</table>
  <p>
    You can grant editing permission to other profiles, but you must do it
    one profile at a time. Editing permission can be removed by the owner 
    of the character.
  </p>
<form action="char.php" method="post">
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="text" name="add_profile" class="quick" maxlength="20" /> <input type="submit" value="Grant Editing Permission" class="go" />
  </p>
</form>
<?php } ?> <!-- End IS OWNER -->

<h1>Remove Character</h1>
<form action="del.php" method="post">
  <p>
    You can remove this character from your profile. If you are the owner of the
    character, it will be deleted. If you are not the owner, it will only remove
    the editor permissions from your profile. 
  </p>
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="submit" class="go" value="Remove Character" />
  </p>
</form>

<?php if( $is_owner ) { ?>
<h1>Transfer Character</h1>
<form action="char.php" method="post">
  <p>
    You can transfer ownership of a character to a different profile. To do this,
    enter the profile name below.
  </p>
  <p>
    <input type="text" name="transfer" class="quick" maxlength="20"/>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <input type="submit" class="go" value="Transfer" />
  </p>
</form>

<h1>Character Sheet Template<?php if( $template_updated ) { ?><span class="notice"><?php echo $template_updated; ?></span><?php } ?></h1>
<form action="char.php" method="post">
  <p>
    You can change which template your chracter data is drawn to. Your
    character sheet is currently using the template <b><?php echo $current_template; ?></b>.
  </p>
  <p>
    <b>Important!</b> Changing templates may result in a partial or complete
    loss of data if the new template is incompatible with the existing template.
    Your data will not be overwritten until you save your character
    sheet, so if you don't like the changes, make sure you close any open
    character sheet without saving, then come back here and switch the template back.
    Alternatively, you can download a backup of your character sheet in case
    your data is lost and you wish to restore it.
  </p>
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    <select name="tid" class="quick">
      <option>&lt;-- Select Template --&gt;</option>
<?php foreach( $templates as $template) { ?>
<option value="<?php echo $template['id']; ?>"><?php echo $template['name']; ?></option>
<?php } ?>
    </select>
    <input type="submit" value="Apply Template" class="go" />
  </p>
</form>
<?php } ?> <!-- END IS OWNER -->

<h1>Download Character</h1>
<form action="download.php" method="post">
  <p>
    You can download a copy of your character. You can use the file to
    act as a backup, or to move your character to another server, or
    even import the file into compatible programs.
  </p>
  <p>
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    Download format: <select name="format" class="quick">
<?php foreach( $exp_formats as $exp_format ) { ?>
<option value="<?php echo $exp_format['id']; ?>"><?php echo $exp_format['title']; ?></option>
<?php } ?>
</select>
    <input type="submit" value="Download" class="go" />
  </p>
</form>

<h1>Restore Character</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <p>
    You can upload a backup file to restore your character to a previous
    version, or import a character from another site or compatible program.
  </p>
  <p>
    <input type="hidden" name="MAX_FILE_SIZE" value="5120000" />
    <input type="hidden" name="id" value="<?php echo $character->id; ?>" />
    Upload File: <input type="file" name="userfile" />
    Using Format: <select name="format" class="quick"><option value="0" selected="selected">Auto Detect</option>
<?php foreach( $imp_formats as $imp_format ) { ?>
<option value="<?php echo $imp_format['id']; ?>"><?php echo $imp_format['title']; ?></option>
<?php } ?>
</select>
    <input type="submit" value="Upload" onclick="return confirm('Uploading data will overwrite any existing character data. Do you wish to continue?')" class="go" />
  </p>
</form>
