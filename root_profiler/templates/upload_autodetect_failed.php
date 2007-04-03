<!--
  upload_autodetect_failed.tpl

  Displays a screen saying the autodetect failed, and gives the user
  an option to select the file format.
-->
<?php
global $id, $formats;
?>


<h1>Autodetect Failed</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <p>
    RPGWebProfiler could not determine which type of file you were trying to upload.
    Please select the proper format and try to upload the file again.
  </p>
  <p>
    <input type="hidden" name="MAX_FILE_SIZE" value="5120000" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    Upload File: <input type="file" name="userfile" />
    Using Format: <select name="format" class="quick">
<?php foreach( $formats as $fmt ) { ?>
<option value="<?php echo $fmt['id']; ?>"><?php echo $fmt['title']; ?></option>
<?php } ?>
</select>
    <input type="submit" value="Upload" class="go" />
  </p>
</form>
