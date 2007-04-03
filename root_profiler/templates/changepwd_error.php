<!--
  changepwd_error.php

  Error document for changing the user's profile details.
-->
<?php global $messages; ?>


<h1>Error</h1>

<p>
  Your password wasn't updated because one or more errors occurred. Note the errors below, then return to the <a href="javascript:history.back(1)">previous screen</a> and attempt to fix them. If you get a message saying that your key is no longer valid, that is because you (or someone) has since logged into your profile since your email containing your key was sent out. If this happens, you will need to <a href="resetpwd.php">reset</a> your password again.
</p>
<ul>
<?php foreach( $messages as $msg ) { ?>
  <li><?php echo $msg; ?></li>
<?php } ?>
</ul>
