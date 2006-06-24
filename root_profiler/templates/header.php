<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="css/template.css" title="Main Stylesheet" />
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=iso-8859-1" />
    <title>RPG Web Profiler :: <?php echo getTitle(); ?></title>
    <?php echo getHead(); ?>
  </head>
  <body>

    <!-- ###### Header ###### -->

    <div id="header">
      <span><a href="<?php echo getUriHome(); ?>">
<img src="<?php echo getLogo(); ?>" border="0"></a></span>
      <div class="headerLinks">
	<a href="<?php echo getUriBase(); ?>index.php">Home</a>
        <?php if( loggedIn() ) { ?>
          | <a href="<?php echo getUriBase(); ?>logout.php">Logout</a>
          | <a href="<?php echo getUriBase(); ?>cview.php">Characters</a>
          | <a href="<?php echo getUriBase(); ?>pview.php">Profile</a>
	  | <a href="<?php echo getUriBase(); ?>charimg.php">Character Images</a>
        <?php } else { ?>
          | <a href="<?php echo getUriBase(); ?>login.php">Login</a>
        <?php } ?>
        | <a href="<?php echo getUriBase(); ?>search.php">Search</a>
        | <a href="<?php echo getUriBase(); ?>faq.php">FAQ</a>
      </div>
    </div>

<div id="bodyText">
