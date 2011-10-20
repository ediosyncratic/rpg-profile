<?php
  /**
   * Provides authentication for the RPG Web Profiler system using the
   * phpBB2
   */
  global $FORUM_ROOT, $db, $cache, $phpbb_root_path, $template, $user, $auth, $config, $phpEx;

  // The default phpBB inclusion protection - required
  define('IN_PHPBB', true);
  $phpbb_root_path = $FORUM_ROOT;
  $phpEx = substr(strrchr(__FILE__, '.'), 1);

  include($phpbb_root_path . 'common.' . $phpEx);

  //
  // Start session management
  //
  $user->session_begin();
  $auth->acl($user->data);
  $user->setup();

  //
  // End session management
  //

  // Authenticate the user and set appropriate values in the SID class.
  function authenticate(&$sid) {
    global $user, $TABLE_USERS, $rpgDB;

    if( ! $user->data['is_registered'] ) {
      return false;
    }
    $sid->_sid = $user->session_id;
    $sid->_username = $user->data['username'];
    $sid->_email = $user->data['user_email'];
    $sid->_ip = $user->ip;

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
      create_user($user->data['username']);

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
