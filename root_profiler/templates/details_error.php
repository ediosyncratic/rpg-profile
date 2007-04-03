<!--
  details_error.tpl

  Error document for changing the user's profile details.
-->
<?php global $messages; ?>

<h1>Error</h1>

<p>
  <?php echo getUserName(); ?>, your profile wasn't updated because one or more errors
  occurred. Note the errors below, then return
  <a href="javascript:history.back(1)">your profile</a>
  and try again after fixing the errors.
</p>
<ul>
<?php foreach( $messages as $msg ) { ?>
  <li><?php echo $msg; ?></li>
<?php } ?>
</ul>
