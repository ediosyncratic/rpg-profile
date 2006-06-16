{*
  adminsearch.php

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
*}

<h1>Search</h1>
<form action="search.php" method="get">
<p>
  Search for a character whose name <select name="type" class="quick">
 <option value="begins">begins with</option>
 <option value="contains">contains</option>
 <option value="ends">ends with</option>
 <option value="all">all entires</option>
  </select>
 <input type="text" name="cname" maxlength="20" class="quick" />
 <input type="submit" value="Search" class="go" />
</p>
