// Sorts the skill table according to the sorting function that is passed
// to sortfunc. SkillSort contains members that can act as sorting
// functions for the Array.sort() method.
function SkillSort(sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById("skills").rows;

  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  var rows_c = new Array();
  for (var i = 1; i < rows.length - 1; i++)
  {
    r = new Object();
    r.class =   rows[i].cells[0].firstChild.checked;
    r.name =    rows[i].cells[1].firstChild.value;
    r.ability = rows[i].cells[2].firstChild.value;
    r.total =   rows[i].cells[3].firstChild.value;
    r.mod =     rows[i].cells[5].firstChild.value;
    r.ranks =   rows[i].cells[7].firstChild.value;
    r.misc =    rows[i].cells[9].firstChild.value;
    r.error =    rows[i].cells[11].firstChild.value;
    r.threat =    rows[i].cells[13].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  rows_c.sort(sortfunc);

  // Now, restore the sorted data.
  for (var i = 1; i < rows.length - 1; i++)
  {
    var r = rows_c.shift();
    rows[i].cells[0].firstChild.checked = r.class;
    rows[i].cells[1].firstChild.value = r.name;
    rows[i].cells[2].firstChild.value = r.ability;
    rows[i].cells[3].firstChild.value = r.total;
    rows[i].cells[5].firstChild.value = r.mod;
    rows[i].cells[7].firstChild.value = r.ranks;
    rows[i].cells[9].firstChild.value = r.misc;
    rows[i].cells[11].firstChild.value = r.error;
    rows[i].cells[13].firstChild.value = r.threat;
  }

}

SkillSort.ByRanks = function(a, b)
{
  if ((a.ranks.length == 0) && (b.ranks.length == 0))
    return 0;
  else if (a.ranks.length == 0)
    return 1;
  else if (b.ranks.length == 0)
    return -1;

  var comp = a.ranks.localeCompare(b.ranks);
  if (comp)
    return comp;
  else
    return Sort.ByName(a, b);
}

SkillSort.ByTotal = function(a, b)
{
  if ((a.total.length == 0) && (b.total.length == 0))
    return 0;
  else if (a.total.length == 0)
    return 1;
  else if (b.total.length == 0)
    return -1;

  var comp = -(a.total.localeCompare(b.total));
  if (comp)
    return comp;
  else
    return Sort.ByName(a, b);
}

SkillSort.ByAbility = function(a, b)
{
  if ((a.ability.length == 0) && (b.ability.length == 0))
    return 0;
  else if (a.ability.length == 0)
    return 1;
  else if (b.ability.length == 0)
    return -1;

  var comp = a.ability.localeCompare(b.ability);
  if (comp)
    return comp;
  else
    return Sort.ByName(a, b);
}

