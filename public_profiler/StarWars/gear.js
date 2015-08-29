// void GearSort(sortfunc)
// Sorts the gear table according to the sorting function that is passed
// to sortfunc. GearSort contains members that can act as sorting
// functions for the Array.sort() method.
function GearSort(sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows1 = document.getElementById("gear0").rows;
  var rows2 = document.getElementById("gear1").rows;

  // ================================================
  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  var rows_c = new Array();
  for (var i = 1; i < rows1.length; i++)
  {
    r = new Object();
    r.name =   rows1[i].cells[0].firstChild.value;
    r.weight = rows1[i].cells[1].firstChild.value;
    rows_c.push(r);

    r = new Object();
    r.name =   rows2[i].cells[0].firstChild.value;
    r.weight = rows2[i].cells[1].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  rows_c.sort(sortfunc);

  // ================================================
  // Now, restore the sorted data.
  for (var i = 1; i < rows1.length; i++)
  {
    var r = rows_c.shift();
    rows1[i].cells[0].firstChild.value = r.name;
    rows1[i].cells[1].firstChild.value = r.weight;
  }

  for (var i = 1; i < rows2.length; i++)
  {
    var r = rows_c.shift();
    rows2[i].cells[0].firstChild.value = r.name;
    rows2[i].cells[1].firstChild.value = r.weight;
  }

}