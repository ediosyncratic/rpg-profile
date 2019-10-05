// skills.js

// Implements functions used for maintining the skill table. See also
// ogl/skills.js for data that is used by some of these functions to
// populate the skill fields.

// Dependencies:
//    class.js
//    debug.js
//    general.js
//    ogl/skills.js

// void SkillCalcRanks(void)
// Tallies the total number of skill points spent, weighting the ranks in
// each skill with whether or not it's a cross class skill.
function SkillCalcRanks()
{
  if (disable_autocalc())
    return;

  var total = 0;
  var slots = document.getElementById("skills").rows.length - 3;
  // Calculate the total ranks.
  for (var i = 1; i <= slots; i++)
  {
    var num = FormatNumber(i);
    total += GetNum(sheet()["Skill" + num + "Rank"])
      * (sheet()["Skill" + num + "CC"].checked ? 2 : 1);
  }

  // Set the value.
  document.getElementById("totalranks").innerHTML = total;

  debug.trace("Calculated total Skill Points.");
}

// void SkillCalc(node)
// Recalculates the skill modifier for a skill. Function expects one of
// the input nodes for the skill row to be passed to it.
function SkillCalc(node)
{
  if (disable_autocalc())
    return;

  // Determine which skill is being adjusted (the first 7 chars of the
  // node name are always "SkillXX", regardless of which row the input is
  // from.
  var skill = String(node.name).substr(0, 7);

  ZeroFill(
    sheet()[skill + "AbMod"],
    sheet()[skill + "Rank"],
    sheet()[skill + "MiscMod"]);

  sheet()[skill + "Mod"].value = Add(
    sheet()[skill + "AbMod"].value,
    sheet()[skill + "Rank"].value,
    sheet()[skill + "MiscMod"].value);

  debug.trace("Calculated modifier for "
    + (sheet()[String(node.name).substr(0, 7)].value ? sheet()[String(node.name).substr(0, 7)].value : "[Unnamed Skill]")
    + ".");
}

// void SkillLookUp(node)
// Performs a lookup of the skill name to try to find the skill's
// primary ability. If the skill is found, the ability is set then the
// onchange events for the ability modifier is triggered.
function SkillLookUp(node)
{
  if (disable_autocalc())
    return;

  // Parse the info from the node.
  var skill = GetText(node);

  if (typeof skillKeys[skill] == "undefined")
  {
    debug.trace("No info found for " + skill + ".");
    return;
  }

  debug.trace("Found key ability for " + skill + ".");
  sheet()[node.name + "Ab"].value = abilityKeys[skillKeys[skill]];

  // Determine if the skill is a class skill or not.
  // if (classSkills[node.value])
  //   node.parentNode.parentNode.cells[2].firstChild.checked = _getClassBitSet() & classSkills[node.value] ? "" : "checked";
  SkillLookUpKeyAb(sheet()[node.name + "Ab"]);
}

// void SkillLookUpKeyAb(node)
// Retrieves the skills key ability modifier and recalculates the skill
// modifier accordingly. The node passed to this function should be the
// Key Ability node.
function SkillLookUpKeyAb(node)
{
  if (disable_autocalc())
    return;

  // Can't make any assumptions about the node value, since the user may
  // have written anything.
  var ability = GetText(node);

  if (ability == "str") ability = "Str";
  else if (ability == "dex") ability = "Dex";
  else if (ability == "con") ability = "Con";
  else if (ability == "int") ability = "Int";
  else if (ability == "wis") ability = "Wis";
  else if (ability == "cha") ability = "Cha";
  else
  {
    // Not a valid ability name.
    debug.trace("Warning: " + ability + " is an invalid ability name.");
    return;
  }

  // If we don't have a modifier, return without doing anything else.
  if (!(sheet()[ability + "Mod"].value.length
    || sheet()[ability + "TempMod"].value.length))
    return;

  // Determine if skill is cross-class.
  var skillRow = node.parentNode.parentNode;
  // If the skill name is found in our classSkills hash.
  if (classSkills[skillRow.cells[0].firstChild.value])
    // Set the CC checkbox accordingly.
    skillRow.cells[2].firstChild.checked = _getClassBitSet() & classSkills[skillRow.cells[0].firstChild.value] ? "" : "checked";

  // If a temp mod exists, use it, otherwise use the regular one.
  var mod = String(sheet()[ability + "TempMod"].value).length > 0
    ? GetNum(sheet()[ability + "TempMod"])
    : GetNum(sheet()[ability + "Mod"]);
  sheet()[node.name + "Mod"].value = mod;

  debug.trace("Retrieved " + ability + " mod for " + sheet()[String(node.name).substr(0, 7)].value + ".");

  SkillCalc(node);
}

// void SkillSort(sortfunc)
// Sorts the skill table according to the sorting function that is passed
// to sortfunc. SkillSort contains members that can act as sorting
// functions for the Array.sort() member.
function SkillSort(sortfunc)
{
  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById("skills").rows;

  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  debug.trace("Copying skill data...");
  var rows_c = new Array();
  for (var i = 2; i < rows.length - 1; i++)
  {
    r = new Object();
    r.skill = rows[i].cells[0].firstChild.value;
    r.ab = rows[i].cells[1].firstChild.value;
    r.cc = rows[i].cells[2].firstChild.checked;
    r.mod = rows[i].cells[3].firstChild.value;
    r.abmod = rows[i].cells[5].firstChild.value;
    r.rank = rows[i].cells[7].firstChild.value;
    r.misc = rows[i].cells[9].firstChild.value;
    rows_c.push(r);
  }

  // Sort the data.
  debug.trace("Sorting skill data...");
  rows_c.sort(sortfunc);

  // Now, restore the sorted data.
  debug.trace("Copying sorted skill data...");
  for (var i = 2; i < rows.length - 1; i++)
  {
    var r = rows_c.shift();
    rows[i].cells[0].firstChild.value = r.skill;
    rows[i].cells[1].firstChild.value = r.ab;
    rows[i].cells[2].firstChild.checked = r.cc;
    rows[i].cells[3].firstChild.value = r.mod;
    rows[i].cells[5].firstChild.value = r.abmod;
    rows[i].cells[7].firstChild.value = r.rank;
    rows[i].cells[9].firstChild.value = r.misc;
  }

  debug.trace("Sorting complete.");
}

SkillSort.ByName = function(a, b)
{
  if ((a.skill.length == 0) && (b.skill.length == 0))
    return 0;
  else if (a.skill.length == 0)
    return 1;
  else if (b.skill.length == 0)
    return -1;
  return a.skill.localeCompare(b.skill);
}

SkillSort.ByAbility = function(a, b)
{
  if ((a.ab.length == 0) && (b.ab.length == 0))
    return SkillSort.ByName(a, b);
  else if (a.ab.length == 0)
    return 1;
  else if (b.ab.length == 0)
    return -1;
  // Custom order:
  var key = {'str': 1, 'dex': 2, 'con': 3, 'int': 4, 'wis': 5, 'cha': 6};
  var comp = key[a.ab.toLowerCase()] - key[b.ab.toLowerCase()];
  if (comp)
    // If different, return the comparison.
    return comp;
  else
    // If equal, return the result of sorting by name.
    return SkillSort.ByName(a, b);
}

SkillSort.ByCC = function(a, b)
{
  if (a.cc && b.cc)
    return SkillSort.ByName(a, b);
  else if (!a.cc && !b.cc)
    return SkillSort.ByName(a, b);
  else
    return a.cc ? -1 : 1;
}

SkillSort.ByMod = function(a, b)
{
  return SkillSort._ByNumber(a, b, "mod");
}

SkillSort.ByAbMod = function(a, b)
{
  return SkillSort._ByNumber(a, b, "abmod");
}

SkillSort.ByRank = function(a, b)
{
  return SkillSort._ByNumber(a, b, "rank");
}

SkillSort.ByMisc = function(a, b)
{
  return SkillSort._ByNumber(a, b, "misc");
}

SkillSort._ByNumber = function(a, b, prop)
{
  numa = parseFloat(a[prop]);
  numb = parseFloat(b[prop]);
  if ((isNaN(numa)) && (isNaN(numb)))
    return SkillSort.ByName(a, b);
  else if (isNaN(numa))
    return 1;
  else if (isNaN(numb))
    return -1;
  if (numa == numb)
    return SkillSort.ByName(a, b);
  else
    return (numa > numb) ? -1 : 1;
}

// Fill the skill table with the core 3.5 skill set.
function SkillAutoFill()
{
  if (disable_autocalc())
    return;

  // Verify before continuing.
  if (!confirm("AutoFill will initialize the skill table with the core 3.5E D&D skill set. This will clear any existing data.\n\nAre you sure you want to continue?"))
    return;

  // First clear the table.
  _skillClear();

  _skillFill();
}

// Clear the entire skill table.
function SkillClear()
{
  if (disable_autocalc())
    return;

  // Verify before actually clearing.
  if (!confirm("Clearing the skill table will remove ALL skill data.\n\nAre you sure you want to continue?"))
    return;

  _skillClear();
  SkillCalcRanks();
}

// Update the cross-class checkboxes according to the class information.
function SkillsUpdateCC()
{
  if (!confirm("UpdateCC will compare your skills against the classes the your character has been assigned and determine if each skill is a class skill or not. This method will usually only work for skills that have been assigned via AutoFill and for the core 3.5E classes...\n\nDo you wish to continue?"))
    return;

  // Create a shortcut to the rows of the skills table.
  var rows = document.getElementById("skills").rows;
  var classes = _getClassBitSet();
  var unresolved = new Array();
  for (var i = 2; i < rows.length - 1; i++)
  {
    var skill_name = rows[i].cells[0].firstChild.value;
    var skill_cc = rows[i].cells[2].firstChild;
    if (skill_name.length == 0)
      continue;
    if (classSkills[skill_name])
      skill_cc.checked = classes & classSkills[skill_name] ? "" : "checked";
    else
      unresolved.push(skill_name);
  }

  SkillCalcRanks();

  if (unresolved.length > 0)
  {
    var msg = "Failed to resolve the following skills:\n";
    for (var i in unresolved)
      msg += unresolved[i] + ", ";
    alert(msg);
  }
}

//////////////////////////////////////////////////////////////////////////
// Internal functions

// Clear the skill table.
function _skillClear()
{
  var rows = document.getElementById("skills").rows;
  for (var i = 2; i < rows.length - 1; i++)
  {
    rows[i].cells[0].firstChild.value = '';
    rows[i].cells[1].firstChild.value = '';
    rows[i].cells[2].firstChild.checked = '';
    rows[i].cells[3].firstChild.value = '';
    rows[i].cells[5].firstChild.value = '';
    rows[i].cells[7].firstChild.value = '';
    rows[i].cells[9].firstChild.value = '';
  }

  debug.trace("Cleared all skills.");
}

// Fill the skill table with the 3.5E skillset.
function _skillFill()
{
  var row = 2;
  var skilltable = document.getElementById("skills");
  for (var skill in classSkills)
  {
    // Don't actually print out the language skill.
    if (skill == 'Speak Language')
      continue;

    // Don't continue if we're out of skill slots.
    if (row > skilltable.rows - 1)
      break;

    // Don't alter if we already have some data.
    // (Can happen from an legacy character on first load).
    if (skilltable.rows[row].cells[0].firstChild.value)
      continue;

    // Set the skill and the key ability.
    skilltable.rows[row].cells[0].firstChild.value = skill;
    SkillLookUp(skilltable.rows[row].cells[0].firstChild);
    row++;
  }
}

// void _calcSkills(ability)
// Resets the ability modifier and recalculates the skills whose key
// ability match skillname.
function _calcSkills(ability)
{
  var numskills = document.getElementById("skills").rows.length - 3;
  for (var i = 1; i <= numskills; i++)
  {
    var num = FormatNumber(i);
    if (String(sheet()["Skill" + num + "Ab"].value).toLowerCase() == ability)
      SkillLookUpKeyAb(sheet()["Skill" + num + "Ab"]);
  }
}
