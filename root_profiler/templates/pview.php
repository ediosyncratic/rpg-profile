<!--
  pview.tpl

  Defines the template for the profile options menu.
-->
<?php global $sid, $FORUM; ?>


<h1><?php echo getUserName(); ?> :: Profile Options</h1>

<h1>Login Details</h1>
<form action="details.php" method="post">
<?php if( !$FORUM ) { ?>
  <p>
    You can change any of the details associated with your profile. Leave
    the password fields blank if you do not wish to change your password.
  </p>
  <p>
    Your session length is the amount of time, in minutes, that it takes for
    your login to expire. If your login remains inactive for this period of
    time, your session will be closed and you will need to login again. Your
    session length must be between 30 and 480 minutes. Note that regardless
    of what your session length, it will expire when you exit your internet
    browser.
  </p>
  <div class="inputholder"><input type="password" class="quick" name="pwd1" /> Enter new password (leave blank if no change).</div>
  <div class="inputholder"><input type="password" class="quick" name="pwd2" /> Verify new password.</div>
  <div class="inputholder"><input type="text" class="quick" name="email" value="<?php echo $sid->GetEmail(); ?>" /> Email address.</div>
  <div class="inputholder"><input type="text" class="quick" name="slength" value="<?php echo $sid->GetSLength(); ?>" /> Session length, in minutes.</div>
<?php } else { ?>
  <p>
    To enable DM functionality, tick the box below. To change your password,
    or email address, please use the forums account management facilities.
  </p>
<?php } ?>
  <div class="inputholder"><input type="checkbox" class="quick" name="dm" <?php if( $sid->IsDM() ) { ?>checked<?php } ?>/>Enable DM Functions</div>
  <p>
    <input type="submit" class="go" value="Update Profile" />
  </p>
</form>
