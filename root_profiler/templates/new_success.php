<!--
  new_success.tpl

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

  Generates a message for the user after a character has been created for
  him/her.
-->
<?php global $name, $id; ?>

<h1>Character Created!</h1>
<p>
  <strong><?php echo getUserName(); ?></strong>, the character <strong><?php echo $name; ?></strong> (id = <?php echo $id; ?>)
  was created and your profile was registered as an owner of the character
  sheet.
</p>
<p>
  You can return to your <a href="cview.php">character
  options</a> menu where you can edit this new character sheet, or create
  another character sheet.
</p>
