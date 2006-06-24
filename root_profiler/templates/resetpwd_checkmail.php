<!--
  resetpwd_checkmail.tpl

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

  Shows a message instructing the user to check their mail to continue the
  password resetting process.
-->

<?php global $pname; ?>

<h1>Reset Password :: Mail Sent</h1>
<p>
  <b><?php echo $pname; ?></b>, an email was sent to the address listed in your profile. Please check your mail and follow the directions in the email message to finish resetting your password.
</p>
