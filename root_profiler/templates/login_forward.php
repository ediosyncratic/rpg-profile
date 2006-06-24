<!--
  login_forward.tpl

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
-->
<h1>Welcome Back!</h1>
<p>
  Welcome back, <?php echo getUserName(); ?>. You are still logged in from your previous visit.
  Continue to your <a href="cview.php">character</a> or
  <a href="pview.php">profile</a> management pages.
</p>
<p>
  If you are not <?php echo getUserName(); ?>, please
  <a href="logout.php">logout</a>, then login with your own
  profile, or register a new profile if you're a new visitor.
</p>
      <p class="smaller">
        Registered Users: <?php echo GetUserCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Registered Characters: <?php echo GetCharacterCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Online Users: <?php echo GetUsersOnlineCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Public Characters: <?php echo GetPublicCount(); ?>
      </p>

