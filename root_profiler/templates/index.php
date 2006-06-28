<!--
  index.tpl

  RPGWebProfiler (tm) template file.
  based on
  3eProfiler (tm) template file.
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
<?php global $OPEN_REGISTRATION, $SITE_NEWS; ?>

<?php 
$newsFile = $INCLUDE_PATH . '/templates/' . $SITE_NEWS;

if( $SITE_NEWS && file_exists($newsFile) ) {
  include($newsFile); 
}
?>

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
        Registered Users: <?php echo GetUserCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Registered Characters: <?php echo GetCharacterCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Online Users: <?php echo GetUsersOnlineCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Public Characters: <?php echo GetPublicCount(); ?>
      </p>
      <p>
        <?php if ( $OPEN_REGISTRATION ) { ?>
        You must have previously <a href="register.php">registered</a> before you can login.<br />
        <?php } else { ?>
        This site is private. Contact the webmaster for an account.<br />
        <?php } ?>
        Can't remember your password? Have it <a href="resetpwd.php">reset</a>.
      </p>

