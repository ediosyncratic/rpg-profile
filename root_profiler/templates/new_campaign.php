<?php global $name, $id, $success; ?>

<?php if( $success ) { ?>
<h1>Character Created!</h1>
<p>
  <strong><?php echo getUserName(); ?></strong>, the campaign <strong><?php echo $name; ?></strong> (id = <?php echo $id; ?>)
  was created and your profile was registered as owner of the campaign.
</p>
<p>
  Return to your <a href="campaigns.php">campaign options</a> menu to edit this campaign, or create another.
</p>
<?php } else { ?>
<h1>Error!</h1>
<p>
  Your campaign could not be created because the name is invalid.
  Campaign names must be alphanumeric: they can only contain the letters
  a-z, A-Z, and the numbers 0-9. A valid name is at least three characters
  long.
</p>
<p>
  Click your browser's <a href="javascript:history.back(1);">back</a>
  button to return to your campaign options menu.
</p>
<?php } ?>
