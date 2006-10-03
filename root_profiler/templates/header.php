<?php global $sid, $REQUIRE_LOGIN, $DISPLAY_IMAGES, $DISPLAY_FAQ, $SITE_CSS, $FORUM; ?>

<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="<?php echo $SITE_CSS; ?>" title="Main Stylesheet" />
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=iso-8859-1" />
    <title>RPG Web Profiler :: <?php echo getTitle(); ?></title>
    <?php echo getHead(); ?>
  </head>
  <body>

    <!-- ###### Header ###### -->

    <div id="header">
      <span><a href="<?php echo getUriHome(); ?>">
        <img height="73" src="<?php echo getLogo(); ?>" border="0"></a></span>
      <div class="headerLinks">
	<a href="<?php echo getUriHome(); ?>">Home</a>
        <?php if( $sid && loggedIn() ) { ?>
          <?php if( !$FORUM ) { ?>
          | <a href="<?php echo getUriBase(); ?>logout.php">Logout</a>
          <?php } ?>
          | <a href="<?php echo getUriBase(); ?>cview.php">Characters</a>
          <?php if( $sid->IsDM() ) { ?>
          | <a href="<?php echo getUriBase(); ?>campaigns.php">Campaigns</a>
          <?php } ?>
          | <a href="<?php echo getUriBase(); ?>pview.php">Profile</a>
          <?php if( $DISPLAY_IMAGES ) { ?>
          | <a href="<?php echo getUriBase(); ?>charimg.php">Character Images</a>
          <?php } ?>
          | <a href="<?php echo getUriBase(); ?>search.php">Search</a>
        <?php } else { ?>
          <?php if( !$FORUM ) { ?>
          | <a href="<?php echo getUriBase(); ?>login.php">Login</a>
          <?php } ?>
          <?php if( !$REQUIRE_LOGIN ) { ?>
        	| <a href="<?php echo getUriBase(); ?>search.php">Search</a>
          <?php } ?>
        <?php } ?>
        <?php if( $DISPLAY_FAQ ) { ?>
        | <a href="<?php echo getUriBase(); ?>faq.php">FAQ</a>
        <?php } ?>
      </div>
    </div>

<div id="bodyText">
