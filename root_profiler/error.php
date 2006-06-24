<?php
  // error.php

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

  // Defines error functions that are used for quick error reporting
  // and script termination.

  if (defined ('_ERROR_INCLUDED_'))
    return;
  define ('_ERROR_INCLUDED_', true, true);

  require('system.php');
  require('engine/templates.php');

  // __printFatalErr: Generates a quick error page, notifying the user of
  // the error and exits the script. If the global $DEBUG is true, the
  // function will show the exact line and file that called the function,
  // if they are supplied.
  function __printFatalErr($sMsg, $line = null, $file = null)
  {
    global $DEBUG;
    $title = 'RPG Web Profiler Error';
    if ($DEBUG && $line && $file)
      $sMsg .= "\n\nThis error occurred at line $line of file $file.";
    $body = nl2br(htmlspecialchars($sMsg));
    draw_page('error.php');
    exit;
  }

  // __printNotLoggedInErr: Generates an error page, telling the user that
  // the page they requested can only be done if they're logged in.
  function __printLoginRequiredErr()
  {
    $title = 'RPG Web Profiler Error';
    draw_page('login_required.php');
    exit;
  }

  // General error handler.
  function __on_err ($errtype, $errmsg, $errfile, $errline)
  {
    global $DEBUG;

    switch ($errtype)
    {
    case E_USER_ERROR:
    case E_USER_WARNING:
      $title = '3EProfiler Error';
      if ($DEBUG)
        $errmsg .= "\n\nThis error occurred at line $errline of file $errfile.";
      $body = nl2br(htmlspecialchars($errmsg));
      draw_page('error.php');
      exit;
      break;
    case E_USER_NOTICE:
    default:
      // Smarty can generate alot of NOTICE errors, so we ignore them.
    }
  }
  set_error_handler("__on_err");
?>
