<?php
  // db.php

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

  // Opens a connection to the 3EProfiler database.

  if (defined('_DB_INCLUDED_'))
    return;
  define ('_DB_INCLUDED_', true, true);

  require_once(dirname(__FILE__) . '/../system.php');
  require_once(dirname(__FILE__) . '/../error.php');

  @ mysql_connect($DB_HOST, $DB_USER, $DB_PWD) or
    __printFatalErr(mysql_error().'Database Connection Failed.', __LINE__, __FILE__);
  @ mysql_select_db($DB) or
    __printFatalErr(mysql_error().'Failed to find database.', __LINE__, __FILE__);
?>
