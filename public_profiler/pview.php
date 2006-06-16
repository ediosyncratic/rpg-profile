<?php
  // pview.php

  // 3EProfiler (tm) source file for the profile view.
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

  // Shows the user's profile options.

  include_once("config.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/template.class.php");

  // Respawn the user session.
  $sid = RespawnSession(__LINE__, __FILE__);

  // Draw the profile options.
  $T = new Template();
  $T->assign('title', 'Profile Options');
  $T->SetBodyTemplate('pview.tpl');
  $T->AssignSession($sid);
  $T->send();
?>
