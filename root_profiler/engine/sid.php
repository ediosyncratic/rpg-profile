<?php
  // sid.php

  // Helper functions useful when dealing with SId objects.

  if (defined('_SID_INCLUDED_'))
    return;
  define ('_SID_INCLUDED_', true, true);

  require_once('sid.class.php');
  require_once(dirname(__FILE__) . '/../system.php');
  require_once(dirname(__FILE__) . '/../error.php');

  // RespawnSession: returns a reference to the valid session object if
  // the session was successfully respawned. Otherwise, an error is
  // generated and the script terminates.
  function & RespawnSession($line = null, $file = null)
  {
    global $FORUM;

    // Ensure session info was passed to the script.
    if (!isset($_COOKIE['sid']) && ! $FORUM) {
      __printLoginRequiredErr();
    }

    // Attempt to respawn the session.
    $sid = new SId();
    if (!$sid->IsSessionValid())
      __printLoginRequiredErr();
      //__printFatalErr("Failed to respawn user session.", $line, $file);

    return $sid;
  }
?>
