<!--
  del.php

  Defines the template shown after a character has been removed from a
  user profile.
-->
<?php
global $character, $id, $removed;
?>

<h1><?php echo getUserName(); ?> :: Remove Character</h1>

<p>
  The character, <b><?php echo $character; ?></b> (id = <?php echo $id; ?>), was removed from your profile.
</p>
<?php if( $removed ) { ?>
<p>
  Since you were the owner of the character,
  <b><?php echo $character; ?></b> was permanently deleted.
</p>
<?php } else { ?>
<p>
  Your permission to edit <b><?php echo $character; ?></b> was removed.
</p>
<?php } ?>
<p>
  <a href="cview.php">Return to my profile.</a>
</p>
