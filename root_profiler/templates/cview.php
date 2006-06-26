<!--
  cview.php

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

  Defines the interface displayed to the user when they're visiting the
  character options page.
-->
<?php
global $templates, $characters, $NEW_WINDOW;
?>


<h1><?php echo getUserName(); ?> :: Character Options</h1>
<h1>New Character Sheet</h1>
<form action="new.php" method="post">
  <p>
    To create a new character sheet, specify a proper name below.
    Only one character sheet can be created at a time.
    Character names must be alphanumeric and 20 characters or less.
  </p>
  <table>
    <tr>
      <td>Character name:</td>
      <td><input type="text" name="newname" class="quick" maxlength="20" /></td>
    </tr>
    <tr>
      <td>Using template:</td>
      <td>
<select name="template" class="quick">
<?php foreach( $templates as $template) { ?>
<option value="<?php echo $template['id']; ?>"><?php echo $template['name']; ?></option>
<?php } ?>
</select></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit"class="go" value="Create" /></td>
    </tr>
  </table>
</form>
<h1>View/Edit Character Sheet</h1>
  <p class="indent">
    If you wish to edit or view any of your existing characters, select
    from the list below.
  </p>
  <table class="clist indent">
    <thead>
      <tr>
        <th>Character</th>
        <th>ID</th>
        <th>Public?</th>
        <th>Edited</th>
        <th>Editor</th>
        <th>Template</th>
        <th>Modify</th>
      </tr>
    </thead>
    <tbody>
<?php
if( count( $characters ) > 0 ) {
  foreach( $characters as $character ) {
?>
      <tr>
        <td><a href="view.php?id=<?php echo $character['id']; ?>" <?php if( $NEW_WINDOW ) { ?>target="_blank"<?php } ?>><?php echo $character['name']; ?></a></td>
        <td class="c"><?php echo $character['id']; ?></td>
        <td class="c"><?php echo $character['public'] == 'y' ? 'Yes' : 'No'; ?></td>
        <td class="c"><?php echo $character['lastedited']; ?></td>
        <td class="c"><?php echo $character['editedby']; ?></td>
        <td class="c"><?php echo $character['template']; ?></td>
        <td><a href="char.php?id=<?php echo $character['id']; ?>">Details</a></td>
      </tr>
<?php
  }
} else { ?>
      <tr>
        <td colspan="5">You don't have any characters!</td>
      </tr>
<?php } ?>
    </tbody>
  </table>