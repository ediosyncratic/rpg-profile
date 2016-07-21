<!--
  del_confirm.tpl

  Defines the template for the character deletion confirmation page.
-->
<?php
global $id, $character;
?>

<h1><?= getUserName(); ?> :: Remove Character</h1>

<h1>Confirmation</h1>
<form action="del.php" method="post">
  <p>
    Are you sure you want to remove your profile's access to the character
    <b><?php echo $character; ?></b> (#<?php echo $id; ?>)? If you are the owner of
    this character, the character data will be permanently deleted.
  </p>
  <p>
    Remove character?
  </p>
  <p>
    <input type="hidden" name="confirm" value="yes" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="submit" class="go" value="Yes" />
    <input type="button" class="go" onclick="location='cview.php'" value="No" />
  </p>
</form>
