<!--
  resetpwd.php

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

  Entry point form for the password reset process: the user is asked for
  their profile name.
-->

<h1>Reset Password</h1>
<form action="resetpwd.php" method="get">
  <p>
    Your password can't be retrieved, but it can be reset. To reset your password, enter your profile name below and submit your request. An email will be sent to the address kept in your profile. In the message will be a link that you can visit that will allow you to re-enter a new password.
  </p>
  <p>
    If you did not have a valid email address stored in your profile, your password can not be reset since there is no way to verify your identity.
  </p>
  <p>
    Enter your profile name: <input type="text" name="p" maxlength="20" class="quick" />&nbsp;&nbsp;<input type="submit" class="go" value="Reset my password" />
  </p>
</form>
