<?php
  // sid.php

  // 3EProfiler (tm) source file.
  // Copyright (C) 2003 Michael J. Eggertson.

  // This program is free software; you can redistribute it and/or modify
  // it under the terms of the GNU General Public License as published by
  // the Free Software Foundation; either version 2 of the License, or
  // (at your option) any later version.

  // This program is distributed in the hope that it will be useful,
  // but WITHOUT ANY WARRANTY; without even the implied warranty of
  // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  // GNU General Public License for more details.

  // You should have received a copy of the GNU General Public License
  // along with this program; if not, write to the Free Software
  // Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  // **

  // Helper functions useful when dealing with SId objects.

  if (defined('_SID_INCLUDED_'))
    return;
  define ('_SID_INCLUDED_', true, true);

  require('sid.class.php');
  require(dirname(__FILE__) . '/../error.php');

  // RespawnSession: returns a reference to the valid session object if
  // the session was successfully respawned. Otherwise, an error is
  // generated and the script terminates.
  function & RespawnSession($line = null, $file = null)
  {
    // Ensure session info was passed to the script.
    if (!isset($_COOKIE['sid']))
      __printLoginRequiredErr();

    // Attempt to respawn the session.
    $sid = new SId();
    if (!$sid->IsSessionValid())
      __printLoginRequiredErr();
      //__printFatalErr("Failed to respawn user session.", $line, $file);

    return $sid;
  }
?>
