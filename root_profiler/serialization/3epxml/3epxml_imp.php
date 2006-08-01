<?php
  // 3epxml_imp.php

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

  if (defined('_3EPXML_IMP_INCLUDED_'))
    return;
  define ('_3EPXML_IMP_INCLUDED_', true, true);

  require_once(dirname(__FILE__) . '/../../engine/templates.php');
  require_once(dirname(__FILE__) . '/../../engine/character.class.php');

  // This is a *really* basic parser object. It's included directly in this
  // file because it really isn't meant to be reused since it's specific to
  // this file format.
  class simple_parser
  {
    // An array of node objects, where each element is a child of the
    // previous element. Elements are pushed and popped from the array
    // in the various handlers to keep track of where in the document
    // we are while parsing.
    var $current_node = array();

    var $public;
    var $template;
    var $data = array();

    function & Parse(&$xmlstring)
    {
      $xmlp = xml_parser_create();
      xml_parser_set_option($xmlp, XML_OPTION_CASE_FOLDING, 0);
      xml_set_object($xmlp, &$this);
      xml_set_element_handler($xmlp, "start_tag", "close_tag");
      xml_set_character_data_handler($xmlp, "handle_cdata");
      $success = xml_parse($xmlp, $xmlstring, true);
      xml_parser_free($xmlp);
      return $success;
    }

    function start_tag($res, $tagname, $tagattribs)
    {
      array_push($this->current_node, array('attribs' => $tagattribs, 'value' => ''));
    }

    function close_tag($res, $tagname)
    {
      $node = array_pop($this->current_node);
      switch ($tagname)
      {
        case 'public':
          $this->public = $node['value'];
          break;
        case 'template':
          $this->template = $node['value'];
          break;
        case 'node':
          $this->data[$node['attribs']['name']] = $node['value'];
          break;
      }
    }

    function handle_cdata($res, $cdata)
    {
      $this->current_node[sizeof($this->current_node) - 1]['value'] .= $cdata;
    }
  }

  function import_character(&$filedata, &$char)
  {
    $parser = new simple_parser();
    if (!$parser->Parse($filedata))
      return false;
    $char->public = $parser->public == 'y' ? 'y' : 'n';
    $char->template_id = get_sheet_id($parser->template);
    $char->SetData($parser->data);
    return true;
  }
?>
