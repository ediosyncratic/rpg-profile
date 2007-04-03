<!--
  resetpwd.php


  Entry point form for the password reset process: the user is asked for
  their profile name.
-->

<h1>Reset Password</h1>
<form action="resetpwd.php" method="get">
  <p>
    Your password can't be retrieved, but it can be reset. To reset your password, enter your profile name below and submit your request. An email will be sent to the address kept in your profile. In the message will be a link that you can visit that will allow you to re-enter a new password.
  </p>
  <p>
    If you did not have a valid email address stored in your profile, your password can not be reset since there is no way to verify your identity.
  </p>
  <p>
    Enter your profile name: <input type="text" name="p" maxlength="20" class="quick" />&nbsp;&nbsp;<input type="submit" class="go" value="Reset my password" />
  </p>
</form>
