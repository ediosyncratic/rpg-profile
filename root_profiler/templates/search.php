<!--
  adminsearch.php

-->

<h1>Character Search</h1>
<form action="search.php" method="get">
<p>
  Search for a character whose name <select name="type" class="quick">
    <option value="begins">begins with</option>
    <option value="contains">contains</option>
    <option value="ends">ends with</option>
    <option value="all">all entries</option>
  </select>
  <input type="text" name="cname" maxlength="20" class="quick" />
  <input type="submit" value="Search" class="go" />
</p>
</form>

<h1>Campaign Search</h1>
<form action="campaign_search.php" method="get">
<p>
  Search for a campaign whose name <select name="type" class="quick">
    <option value="begins">begins with</option>
    <option value="contains">contains</option>
    <option value="ends">ends with</option>
    <option value="all">all entries</option>
  </select>
  <input type="text" name="cname" maxlength="20" class="quick" />
  <input type="submit" value="Search" class="go" />
</p>
</form>
