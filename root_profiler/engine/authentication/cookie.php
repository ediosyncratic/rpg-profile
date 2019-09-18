<?php

  if (defined('_COOKIE_CLASS_INCLUDED_'))
    return;
  define('_COOKIE_CLASS_INCLUDED_', true, true);

  require_once(dirname(__FILE__) . '/../id.class.php');
  require_once(dirname(__FILE__) . '/../db.php');
  require_once(dirname(__FILE__) . '/../validation.php');
  require_once(dirname(__FILE__) . '/../charpermission.class.php');
  require_once(dirname(__FILE__) . '/../../system.php');

  function authenticate(&$sid) {
    global $TABLE_USERS, $rpgDB;

    // Record the session id.
    if (!isset($_COOKIE['sid']))
      return;
    $sid->_sid = $_COOKIE['sid'];

    // Ensure a valid sid.
    if (!$sid->ValidateId($sid->_sid))
      return false;

    // Attempt to retrieve the session details from the db.
    $sql = sprintf("SELECT pname, iplog, slength, email, dm FROM %s WHERE UNIX_TIMESTAMP(lastlogin) + (slength * 60) > UNIX_TIMESTAMP(LOCALTIMESTAMP) AND ip = %s AND sid = %s",
        $TABLE_USERS,
        $rpgDB->quote($sid->_ip),
        $rpgDB->quote($sid->_sid));
//__printFatalErr($sql);
    $res = $rpgDB->query($sql);
    if (!$res)
      __printFatalErr("Failed to query database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows($res) != 1)
      return false;

    // Record the user data.
    $row = $rpgDB->fetch_row($res);
    $sid->_username = $row['pname'];
    $sid->_iplog = unserialize(stripslashes($row['iplog']));
    $sid->_slength = $row['slength'];
    $sid->_email = $row['email'];
    $sid->_dm = $row['dm'] == 'Y';

    // Update the iplog.
    $sid->update_iplog();

    // Update the db.
    $res = $rpgDB->query(sprintf("UPDATE %s SET iplog = %s, ip = %s WHERE pname = %s",
      $TABLE_USERS,
      $rpgDB->quote(serialize($sid->_iplog)),
      $rpgDB->quote($sid->_ip),
      $rpgDB->quote($sid->_username)));
    if (!$res)
      __printFatalErr("Failed to update database.", __LINE__, __FILE__);
    if ($rpgDB->num_rows() != 1)
      __printFatalErr("Failed to update user data.", __LINE__, __FILE__);


    return true;
  }

?>
