// sort.js

function Sort(table) {
  // Create a shortcut to the rows of the skills table.
  var rows = table.rows;

  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).

  var rows_c = new Array();
  for (var i = 1; i < rows.length - 1; i++)
  {
    r = new Object();
    r.name = rows[i].cells[0].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  rows_c.sort(sortfunc);

  // Now, restore the sorted data.
  for (var i = 1; i < rows.length - 1; i++)
  {
    var r = rows_c.shift();
    rows[i].cells[0].firstChild.value = r.name;
  }
}

Sort.ByName = function(a, b)
{
  if ((a.name.length == 0) && (b.name.length == 0))
    return 0;
  else if (a.name.length == 0)
    return 1;
  else if (b.name.length == 0)
    return -1;
  return a.name.localeCompare(b.name);
}

Sort.ByWeight = function(a, b)
{
  numa = parseFloat(a.weight);
  numb = parseFloat(b.weight);
  if ((isNaN(numa)) && (isNaN(numb)))
    return Sort.ByName(a, b);
  else if (isNaN(numa))
    return 1;
  else if (isNaN(numb))
    return -1;
  if (numa == numb)
    return Sort.ByName(a, b);
  else
    return (numa > numb) ? -1 : 1;
}

Sort.ByLocation = function(a, b)
{
  if ((a.location.length == 0) && (b.location.length == 0))
    return 0;
  else if (a.location.length == 0)
    return 1;
  else if (b.location.length == 0)
    return -1;
  return a.location.localeCompare(b.location);
}
