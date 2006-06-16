{*
  del.tpl

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

  Defines the template shown after a character has been removed from a
  user profile.
*}

<h1>{$username} :: Remove Character</h1>

<p>
  The character, <b>{$character}</b> (id = {$id}), was removed from your profile.
</p>
{if $removed}
<p>
  Since no other profiles had permission to modify the character,
  <b>{$character}</b> was permanently deleted.
</p>
{else}
<p>
  Since other profiles have permission to modify the character,
  <b>{$character}</b> was not deleted, only your permission
  to modify the character was removed.
</p>
{/if}
<p>
  <a href="cview.php">Return to my profile.</a>
</p>
