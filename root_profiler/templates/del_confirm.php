<!--
  del_confirm.tpl

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

  Defines the template for the character deletion confirmation page.
-->
<?php
global $id, $character;
?>

<h1><? echo getUserName(); ?> :: Remove Character</h1>

<h1>Confirmation</h1>
<form action="del.php" method="post">
  <p>
    Are you sure you want to remove your profile's access to the character
    <b><?php echo $character; ?></b> (#<?php echo $id; ?>)? If you are the only person who has
    access to this character, the character data will be permanently deleted.
    If other profiles have access to this character, the character data will
    remain for others, but your permission to edit this chracter will be removed.
  </p>
  <p>
    Remove character?
  </p>
  <p>
    <input type="hidden" name="confirm" value="yes" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="submit" class="go" value="Yes" />
    <input type="button" class="go" onclick="location='cview.php'" value="No" />
  </p>
</form>
