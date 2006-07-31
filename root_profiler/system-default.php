<?php
  // system.php

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

  // Defines various system globals that are needed by most files used by
  // 3EProfiler. You will need to modify these globals to be consistent
  // with your database and file system.

  // Standard include guard (DO NOT MODIFY).
  if (defined('_SYSTEM_INCLUDED_'))
    return;
  define ('_SYSTEM_INCLUDED_', true, true);


  // The Base installation directory (containing the root_profiler directory).
  $BASE_INSTALL = '/home/username/profiler';

  // The base directory of the public files. You will only need to change this
  // value if the root_profiler and public_profiler directories are not in
  // the same place.
  //
  // NOTE: THIS IS NOT THE WEBSITE ADDRESS, THIS IS THE LOCATION OF THE 
  //       WEB-ACCESSIBLE FILES IN THE LOCAL FILE SYSTEM.
  $WEB_INSTALL = $BASE_INSTALL . '/public_profiler';

  // Site CSS File
  $SITE_CSS = 'css/template.css';

  // Site News File
  // - If you dont want a news section, just comment this out.
  // - If you use your own file, the default file is located in the
  //   root_profiler/templates/ directory.
  $SITE_NEWS = 'news.php';

  ////////////////////////////////////////////////////////////////////////
  // MySQL Database configuration.

  // These parameters will need to be changed to allow 3EProfiler to
  // connect to your MySQL database.

  $DB_HOST = 'localhost';
  $DB_USER = 'db_username';
  $DB_PWD = 'db_password';
  $DB = 'db_name';

  // The $TABLE parameters will only need to be changed if you modify the
  // default table structure 3EProfiler uses.

  $TABLE_USERS = 'profiles';
  $TABLE_CHARS = 'characters';
  $TABLE_OWNERS = 'character_owners';
  $TABLE_TEMPLATES = 'sheet_templates';
  $TABLE_SERIALIZE = 'serialization_formats';
  $TABLE_CAMPAIGNS = 'campaign';
  $TABLE_CAMPAIGN_REQUESTS = 'campaign_join';

  ////////////////////////////////////////////////////////////////////////
  // Site parameters.

  // Change URI_BASE to the base uri that all pages are displayed from.
  $URI_BASE = 'http://www.mydomain.ext/profiler/';

  // URI_HOME: the resource (front-page) for your site.
  $URI_HOME = $URI_BASE;

  // URI_WEBMASTER: the resource to contact the webmaster.
  // If using an email address, you may wish to obfuscate it so it doesn't
  // get harvested by web bots.
  $URI_WEBMASTER = 'mailto:email&#64;mydomain.ext';

  // EMAIL_WEBMASTER: the email address of the webmaster.
  // This address is used for outgoing emails, so shouldn't be obfuscated.
  $EMAIL_WEBMASTER = 'email@mydomain.ext';

  // URI_TOS: your site's terms of service and privacy policy.
  $URI_TOS = 'legal.php';

  // LOGO: The image that appears at the top left of the page.
  // Note: The image should be 73 pixels in height
  $LOGO = 'imgs/rpgwebprofiler.gif';

  // Open character sheets in a new window
  $NEW_WINDOW = true;

  // Require Login to view any characters (including public)
  $REQUIRE_LOGIN = false;

  // Allow anyone to register on the profiler
  $OPEN_REGISTRATION = true;

  // Display Character Image page
  $DISPLAY_IMAGES = true;

  // Display FAQ Link
  $DISPLAY_FAQ = true;

  ////////////////////////////////////////////////////////////////////////
  // Behavior parameters.

  // If debug is true, error messages will usually display the exact line
  // and filename that raised the error, and validation links will appear
  // on most output pages.
  $DEBUG = true;
?>
