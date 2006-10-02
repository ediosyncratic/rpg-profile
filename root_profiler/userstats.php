<?php
  // user_stats.php

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
  
  // Contains functions for getting user stats, like the number of
  // registered users.

  if (defined('_USER_STATS_INCLUDED_'))
    return;
  define ('_USER_STATS_INCLUDED_', true, true);

  require_once('engine/db.php');

  // GetUserCount
  // Returns the number of registered profiles.
  function GetUserCount()  {
    global $TABLE_USERS, $rpgDB;
    $_r = $rpgDB->query("SELECT COUNT(pname) AS cnt FROM $TABLE_USERS");
    if ($_r) {
     $row = $rpgDB->fetch_row($_r);
     return $row['cnt'];
    }
    else
      return '?';
  }
  
  // GetCharacterCount
  // Returns the number of registered characters.
  function GetCharacterCount() {
    global $TABLE_CHARS, $rpgDB;
    $_r = $rpgDB->query("SELECT COUNT(cname) AS cnt FROM $TABLE_CHARS");
    if ($_r) {
      $row = $rpgDB->fetch_row($_r);
      return $row['cnt'];
    }
    else
      return '?';
  }
  
  // GetUsersOnlineCount
  // Returns the number of users who've accessed their accounts recently.
  function GetUsersOnlineCount() {
    global $TABLE_USERS, $rpgDB;
    $_r = $rpgDB->query("SELECT COUNT(pname) AS cnt FROM $TABLE_USERS WHERE UNIX_TIMESTAMP(lastlogin) + (slength * 60) > UNIX_TIMESTAMP(NOW())");
    if ($_r) {
      $row = $rpgDB->fetch_row($_r);
      return $row['cnt'];
    }
    else
      return '?';
  }

  // GetPublicCount
  // Returns the number of public characters.
  function GetPublicCount() {
    global $TABLE_CHARS, $rpgDB;
    $_r = $rpgDB->query("SELECT COUNT(cname) AS cnt FROM $TABLE_CHARS WHERE public = 'y'");
    if ($_r) {
      $row = $rpgDB->fetch_row($_r);
      return $row['cnt'];
    }
    else
      return '?';
  }
?>
