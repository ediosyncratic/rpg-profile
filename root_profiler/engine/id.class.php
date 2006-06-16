<?php
  // id.class.php

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

  // The id class is used to generate variable length string ids.

  if (defined('_ID_CLASS_INCLUDED_'))
    return;
  define ('_ID_CLASS_INCLUDED_', true, true);

  class Id
  {
    // Constructor: use to initialize the random number generator.
    function Id()
    {
      mt_srand((float) microtime() * 1000000);
      // Discard the first 100 numbers.
      for ($i = 0; $i < 100; $i++)
        mt_rand();
    }

    // GenerateId: generate a new id of specified length.
    function GenerateId($nWidth = 32)
    {
      $ca = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $id = '';
      for ($i = 0; $i < $nWidth; $i++)
        $id .= $ca{mt_rand(0, strlen($ca) - 1)};
      return $id;
    }

    // ValidateId: ensure that the id is legal, return true if valid.
    function ValidateId($id)
    {
      // Enforce a mininum session length
      if (strlen($id) < 10)
        return false;

      // Check for illegal characters
      if (ereg('[^a-zA-Z0-9]', $id))
        return false;

      return true;
    }
  }
?>
