<?php
  // faq.php

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

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.class.php");
  include_once("$INCLUDE_PATH/template.class.php");

  // Try to respawn a session, only for the sake of the main nav bar
  // showing the proper buttons.
  $sid = new SId();
  $T = new Template();
  $T->assign('title', 'Camberra :: Frequently Asked Questions');
  if ($sid->IsSessionValid())
    $T->AssignSession($sid);
  $T->SetBodyTemplate('faq.tpl');
  $T->send();
?>