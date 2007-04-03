<!--
  login_required.tpl

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
  configured to accept and send cookies, as RPGWebProfiler uses a cookie to keep
  track of your login state. You can not use RPGWebProfiler if you do not allow
  this site to store cookies on your computer. It is also possible your login
  session expired, which can happen if you don't have any acitivty for a few
  hours. You can change the length of your sessions in your profile options.
</p>
<?php } else { ?>
  <script>document.location.href='<?php echo $FORUM_LOGIN; ?>';</script>
<?php } ?>

