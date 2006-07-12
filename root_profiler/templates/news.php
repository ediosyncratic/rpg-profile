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

<h2>13 July 2006 - v0.3.0 Released</h2>

<ul>
<li>Changed characters to have single owner.</li>
<li>Character editing permissions can now be removed.</li>
<li>Characters owned by different profiles show with * prefix in character list.</li>
<li>Only character owner can set public permissions and add/remove editors.</li>
<li>Added Transfer Character function, to change owners.</li>
<li>Added DM Function checkbox to Profile screen.</li>
<li>Added Campaign Functionality.</li>
<ul>
  <li>Users with DM Functions enabled can create campaigns.</li>
  <li>Can search on campaign names, and see information on available campaigns.</li>
  <li>Characters can request to join, or can be invited to join.</li>
  <li>Campaign Owner (DM) automatically gains full edit permissions to all participating characters.</li>
</ul>
<li>Tidied up search functionality.</li>
</ul>

<p>This is quite a substantial change to the profiler, and includes a number
of database changes. These are located in update-mysqldb.sql, and should run
without problems. See the update instructions in the download for more
details.</p>

<p>The major change for this release is the Campaign functionality. Users can set
up campaigns, and characters can be added to those campaigns either by request
or invitation. All requests and invitations must be accepted by both the
character and the campaign owner (DM) before the character is added.</p>

<p>One of the advantages of the Campaign functionality is that the DM
automatically gets edit permissions for all characters, but does not gain the
ability to change details such as whether or not the character is public.</p>

<h2>28 June 2006 - v0.2.0 Released</h2>

<ul>
<li>Removed Smarty Templates
<li>Added imgs/blank.gif for use when no LOGO image is desired.</li>
<li>New Admin Options</li>
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
