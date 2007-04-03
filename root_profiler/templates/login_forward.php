<!--
  login_forward.tpl

  Defines the page body that is displayed when a user who is already
  logged in goes to the login page.
-->
<h1>Welcome Back!</h1>
<p>
  Welcome back, <?php echo getUserName(); ?>. You are still logged in from your previous visit.
  Continue to your <a href="cview.php">character</a> or
  <a href="pview.php">profile</a> management pages.
</p>
<?php
global $FORUM, $SITE_NEWS, $INCLUDE_PATH, $DISPLAY_STATS;
if( !$FORUM ) {
?>
<p>
  If you are not <?php echo getUserName(); ?>, please
  <a href="logout.php">logout</a>, then login with your own
  profile, or register a new profile if you're a new visitor.
</p>
<?php } ?>

<?php
$newsFile = $INCLUDE_PATH . '/templates/' . $SITE_NEWS;

if( $SITE_NEWS && file_exists($newsFile) ) {
  include_once($newsFile);
}
?>
<?php if( $DISPLAY_STATS ) { ?>
      <p class="smaller">
        Registered Users: <?php echo GetUserCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Registered Characters: <?php echo GetCharacterCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Online Users: <?php echo GetUsersOnlineCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        Public Characters: <?php echo GetPublicCount(); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="stats.php">More Stats</a>
      </p>
<?php } ?>
