<?php
  // error.php

  // Defines error functions that are used for quick error reporting
  // and script termination.

  if (defined ('_ERROR_INCLUDED_'))
    return;
  define ('_ERROR_INCLUDED_', true, true);

  require_once('system.php');
  require_once('engine/templates.php');

  $title = '';
  $body = '';

  // __printFatalErr: Generates a quick error page, notifying the user of
  // the error and exits the script. If the global $DEBUG is true, the
  // function will show the exact line and file that called the function,
  // if they are supplied.
  function __printFatalErr($sMsg, $line = null, $file = null)
  {
    global $DEBUG, $title, $body;

    $title = 'RPG Web Profiler Error';
    if ($DEBUG && $line && $file)
      $sMsg .= "\n\nThis error occurred at line $line of file $file.";
    $body = nl2br(htmlspecialchars($sMsg));
    draw_page('error.php');
    exit;
  }

  // __printNotLoggedInErr: Generates an error page, telling the user that
  // the page they requested can only be done if theyre logged in.
  function __printLoginRequiredErr()
  {
    global $title;

    $title = 'RPG Web Profiler Error';
    draw_page('login_required.php');
    exit;
  }

  // General error handler.
  function __on_err ($errtype, $errmsg, $errfile, $errline)
  {
    global $DEBUG, $title, $body;

    switch ($errtype)
    {
    case E_USER_ERROR:
    case E_USER_WARNING:
      $title = 'RPG Web Profiler Error';
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
