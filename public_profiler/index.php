<?php
  // index.php

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

  // Defines the entry point for users of 3EProfiler. This file
  // generates a login screen if the user is not logged in, or an
  // info screen if the user is already logged in.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/template.class.php");
  include_once("$INCLUDE_PATH/userstats.php");

  $sid = new SId();
  if ($sid->IsSessionValid())
  {
    $T = new Template();
    $T->assign('title', 'Index - News');
    $T->assign('count_users', GetUserCount());
    $T->assign('count_characters', GetCharacterCount());
    $T->assign('count_online', GetUsersOnlineCount());
    $T->assign('count_public', GetPublicCount());
    $T->SetBodyTemplate('login_forward.tpl');
    $T->AssignSession($sid);
    $T->send();
  }
  else
  {
    $T = new Template();
    $T->assign('title', 'Index - News');
    $T->assign('count_users', GetUserCount());
    $T->assign('count_characters', GetCharacterCount());
    $T->assign('count_online', GetUsersOnlineCount());
    $T->assign('count_public', GetPublicCount());
    $T->SetBodyTemplate('index.tpl');
    $T->send();
  }

//    $T = new Template();
//    $T->assign('title', '3EProfiler :: Index - News');
//    $T->SetBodyTemplate('index.tpl');
//    $T->send();
?>
