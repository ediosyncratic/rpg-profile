// void GearSort(sortfunc)
// Sorts the gear table according to the sorting function that is passed
// to sortfunc. GearSort contains members that can act as sorting
// functions for the Array.sort() method.
function GearSort(sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById("gearList").rows;

  // ================================================
  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  var rows_c = new Array();
  for (var i = 1; i < rows.length; i++)
  {
    r = new Object();
    r.name =   rows[i].cells[0].firstChild.value;
    r.weight = rows[i].cells[2].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  rows_c.sort(sortfunc);

  // ================================================
  // Now, restore the sorted data.
  for (var i = 1; i < rows.length; i++)
  {
    var r = rows_c.shift();
    rows[i].cells[0].firstChild.value = r.name;
    rows[i].cells[2].firstChild.value = r.weight;
  }
}

function pGearSort(sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById("pGearList").rows;

  // ================================================
  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  var rows_c = new Array();
  for (var i = 1; i < rows.length; i++)
  {
    r = new Object();
    r.name =		rows[i].cells[0].firstChild.value;
    r.location =	rows[i].cells[2].firstChild.value;
    r.weight =		rows[i].cells[4].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  rows_c.sort(sortfunc);

  // ================================================
  // Now, restore the sorted data.
  for (var i = 1; i < rows.length; i++)
  {
    var r = rows_c.shift();
    rows[i].cells[0].firstChild.value = r.name;
    rows[i].cells[2].firstChild.value = r.location;
    rows[i].cells[4].firstChild.value = r.weight;
  }
}

function p2GearSort(sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById("pGearList").rows;

  // ================================================
  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  var rows_c = new Array();
  for (var i = 1; i < rows.length; i++)
  {
    r = new Object();
    r.name =	rows[i].cells[6].firstChild.value;
    r.location =	rows[i].cells[8].firstChild.value;
    r.weight =	rows[i].cells[10].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  rows_c.sort(sortfunc);

  // ================================================
  // Now, restore the sorted data.
  for (var i = 1; i < rows.length; i++)
  {
    var r = rows_c.shift();
    rows[i].cells[6].firstChild.value = r.name;
    rows[i].cells[8].firstChild.value = r.location;
    rows[i].cells[10].firstChild.value = r.weight;
  }
}