<?php
  // id.class.php

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
      if (preg_match('/[^a-zA-Z0-9]/', $id))
        return false;

      return true;
    }
  }
?>
