{*
  char.tpl

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
*}

<h1>{$username} :: {$character} :: Permissions</h1>

<h1>Public Character{if $public_updated}<span class="notice">{$public_updated}</span>{/if}</h1>
<form action="char.php" method="post">
{if $is_public}
  <p>
    This character is a public character. This means that anyone can
    view (but not edit) the character sheet. The uri of your character
    is: <a href="view.php?id={$id}">{$URI_BASE}view.php?id={$id}</a>
  </p>
  <p>
    <input type="hidden" name="id" value="{$id}" />
    <input type="hidden" name="public" value="false" />
    <input type="submit" value="Remove Public Permission" class="go" />
  </p>
{else}
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
    <input type="hidden" name="id" value="{$id}" />
    <input type="hidden" name="public" value="true" />
    <input type="submit" value="Apply Public Permission" class="go" />
  </p>
{/if}
</form>

<h1>Access Permissions{if $profiles_updated}<span class="notice">{$profiles_updated}</span>{/if}</h1>
<form action="char.php" method="post">
  <p>
    The following profiles have permission to edit this character:
{section name=profile loop=$profiles}{if $smarty.section.profile.index},{/if} <b>{$profiles[profile]}</b>{/section}.
  </p>
  <p>
    You can grant editing permission to other profiles, but you must do it
    one profile at a time. Once you grant a profile permission, you can
    not remove it's permission.
  </p>
  <p>
    <input type="hidden" name="id" value="{$id}" />
    <input type="text" name="add_profile" class="quick" maxlength="20" /> <input type="submit" value="Grant Editing Permission" class="go" />
  </p>
</form>

<h1>Remove Character</h1>
<form action="del.php" method="post">
  <p>
    You can remove this character from your profile. If no other profiles
    have access to the character sheet, it will be permanently deleted.
    If the character sheet is shared with other profiles, access to the
    sheet from your profile will be removed, but the character data will
    be unaffected.
  </p>
  <p>
    <input type="hidden" name="id" value="{$id}" />
    <input type="submit" class="go" value="Remove Character" />
  </p>
</form>

<h1>Character Sheet Template{if $template_updated}<span class="notice">{$template_updated}</span>{/if}</h1>
<form action="char.php" method="post">
  <p>
    You can change which template your chracter data is drawn to. Your
    character sheet is currently using the template <b>{$current_template}</b>.
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
    <input type="hidden" name="id" value="{$id}" />
    <select name="tid" class="quick">
      <option>&lt;-- Select Template --&gt;</option>
{section name=template loop=$templates}<option value="{$templates[template].id}">{$templates[template].name}</option>{/section}
    </select>
    <input type="submit" value="Apply Template" class="go" />
  </p>
</form>

<h1>Download Character</h1>
<form action="download.php" method="post">
  <p>
    You can download a copy of your character. You can use the file to
    act as a backup, or to move your character to another server, or
    even import the file into compatible programs.
  </p>
  <p>
    <input type="hidden" name="id" value="{$id}" />
    Download format: <select name="format" class="quick">{section name=exp loop=$exp_formats}<option value="{$exp_formats[exp].id}">{$exp_formats[exp].title}</option>{/section}</select>
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
    <input type="hidden" name="id" value="{$id}" />
    Upload File: <input type="file" name="userfile" />
    Using Format: <select name="format" class="quick"><option value="0" selected="selected">Auto Detect</option>{section name=fmt loop=$imp_formats}<option value="{$imp_formats[fmt].id}">{$imp_formats[fmt].title}</option>{/section}</select>
    <input type="submit" value="Upload" onclick="return confirm('Uploading data will overwrite any existing character data. Do you wish to continue?')" class="go" />
  </p>
</form>
