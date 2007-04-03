<?php
  // user_stats.php

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
