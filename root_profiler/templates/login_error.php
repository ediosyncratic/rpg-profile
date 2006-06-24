<!--
  login_error.tpl

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

  Defines the interface seen by the user when a login fails.
-->
<h1>Login Failed!</h1>
<p>
  Your identity could not be confirmed. Some common cases of login errors
  are listed below.
</p>
<ul>
  <li>
    You must be <a href="register.php">registered</a> before
    you can login.
  </li>
  <li>
    Login names and passphrases are case sensitive.
  </li>
  <li>
    Only a profile name can be logged in. Individual character sheets do
    not have passwords and can not be used for login verification.
  </li>
  <li>
    If you can't remember your passphrase, request to have it
    <a href="resetpwd.php">reset</a>. Your profile must have
    a valid email address registered for this to work.
  </li>
</ul>
<p>
  Click your browser's <a href="javascript:history.back(1);">back</a>
  button to return to the <a href="index.php">login</a> page.
</p>
