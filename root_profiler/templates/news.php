<?php
/*
 * news.php 
 * 
 * Default news file for RPG Web Profiler
 * 
 * Created on Jun 28, 2006
 */
?>
<h1>RPG Web Profiler News</h1>

<h2>28 June 2006 - v0.2.0 Released</h2>

<ul>
<li>Removed Smarty Templates
<li>Added imgs/blank.gif for use when no LOGO image is desired.</li>
<li>New Admin Options
  <ul>
  <li>SITE_CSS: Change the CSS file in use to make updates easier</li>
  <li>SITE_NEWS: Change the file used to display news.</li>
  <li>NEW_WINDOW: Prevent Character sheets opening in a new window</li>
  <li>REQUIRE_LOGIN: Remove public access to character sheets, so only registered users can see them</li>
  <li>OPEN_REGISTRATION: Stop people from registering. Makes the site a private installation.</li>
  <li>DISPLAY_IMAGES: Show/Hide the link to the character image library</li>
  <li>DISPLAY_FAQ: Show/Hide the link to the FAQ</li>
  </ul>
</ul>

<p>The first two admin options listed above, along with the previous renaming of
the system configuration file within the Subversion repository are intended to 
make future upgrade paths easier. Ideally, you should be able to extract a new
version of the application into the install directory without then having to
re-configure the application for your site.</p>

<h2>15 June 2006 - v0.1.0 Released</h2>

<ul>
<li>First release of RPG Web Profiler.</li>
<li>Re-branded application with new name</li>
<li>Some search improvements over 3eProfiler</li>
<li>Character Image library browser</li>
</ul>