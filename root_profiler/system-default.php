<?php
  // system.php

  // Defines various system globals that are needed by most files used by
  // 3EProfiler. You will need to modify these globals to be consistent
  // with your database and file system.

  // Standard include guard (DO NOT MODIFY).
  if (defined('_SYSTEM_INCLUDED_'))
    return;
  define ('_SYSTEM_INCLUDED_', true, true);


  // *********************************************************************
  // REQUIRED SITE PARAMETERS
  // ------------------------
  // You will need to change the parameters below to match the
  // configuration for your installation.
  // *********************************************************************

  // --------------------------------------------------------------------
  // MySQL Database configuration
  // --------------------------------------------------------------------

  // Database Host - Usually localhost
  $DB_HOST = 'localhost';

  // Database Username - The username used to connect to the database
  $DB_USER = 'db_username';

  // Database Password - The password used to connect to the database
  $DB_PWD = 'db_password';

  // Database Name - The name of the database
  $DB = 'db_name';

  // Change URI_BASE to the base uri that all pages are displayed from.
  $URI_BASE = 'http://www.mydomain.ext/profiler/';

  // --------------------------------------------------------------------
  // Web Configuration
  // --------------------------------------------------------------------

  // URI_WEBMASTER: the resource to contact the webmaster.
  // If using an email address, you may wish to obfuscate it so it doesnt
  // get harvested by web bots. Alternatively you could use a 'contact us'
  // web page.
  $URI_WEBMASTER = 'mailto:email&#64;mydomain.ext';

  // EMAIL_WEBMASTER: the email address of the webmaster.
  // This address is used for outgoing emails, so shouldnt be obfuscated.
  $EMAIL_WEBMASTER = 'email@mydomain.ext';

  // *********************************************************************
  // OPTIONAL SITE PARAMETERS
  // ------------------------
  // You can change the parameters below to change certain functionality
  // of RPG Web Profiler, but it will work without changing them.
  // *********************************************************************

  // Open character sheets in a new window
  $NEW_WINDOW = true;

  // Require Login to view any characters (including public)
  $REQUIRE_LOGIN = false;

  // Allow anyone to register on the profiler. If you want to disable this,
  // you should create your accounts before you do. Once set to false, you
  // have to manually add new accounts to the database.
  $OPEN_REGISTRATION = true;

  // Use the sidebar menu with quick links to chararacters and campaigns
  // when logged in. If set to false, the site continues to use the old
  // top menu.
  $USE_SIDEBAR = true;

  // Display system statistics. Setting this to false will improve system
  // performance.
  $DISPLAY_STATS = true;

  // Display Character Image page
  $DISPLAY_IMAGES = true;

  // Display FAQ Link
  $DISPLAY_FAQ = true;

  // Site CSS File
  $SITE_CSS = 'css/template.css';

  // Site News File
  // - If you dont want a news section, just comment this out.
  // - If you use your own file, the default file is located in the
  //   root_profiler/templates/ directory.
  $SITE_NEWS = 'news.php';

  // URI_HOME: The page the "Home" link in the header directs to. By
  // default this is the main profiler page, but you can change it to
  // point to the homepage of your main site rather than the profiler.
  $URI_HOME = $URI_BASE;

  // URI_TOS: your sites terms of service and privacy policy.
  $URI_TOS = 'legal.php';

  // LOGO: The image that appears at the top left of the page.
  // Note: The image should be 73 pixels in height
  $LOGO = 'imgs/rpgwebprofiler.gif';

  // FORUM: If you have certain forum software, the profiler can use the
  // forum authentication mechanism to allow for a single sign on point.
  // If you wish to use the forum authentication, uncomment the variable,
  // and specify the appropriate forum.
  // Currently supported forums: phpBB2
  //$FORUM = "phpBB2";

  // If you are using forum authentication, define the forum apps root
  // directory here.
  //$FORUM_ROOT = "/path/to/phpbb/";

  // URL for forum login page. This is required for redirecting if
  // authentication fails.
  //$FORUM_LOGIN = "http://www.mydomaing.com/forum/login.php";

  // *********************************************************************
  // OTHER PARAMETERS
  // ------------------------
  // You should not edit the parameters below unless you know what you are
  // doing. If you change them, the profiler could stop working.
  // *********************************************************************

  // Database Table Names - YOU SHOULD NOT EDIT THESE. Unless you have
  // changed the names of the tables in use (eg - for multiple copies of
  // the profiler running off one database).
  $TABLE_USERS = 'profiles';
  $TABLE_CHARS = 'characters';
  $TABLE_OWNERS = 'character_owners';
  $TABLE_TEMPLATES = 'sheet_templates';
  $TABLE_SERIALIZE = 'serialization_formats';
  $TABLE_CAMPAIGNS = 'campaign';
  $TABLE_CAMPAIGN_REQUESTS = 'campaign_join';

  ////////////////////////////////////////////////////////////////////////
  // Behavior parameters.

  // If debug is true, error messages will usually display the exact line
  // and filename that raised the error, and validation links will appear
  // on most output pages.
  $DEBUG = true;
?>
