<!--
  resetpwd_passwordform.tpl

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

  Shows the form for changing your password via the reset mechanism.
-->
<?php global $pname, $key; ?>

<h1>Reset Password :: New Password</h1>
<form action="changepwd.php" method="post">
  <input type="hidden" name="key" value="<?php echo $key; ?>" />
  <input type="hidden" name="pname" value="<?php echo $pname; ?>" />
  <p>
    <b><?php echo $pname; ?></b>, enter your new password below.
  </p>
  <table>
    <tr>
      <td>Enter password:</td>
      <td><input type="password" name="pwd1" class="quick" maxlength="20" /></td>
    </tr>
    <tr>
      <td>Verify password:</td>
      <td><input type="password" name="pwd2" class="quick" maxlength="20" /></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Change Password" class="go" /></td>
    </tr>
  </table>
</form>
