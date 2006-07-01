<?php
  // char.php

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

  // Defines the character permissions page and also implements some
  // basic permission methods.

  include_once("config.php");
  include_once("$INCLUDE_PATH/system.php");
  include_once("$INCLUDE_PATH/error.php");
  include_once("$INCLUDE_PATH/engine/sid.php");
  include_once("$INCLUDE_PATH/engine/validation.php");
  include_once("$INCLUDE_PATH/engine/character.class.php");
  include_once("$INCLUDE_PATH/engine/templates.php");
  include_once("$INCLUDE_PATH/engine/serialization.php");

  $sid = RespawnSession(__LINE__, __FILE__);

  // Validate permission for the requested character.
  $id = (int) $_POST['id'];

  if (!$id) {
    $id = (int) $_GET['id'];
  }

  if (!$sid->HasAccessTo($id))
    __printFatalErr("Access denied.");

  // Get character details.
  $character = new Character($id);
  if (!$character->IsValid())
    __printFatalErr("Failed to retrieve character data.", __LINE__, __FILE__);

  // Perform any simple actions that are requested.
  if (isset($_POST['public']))
    $public_updated =  apply_public($sid, $character, $_POST['public'] == 'true') ? 'Updated!' : 'Update Failed!';
  if (isset($_POST['add_profile']))
    $profiles_updated = apply_add_profile($character, $_POST['add_profile']) ? 'Updated!' : 'Update Failed!';
  if (isset($_POST['tid']))
    $template_updated = apply_template($sid, $character, (int) $_POST['tid']) ? 'Updated!' : 'Update Failed!';
  if (isset($_GET['remove_profile']))
    $profiles_updated = apply_remove_profile($character, $_GET['remove_profile']) ? 'Updated!' : 'Update Failed!';

  // Draw the page.
  $title = 'Character Permissions';

  $cname = $character->cname;
  $is_public = $character->public == 'y';
  $is_owner = $character->owner == $sid->GetUserName();
  $profiles = $character->GetProfiles();
  $templates = generate_template_array();
  $current_template = get_sheet_name($character->template_id);
  $exp_formats = get_export_scripts();
  $imp_formats = get_import_scripts();
  draw_page('char.php');

  ////////////////////////////////////////////////////////////////////////
  // Helper functions.

  // Grant a new profile permission to the character.
  function apply_add_profile(&$character, $profile)
  {
    $err = array();
    if (is_valid_pname($profile, $err))
      if ($character->GrantAccessTo($profile))
        return true;
    return false;
  }
 
  function apply_remove_profile(&$character, $profile)
  {
    $err = array();
    if (is_valid_pname($profile, $err))
      if( $character->RemoveAccessFrom($profile))
        return true;
    return false;
  }

  // Apply the public state
  function apply_public(&$sid, &$character, $public)
  {
    $character->public = $public ? 'y' : 'n';
    return $character->Save($sid);
  }

  // Apply the template change.
  function apply_template(&$sid, &$character, $template_id)
  {
    if (is_valid_template_id($template_id))
    {
      $character->template_id = $template_id;
      if ($character->Save($sid))
        return true;
    }
    return false;
  }
?>
