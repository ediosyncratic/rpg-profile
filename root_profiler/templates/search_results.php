<!--
  search_results.php

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
-->

<?php
global $characters, $ls_mod, $ch_name, $np, $nextpage, $prevpage, $cname;
?>

<h1>Search Results</h1>
<table>
  <thead>
    <tr>
      <th><?php echo $ch_name; ?></th><th><?php echo $ls_mod; ?></th><th>Template</th>
    </tr>
  </thead>
  <tbody>
<?php if( count($characters) > 0 ) { ?>
<?php foreach( $characters as $character ) { ?>
      <tr><td><a href="view.php?id=<?php echo $character['id']; ?>"><?php echo $character['cname']; ?></a></td>
          <td><?php echo $character['lastedited']; ?></td><td><?php echo $character['template']; ?></td></tr>
<?php } ?>
<?php } else { ?>
      <tr><td colspan="2">No characters found!</td></tr>
<?php } ?>
  </tbody>
</table>

<?php if( $prevpage ) { ?>
  <a href="search.php?type=<?php echo $type; ?>&amp;cname=<?php echo $cname; ?>&amp;page=<?php echo $prevpage; ?><?php echo $np; ?>">&lt; Previous</a>
  <?php if( $nextpage ) { echo '|'; } ?>
<?php } ?>
<?php if( $nextpage ) { ?>
  <a href="search.php?type=<?php echo $type; ?>&amp;cname=<?php echo $cname; ?>&amp;page=<?php echo $nextpage; ?><?php echo $np; ?>">Next &gt;</a>
<?php } ?>
<br><br>
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
