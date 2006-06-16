<?php
  // template.class.php

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

  // Defines the template class that is used to draw all pages from within
  // 3EProfiler (except the character sheet). To modify the appearance of
  // any of the user interface displayed to the client, it would be best
  // to modify the main.tpl template file or any page-specific template
  // file before modifying this class...

  if (defined('_TEMPLATE_INCLUDED_'))
    return;
  define ('_TEMPLATE_INCLUDED_', true, true);

  require('system.php');
  require($SMARTY_PATH);

  class Template extends Smarty
  {
    // The template that will show the body.
    var $m_sBodyTpl = null;

    // An instance of a SId class item, which is used to determine the nav
    // links in the header (logged in or out sets which links are active).
    var $m_sid = null;

    // The constructor.
    function Template()
    {
      // Instantiate the base class.
      $this->Smarty();

      // For compatibility in safe mode.
      $this->use_sub_dirs = false;

      // Instantiate the smarty paths.
      $this->template_dir = dirname(__FILE__) . '/smarty/templates/';
      $this->compile_dir = dirname(__FILE__) . '/smarty/templates_c/';
      $this->config_dir = dirname(__FILE__) . '/smarty/configs/';
      $this->cache_dir = dirname(__FILE__) . '/smarty/cache/';

      // Instantiate variables used in all templates.
      global $URI_BASE, $URI_HOME, $URI_TOS, $URI_WEBMASTER;
      $this->assign('URI_BASE', $URI_BASE);
      $this->assign('URI_HOME', $URI_HOME);
      $this->assign('URI_TOS', $URI_TOS);
      $this->assign('URI_WEBMASTER', $URI_WEBMASTER);
    }

    // Set which page will fill the bulk of the body.
    function SetBodyTemplate($sFile)
    {
      $this->m_sBodyTpl = $sFile;
    }

    // Assign a session object to the template.
    function AssignSession(&$sid)
    {
      $this->m_sid = &$sid;
    }

    // Displays the template.
    function send()
    {
      // Ensure we have a content template.
      if ($this->m_sBodyTpl)
      {
        if (!is_file($this->template_dir . $this->m_sBodyTpl))
          $this->m_sBodyTpl = 'error_nobody.tpl';
      }
      else
        $this->m_sBodyTpl = 'error_nobody.tpl';

      // Set the content template.
      $this->assign('__content_template', $this->m_sBodyTpl);

      // Set the login state and session info.
      if ($this->m_sid)
        if ($this->m_sid->IsSessionValid())
        {
          $this->assign('__is_logged_in',  'true');
          $this->assign('username', htmlspecialchars($this->m_sid->GetUserName()));
          $this->assign('email', htmlspecialchars($this->m_sid->GetEmail()));
          $this->assign('slength', htmlspecialchars($this->m_sid->GetSLength()));
        }

      // Display the template.
      header("Cache-Control: no-store, no-cache, must-revalidate");
      $this->display('main.tpl');
    }
  }
?>
