// gear.js

// Functions that maintain the gear table.

// Dependencies:
//    debug.js
//    general.js

// void CalcWeight(void)
// Tallies up the total weight.
function CalcWeight()
{
  if (disable_autocalc())
    return;

  var total = 0.0;
  var slots = document.getElementById("gear").rows.length - 3;
  for (var i = 1; i <= slots; i++)
  {
    var num = parseFloat(sheet()["Gear" + FormatNumber(i) + "W"].value);
    if (isNaN(num))
      num = 0.0;
    total += num;
  }

  document.getElementById("totalweight").innerHTML = total.toFixed(1);

  debug.trace("Calculated total weight.");
}

// void GearSort(sortfunc)
// Sorts the gear table according to the sorting function that is passed
// to sortfunc. GearSort contains members that can act as sorting
// functions for the Array.sort() method.
function GearSort(sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById("gear").rows;

  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  debug.trace("Copying gear data...");
  var rows_c = new Array();
  for (var i = 2; i < rows.length - 1; i++)
  {
    r = new Object();
    r.item = rows[i].cells[0].firstChild.value;
    r.weight = rows[i].cells[1].firstChild.value;
    r.loc = rows[i].cells[2].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  debug.trace("Sorting gear data...");
  rows_c.sort(sortfunc);

  // Now, restore the sorted data.
  debug.trace("Copying sorted gear data...");
  for (var i = 2; i < rows.length - 1; i++)
  {
    var r = rows_c.shift();
    rows[i].cells[0].firstChild.value = r.item;
    rows[i].cells[1].firstChild.value = r.weight;
    rows[i].cells[2].firstChild.value = r.loc;
  }

  debug.trace("Sorting complete.");
}

GearSort.ByName = function(a, b)
{
  if ((a.item.length == 0) && (b.item.length == 0))
    return 0;
  else if (a.item.length == 0)
    return 1;
  else if (b.item.length == 0)
    return -1;
  return a.item.localeCompare(b.item);
}

GearSort.ByWeight = function(a, b)
{
  numa = parseFloat(a.weight);
  numb = parseFloat(b.weight);
  if ((isNaN(numa)) && (isNaN(numb)))
    return GearSort.ByName(a, b);
  else if (isNaN(numa))
    return 1;
  else if (isNaN(numb))
    return -1;
  if (numa == numb)
    return GearSort.ByName(a, b);
  else
    return (numa > numb) ? -1 : 1;
}

GearSort.ByLoc = function(a, b)
{
  if ((a.loc.length == 0) && (b.loc.length == 0))
    return GearSort.ByName(a, b);
  else if (a.loc.length == 0)
    return 1;
  else if (b.loc.length == 0)
    return -1;
  var comp = a.loc.localeCompare(b.loc);
  if (comp)
    return comp;
  else
    return GearSort.ByName(a, b);
}