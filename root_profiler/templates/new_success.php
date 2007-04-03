<!--
  new_success.tpl

  Generates a message for the user after a character has been created for
  him/her.
-->
<?php global $name, $id; ?>

<h1>Character Created!</h1>
<p>
  <strong><?php echo getUserName(); ?></strong>, the character <strong><?php echo $name; ?></strong> (id = <?php echo $id; ?>)
  was created and your profile was registered as an owner of the character
  sheet.
</p>
<p>
  You can return to your <a href="cview.php">character
  options</a> menu where you can edit this new character sheet, or create
  another character sheet.
</p>
