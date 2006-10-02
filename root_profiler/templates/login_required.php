<!--
  login_required.tpl

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

  Defines the interface displayed when the client tries to visit a page
  that requires a login, but has provided no login or session information.
-->
<?php global $FORUM, $FORUM_LOGIN; ?>
<?php if( !$FORUM ) { ?>

<h1>Not Logged In</h1>
<p>
  Sorry, you must be logged in to view this page.
</p>
<form action="cview.php" method="post" class="offset">
  <table> 
    <tr>
      <td>Name:</td>
      <td><input type="text" name="user" class="quick" maxlength="20" /></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><input type="password" name="pwd" class="quick" maxlength="20" />&nbsp;<input type="submit" value="Login" class="go" /></td>
    </tr>
  </table>
</form>
<p>
  <b>Were you already logged in?</b> If so, ensure your browser is
  configured to accept and send cookies, as 3EProfiler uses a cookie to keep
  track of your login state. You can not use 3EProfiler if you do not allow
  this site to store cookies on your computer. It is also possible your login
  session expired, which can happen if you don't have any acitivty for a few
  hours. You can change the length of your sessions in your profile options.
</p>
<?php } else { ?>
  <script>document.location.href='<?php echo $FORUM_LOGIN; ?>';</script>
<?php } ?>

