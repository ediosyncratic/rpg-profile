<!--
  register.tpl

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

  Defines the body text for the registration page.
-->
      <h1>Registration</h1>
      <p>
        To use RPG Web Profiler, you need to create a profile. By creating a profile, you are agreeing to this site's <a href="<?php echo getUriTos(); ?>">terms of use</a>.
      </p>
      <form action="register.php" method="post" class="offset">
        <table> 
          <tr>
            <td>Chose a profile name:</td>
            <td><input type="text" name="user" class="quick" maxlength="20" /></td>
          </tr>
          <tr>
            <td>Choose a password:</td>
            <td><input type="password" name="pwd1" class="quick" maxlength="20" /></td>
          </tr>
          <tr>
            <td>Verify your password:</td>
            <td><input type="password" name="pwd2" class="quick" maxlength="20" /></td>
          </tr>
          <tr>
            <td>Your email address<sup>&dagger;</sup>:</td>
            <td><input type="text" name="email" class="quick" maxlength="50" /></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" value="Create Profile" class="go" /></td>
          </tr>
        </table>
      </form>
      <p>
        <sup>&dagger;</sup>Your email is required to change your password in the event you can't login (due to a forgotten password, for example).
      </p>
