<?php
  /**
   * Provides authentication for the RPG Web Profiler system using the
   * phpBB2
   */
  global $FORUM_ROOT, $DB;

  // PhpBB variables need a global scope
  global $phpbb_root_path;
  global $phpEx;
  global $starttime;
  
  global $db;

  global $board_config;
  global $userdata;
  global $theme;
  global $images;
  global $lang;
  global $nav_links;
  global $gen_simple_header;

  define('IN_PHPBB', true);
  $phpbb_root_path = $FORUM_ROOT;
  include($FORUM_ROOT . 'extension.inc');
  include($FORUM_ROOT . 'common.'.$phpEx);

  //
  // Start session management
  //
  $userdata = session_pagestart($user_ip, PAGE_INDEX);
  init_userprefs($userdata);
  //
  // End session management
  //

  // Authenticate the user and set appropriate values in the SID class.
  function authenticate(&$sid) {

    global $userdata, $TABLE_USERS, $rpgDB;
    
    if( ! $userdata['session_logged_in'] ) {
      return false;
    }
    $sid->_sid = $userdata['session_id'];
    $sid->_username = $userdata['username'];
    $sid->_email = $userdata['user_email'];
    $sid->_ip = $userdata['session_ip'];

    // Attempt to retrieve the user session details from the db.
    $sql = sprintf("SELECT iplog, slength, dm FROM %s WHERE pname = '%s'",
        $TABLE_USERS, $sid->_username);
    $res = $rpgDB->query($sql);
    if (!$res) {
      $err = $rpgDB->error();
      __printFatalErr("Failed to query database: " . $err['message'] . "\n" . $sql, __LINE__, __FILE__);
    }
    if ($rpgDB->num_rows() == 1) {
      // Record the user data.
      $row = $rpgDB->fetch_row($res);
      $sid->_iplog = unserialize(stripslashes($row['iplog']));
      $sid->_slength = $row['slength'];
      $sid->_dm = $row['dm'] == 'Y';
    } else {
      create_user($userdata['username']);

      $sid->_iplog = "";
      $sid->_slength = 180;
      $sid->_dm = false;
    }
    
    return true;
  }

  function create_user($username) {

    global $TABLE_USERS, $rpgDB;

    $sql = sprintf("INSERT INTO %s (pname, slength, dm) VALUES ('%s', %d, 'N')", $TABLE_USERS,
                    $username, 180);
    $res = $rpgDB->query($sql);

    if( !$res ) {
      __printFatalErr("Unable to create new user profile: " . $username . '\n' . $rpgDB->error());
    }

  }

?>

