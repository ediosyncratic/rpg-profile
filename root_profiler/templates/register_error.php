<!--
  register_error.tpl

  Error document for 3EProfiler registration.
-->
<?php global $messages; ?>

<h1>Error</h1>

<p>
  Your profile could not be created. Note the errors below, then return
  and try to <a href="javascript:history.back(1)">register</a>
  again after fixing the errors.
</p>
<ul>
<?php foreach( $messages as $msg ) { ?>
  <li><?php echo $msg; ?></li>
<?php } ?>
</ul>
