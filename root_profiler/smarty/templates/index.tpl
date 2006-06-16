{*
  index.tpl

  Camberra (tm) template file
  Copyright (C) 2005 Tim Tooley
  -- based on --
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

  Defines the page body that is displayed when a user who is already
  logged in goes to the login page.
*}
<h1>News</h1>
<h2>Dec, 2005</h2>
<p>
  We have Started on Camberra ( Meeting place for DM's and players )
<blockquote>
Some features will include:
 <blockquote>
Players:<br>
&nbsp; HackandSlash vs RolePlayer meter<br>
&nbsp; Prefered days to play<br>
&nbsp; Prefered times to play<br>
&nbsp; Background ( i.e. other games they have played, etc. )<br>
&nbsp; Request to join game ( and to remove self from game )<br>

 </blockquote>
 <blockquote>
DM's:<br>
&nbsp; HackandSlash vs RolePayer meter<br>
  <blockquote>
Campaign settings<br>
&nbsp; Name<br>
&nbsp; Description<br>
&nbsp; PC Level Requirements<br>
&nbsp; PC Alignment Requirements<br>
&nbsp; Max # of players ( with how many are already in group )<br>
&nbsp; Player List - link to profiles of characters<br>
&nbsp; Open / Closed / Full status<br>
&nbsp; Day and Time of sessions<br>
&nbsp; list of requests by players to join ( add/hold/drop )<br>

  </blockquote>
 </blockquote>
</blockquote>
If you have any suggestions on features please visit the <a href='http://www.sylnae.net/forums/'>forums</a> and let us know.
</p>
      <h1>Login</h1>
      <p>
        Please provide your profile details below to login:
      </p>
      <form action="cview.php" method="post" class="offset">
        <table>
          <tr>
            <td>What is your name?</td>
            <td><input type="text" name="user" class="quick" maxlength="20" /></td>
          </tr>
          <tr>
            <td>What is your password?</td>
            <td><input type="password" name="pwd" class="quick" maxlength="20" /></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" value="Login" class="go" /></td>
          </tr>
        </table>
      </form>
      <p class="smaller">
        Registered Users: {$count_users} &nbsp;&nbsp;|&nbsp;&nbsp;
        Registered Characters: {$count_characters} &nbsp;&nbsp;|&nbsp;&nbsp;
        Online Users: {$count_online} &nbsp;&nbsp;|&nbsp;&nbsp;
        Public Characters: {$count_public}
      </p>
      <p>
        You must have previously <a href="register.php">registered</a> before you can login.<br />
        Can't remember your password? Have it <a href="resetpwd.php">reset</a>.
      </p>
