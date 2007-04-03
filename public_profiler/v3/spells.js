// spells.js

// Defines scripts used to maintain the spell list table.

function SpellSort(sortfunc)
{
  var tblrows = 
  [
    // Three child tables of the spells table, the first one is the spells
    // known table, which we don't care about, but get a reference to the
    // the rows of the remaining two tables.
    document.getElementById("spells").getElementsByTagName("table")[1].rows,
    document.getElementById("spells").getElementsByTagName("table")[2].rows
  ];
  
  // Copy the data from each of the items in the rows.
  debug.trace("Copying spell data...");
  var data = new Array();
  for (var i = 0; i < 2; i++)
  {
    for (var j = 1; j < tblrows[i].length; j++)
    {
      var thisdata = new Object();
      thisdata.spell = tblrows[i][j].cells[0].firstChild.value;
      thisdata.mem = tblrows[i][j].cells[1].firstChild.value;
      data.push(thisdata);
    }
  }

  // Now sort the data according to the given sortfunc.
  debug.trace("Sorting spell data...");
  data.sort(sortfunc);

  // Finally, re-copy all the data.
  debug.trace("Copying sorted spell data...");
  for (var i = 0; i < 2; i++)
  {
    for (var j = 1; j < tblrows[i].length; j++)
    {
      var thisdata = data.shift();
      tblrows[i][j].cells[0].firstChild.value = thisdata.spell;
      tblrows[i][j].cells[1].firstChild.value = thisdata.mem;
    }
  }

  debug.trace("Sorting complete.");
}

SpellSort.ByName = function(a, b)
{
  if ((a.spell.length == 0) && (b.spell.length == 0))
    return 0;
  else if (a.spell.length == 0)
    return 1;
  else if (b.spell.length == 0)
    return -1;
  return a.spell.localeCompare(b.spell);
}

SpellSort.ByMem = function(a, b)
{
  if ((a.mem.length == 0) && (b.mem.length == 0))
    return SpellSort.ByName(a, b);
  else if (a.mem.length == 0)
    return 1;
  else if (b.mem.length == 0)
    return -1;
  var comp = a.mem.localeCompare(b.mem);
  if (comp)
    return comp;
  else
    return SpellSort.ByName(a, b);
}