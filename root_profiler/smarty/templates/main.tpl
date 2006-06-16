{*
  main.tpl

  3EProfiler (tm) template file.
  Copyright (C) 2003 Michael J. Eggertson.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  **

  Defines the main template that every page (except the character sheets)
  use. Changing this template or the linked css file is a good way to
  change the global appearance of 3EProfiler without changing template
  files for specific situations.
*}
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="css/template.css" title="Main Stylesheet" />
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=iso-8859-1" />
    <title>Sylnae's :: {$title}</title>
    {$head}
  </head>
  <body>

    <!-- ###### Header ###### -->

    <div id="header">
      <span><a href="{$URI_HOME}">
<img src="/3eprofiler/imgs/sylnae.gif" width="178" height="73" border="0"></a></span>
<img src="/3eprofiler/imgs/3eprofiler.gif" width="240" height="73" border="0">
      <div class="headerLinks">
	<a href="{$URI_BASE}index.php">Home</a>
          | <a href="{$URI_BASE}../forums/">Forums</a>
        {if $__is_logged_in}
          | <a href="{$URI_BASE}logout.php">Logout</a>
          | <a href="{$URI_BASE}cview.php">Characters</a>
          | <a href="{$URI_BASE}pview.php">Profile</a>
	  | <a href="{$URI_BASE}charimg.php">Character Images</a>
        {else}
          | <a href="{$URI_BASE}login.php">Login</a>
        {/if}
        | <a href="{$URI_BASE}search.php">Search</a>
        | <a href="{$URI_BASE}faq.php">FAQ</a>
      </div>
    </div>

    <!-- ###### Body ###### -->

    <div id="bodyText">
      {include file=$__content_template}
    </div>

    <!-- ###### Footer ###### -->

    <div>

      {*
        You should leave the copyright notice alone, or at the
        make sure it persists somewhere if you modify the template.
      *}

      <div id="footer">
        <div>
	  Powered by Camberra v0.1 &copy; 2005-2006<br />
          Based on <a href="http://www.3eprofiler.net">3EProfiler&trade;</a> v3.0.1 &copy; 2001-2004<br />
          <a href="{$URI_TOS}">Privacy Policy and Terms of Use</a> Information<br />
	  Host by <a href="http://www.jatol.com">Jatol Internet Services, Inc</a>
        </div>
      </div>
    </div>
  </body>
</html>
