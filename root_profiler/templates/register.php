<!--
  register.tpl
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
