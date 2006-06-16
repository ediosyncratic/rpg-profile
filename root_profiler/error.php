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
  require('template.class.php');

  // __printFatalErr: Generates a quick error page, notifying the user of
  // the error and exits the script. If the global $DEBUG is true, the
  // function will show the exact line and file that called the function,
  // if they are supplied.
  function __printFatalErr($sMsg, $line = null, $file = null)
  {
    global $DEBUG;
    $T = new Template();
    $T->SetBodyTemplate('error.tpl');
    $T->assign('title', '3EProfiler Error');
    if ($DEBUG && $line && $file)
      $sMsg .= "\n\nThis error occurred at line $line of file $file.";
    $T->assign('body', nl2br(htmlspecialchars($sMsg)));
    $T->send();
    exit;
  }

  // __printNotLoggedInErr: Generates an error page, telling the user that
  // the page they requested can only be done if they're logged in.
  function __printLoginRequiredErr()
  {
    $T = new Template();
    $T->assign('title', '3EProfiler Error');
    $T->SetBodyTemplate('login_required.tpl');
    $T->send();
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
      $tpl = new Template();
      $tpl->SetBodyTemplate('error.tpl');
      $tpl->assign('title', '3EProfiler Error');
      if ($DEBUG)
        $errmsg .= "\n\nThis error occurred at line $errline of file $errfile.";
      $tpl->assign('body', nl2br(htmlspecialchars($errmsg)));
      $tpl->send();
      exit;
      break;
    case E_USER_NOTICE:
    default:
      // Smarty can generate alot of NOTICE errors, so we ignore them.
    }
  }
  set_error_handler("__on_err");
?>
