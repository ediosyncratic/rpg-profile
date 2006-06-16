{*
  cview.tpl

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
*}

<h1>{$username} :: Character Options</h1>
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
      <td><select name="template" class="quick">{section name=tpl loop=$templates}<option value="{$templates[tpl].id}"{if $templates[tpl].id == 1} selected="selected"{/if}>{$templates[tpl].name}</option>{/section}</select></td>
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
        <th>Character Name</th>
        <th>ID</th>
        <th>Public?</th>
        <th>Last Edited</th>
        <th>Edited By</th>
      </tr>
    </thead>
    <tbody>
      {section name=character loop=$characters}
      <tr>
        <td><a href="view.php?id={$characters[character].id}" target="_blank">{$characters[character].name}</a></td>
        <td class="c">{$characters[character].id}</td>
        <td class="c">{if $characters[character].public eq 'y'}Yes{else}No{/if}</td>
        <td class="c">{$characters[character].lastedited}</td>
        <td class="c">{$characters[character].editedby}</td>
      </tr>
      {sectionelse}
      <tr>
        <td colspan="5">You don't have any characters!</td>
      </tr>
      {/section}
    </tbody>
  </table>
<h1>Modify Character Details</h1>
<form action="char.php" method="post">
  <p>
    Change permissions for a character sheet such as making it publicly
    viewable or sharing it with another profile, change which template
    your character sheet uses, and various other character specific options
    that aren't settable from your character sheet.
  </p>
  <p>
    <select name="id" class="quick">
      <option>&lt;--Select a character--&gt;</option>
      {section name=character loop=$characters}<option value="{$characters[character].id}">{$characters[character].name} (#{$characters[character].id})</option>{/section}
    </select>
    <input type="submit" class="go" value="Go!" />
  </p>
</form>
