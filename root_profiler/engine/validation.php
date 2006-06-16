<?php
  // validation.php

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

  // Contains validation functions used for user input across various
  // scripts.

  if (defined('_VALIDATION_INCLUDED_'))
    return;
  define ('_VALIDATION_INCLUDED_', true, true);

  // Is the supplied profile name ok?
  function is_valid_pname($pname, &$err)
  {
    $size = sizeof($err);

    if (ereg('[^a-zA-Z0-9]', $pname))
      array_push($err, "Your profile name contains invalid (non-alphanumeric) characters.");
    else if (strlen($pname) < 3)
      array_push($err, "Your profile name is too short, it must be at least three characters.");
    else if (strlen($pname) > 20)
      array_push($err, "Your profile name is too long, it can't exceed 20 characters.");

    return sizeof($err) == $size;
  }

  // Is the supplied character name valid?
  function is_valid_cname($name, &$err)
  {
    $size = sizeof($err);

    if (ereg('[^a-zA-Z0-9]', $name))
      array_push($err, "Your character name contains invalid (non-alphanumeric) characters.");
    else if (strlen($name) < 3)
      array_push($err, "Your character name is too short, it must be at least three characters.");
    else if (strlen($name) > 20)
      array_push($err, "Your character name is too long, it can't exceed 20 characters.");

    return sizeof($err) == $size;
  }

  // Is the supplied email address valid?
  function is_valid_email($email, &$err)
  {
    $size = sizeof($err);

    // Just ensure we have an email address.
    if (strlen($email) < 6) // ?@?.??
      array_push($err, "Your email address is invalid.");
    if (strlen($email) > 50)
      array_push($err, "Your email address must be less than 50 characters long.");

    return sizeof($err) == $size;
  }

  // Is the supplied password valid?
  function is_valid_password($pwd, &$err)
  {
    $size = sizeof($err);

    if (ereg('[^a-zA-Z0-9]', $pwd))
      array_push($err, "Your password contains invalid (non-alphanumeric) characters.");
    else if (strlen($pwd) < 3)
      array_push($err, "Your password is too short, it must be at least three characters.");
    else if (strlen($pwd) > 20)
      array_push($err, "Your password is too long, it can't exceed 20 characters.");

    return sizeof($err) == $size;
  }

  // Is the supplied session length ok?
  function is_valid_slength($slength, &$err)
  {
    $size = sizeof($err);

    if (!is_numeric($_POST['slength']))
      array_push($err, "You must supply a numeric session length.");
    else if ($_POST['slength'] < 30)
      array_push($err, "The requested session length is too short.");
    else if ($_POST['slength'] > 480)
      array_push($err, "The requested session length is too long.");

    return sizeof($err) == $size;
  }
?>
