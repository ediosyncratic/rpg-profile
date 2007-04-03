<!--
  login.tpl

  Defines the body text for the login page.
-->
<?php global $OPEN_REGISTRATION, $FORUM, $FORUM_LOGIN, $DISPLAY_STATS; ?>

<?php if( !$FORUM ) { ?>

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
<?php if( $DISPLAY_STATS ) { ?>
      <p class="smaller">
        Registered Users: <?php echo GetUserCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Registered Characters: <?php echo GetCharacterCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Online Users: <?php echo GetUsersOnlineCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Public Characters: <?php echo GetPublicCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="stats.php">More Stats</a>
      </p>
<?php } ?>
      <p>
        <?php if ( $OPEN_REGISTRATION ) { ?>
        You must have previously <a href="register.php">registered</a> before you can login.<br />
        <?php } else { ?>
        This site is private. Contact the webmaster for an account.<br />
        <?php } ?>
        Can't remember your password? Have it <a href="resetpwd.php">reset</a>.
      </p>
<?php } else { ?>
  <script>document.location.href='<?php echo $FORUM_LOGIN; ?>';</script>
<?php } ?>

