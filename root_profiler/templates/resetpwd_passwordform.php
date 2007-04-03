<!--
  resetpwd_passwordform.tpl

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
