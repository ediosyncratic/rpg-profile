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
    if (!isNaN(num))
    	total += num;
  }

  document.getElementById("bagWeight").innerHTML = total.toFixed(1);

  // Add the armor weight.
  for ( var i = 1; i <= 4; i++ )
  {
     // If the armor is flagged as not carried, then don't add it to the weight.
     if ( !sheet()["Armor" + i + "Carried"].checked )
         continue;

     var num = parseFloat(sheet()["Armor" + i + "Weight"].value);
     if (isNaN(num))
        num = 0.0;
     total += num;
  }

  // Add the weapon weight
  for ( var i = 1; i <= 4; i++ )
  {
    if ( sheet()[ "Weapon" + i + "Carried" ].checked )
     {
      var num = parseFloat(sheet()["Weapon" + i + "Weight"].value);
      if (isNaN(num))
         num = 0.0;
      total += num;
     }
  }

  sheet().TotalWeight.value = total.toFixed(1);

  // Check to see if the character is encumbered.  If so, then set the background
  // color of "Total Weight", Speed, and DexMod input fields to red.
  if ( Clean( sheet().TotalWeight.value ) > Clean( sheet().LightLoad.value ) )
  {
     debug.trace("Character is encumbered.");                     
     var maxDexMod = 99;

    if ( Clean( sheet().TotalWeight.value ) > Clean( sheet().MediumLoad.value ) )
     {
           maxDexMod = 1;
           sheet().TotalWeight.title = "Check penalty of -6 while encumbered";
     }
     else
     {
           maxDexMod = 3;
           sheet().TotalWeight.title = "Check penalty of -3 while encumbered";
     }

     debug.trace("MaxDexMod = " + maxDexMod + " DexMod = " + Clean( sheet().DexMod.value ) );
     if ( Clean( sheet().DexMod.value ) > maxDexMod )
     {
           sheet().DexMod.title = "Max dex bonus to AC is +" + maxDexMod + " while encumbered.";
           sheet().DexMod.style.color           = "white";
           sheet().DexMod.style.backgroundColor = "red";
     }
     else
     {
           sheet().DexMod.title = sheet().DexMod.value;
           sheet().DexMod.style.color           = "black";
       sheet().DexMod.style.backgroundColor = "white";
     }

    sheet().TotalWeight.style.color           = "white";
    sheet().TotalWeight.style.backgroundColor = "red";

    sheet().Speed.title = "Max speed is reduced by roughly 1/3 due to encumbrance";
    sheet().Speed.style.color           = "white";
    sheet().Speed.style.backgroundColor = "red";

    ACCheckMaxDex(); // Check if the dex bonus to AC should be reduced.
  }
  else
  {
    sheet().TotalWeight.title                    = sheet().TotalWeight.value;
    sheet().TotalWeight.style.color           = "black";
     sheet().TotalWeight.style.backgroundColor = "white";

    sheet().DexMod.title                  = sheet().DexMod.value;
    sheet().DexMod.style.color           = "black";
     sheet().DexMod.style.backgroundColor = "white";

    sheet().Speed.title                      = sheet().Speed.value;
    sheet().Speed.style.color           = "black";
     sheet().Speed.style.backgroundColor = "white";
  }


  SkillsUpdateCheckPen();

  debug.trace("Calculated total weight.");
}

// Recalculate off-character container total
function ContainerWeight(container)
{
  if (disable_autocalc())
    return;

  var total = 0.0;
  var slots = document.getElementById(container).rows.length - 3;
  for (var i = 1; i <= slots; i++)
  {
    var num = parseFloat(sheet()[container + "Gear" + FormatNumber(i) + "W"].value);
    if (isNaN(num))
      num = 0.0;
    total += num;
  }

  document.getElementById(container + "Weight").innerHTML = total.toFixed(1);
}

// Sort off-character container (by name or weight)
function ContainerSort(container, sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById(container).rows;

  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  debug.trace("Copying gear data...");
  var rows_c = new Array();
  for (var i = 2; i < rows.length - 1; i++)
  {
    r = new Object();
    r.item = rows[i].cells[0].firstChild.value;
    r.weight = rows[i].cells[1].firstChild.value;
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
  }

  debug.trace("Sorting complete.");
}

// void ChangeWeapon(void)
// One of the wielded/carried checkboxes was changed.  Make sure all the appropriate
// checkboxes are checked and recalculate the wieght.
// 'wielded' is true if the user changed the 'wielded' checkbox.
function ChangeWeapon( wielded )
{
  if (disable_autocalc())
    return;

  var source;
  var target;
  var value;

  if ( wielded )
  {
     source = "Wielded";
     target = "Carried";
     value  = true;
  }
  else
  {
     source = "Carried";
     target = "Wielded";
     value  = false;
  }

  for ( var i = 1; i <= 4; i++ )
  {
    if ( sheet()[ "Weapon" + i + source ].checked == value )
        sheet()[ "Weapon" + i + target ].checked = value;
  }

  // We need to call this because we may have changed the 'carried' flag
  CalcWeight();  
}

// Sum Cash
function SumCash() 
{
  ZeroFill(sheet()["CashPP"]);
  ZeroFill(sheet()["CashGP"]);
  ZeroFill(sheet()["CashSP"]);
  ZeroFill(sheet()["CashCP"]);

  var total = 0;
  total += (parseInt(sheet()["CashPP"].value) * 10); 
  total += (parseInt(sheet()["CashGP"].value));
  total += (parseInt(sheet()["CashSP"].value) / 10);
  total += (parseInt(sheet()["CashCP"].value) / 100);

  total *= 100;
  total = Math.round(total);
  total /= 100;

  sheet()["CashTotal"].value = total;

  ZeroFill(sheet()["CashPPParty"]);
  ZeroFill(sheet()["CashGPParty"]);
  ZeroFill(sheet()["CashSPParty"]);
  ZeroFill(sheet()["CashCPParty"]);

  total = 0;
  total += (parseInt(sheet()["CashPPParty"].value) * 10);
  total += (parseInt(sheet()["CashGPParty"].value));
  total += (parseInt(sheet()["CashSPParty"].value) / 10);
  total += (parseInt(sheet()["CashCPParty"].value) / 100);

  total *= 100;
  total = Math.round(total);
  total /= 100;

  sheet()["CashTotalParty"].value = total;


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

