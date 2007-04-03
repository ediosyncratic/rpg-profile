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
  var slots = SkillsCount();
  // Calculate the total ranks.
  for (var i = 1; i <= slots; i++)
  {
    var num = FormatNumber(i);
    total += GetNum(sheet()["Skill" + num + "Rank"])
      * (sheet()["Skill" + num + "CC"].checked ? 1 : 2);
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
    sheet()[skill + "MiscMod"],
    sheet()[skill + "CheckPen"]);

  sheet()[skill + "Mod"].value = Add(
    sheet()[skill + "AbMod"].value,
    sheet()[skill + "Rank"].value,
    sheet()[skill + "MiscMod"].value,
    sheet()[skill + "CheckPen"].value);

  debug.trace("Calculated modifier for "
    + (sheet()[String(node.name).substr(0, 7)].value ? sheet()[String(node.name).substr(0, 7)].value : "[Unnamed Skill]")
    + ".");

  CheckSkillAttribute(sheet()[skill]);
}

// void CheckSkillAttribute
// Looks at a skill name and checks to see if it needs a '*' (requires armor check)
// or '+' (may be used untrained) appended to it
function CheckSkillAttribute( skillNameNode )
{
  var skillName = skillNameNode.value;
  if( skillName.indexOf("*") > 0 ) {
    skillName = skillName.replace("*","");
  }
  if( skillName.indexOf("+") > 0 ) {
    skillName = skillName.replace("+","");
  }
  skillName = skillName.replace( /\s+$/g, "" );
  skillNameNode.value = skillName;

  skillName = skillName.toLowerCase();

  if( skillName.length == 0 ) {
    return;
  }

  if (skillName.indexOf("knowledge") == 0 ) {
    skillName = "knowledge:";
  }

  var skillAttr = skillAttributes[skillName];
  if( skillAttr == null )
    return;

  var skill = skillNameNode.name;

  if( ! skillAttr[0] ) {
    ZeroFill(sheet()[skill + "Rank"]);
    if( sheet()[skill + "Rank"].value == 0 ) {
        skillNameNode.style.textDecoration = "line-through";
    } else {
    skillNameNode.style.textDecoration = "none";
    }
  } else {
    skillNameNode.style.textDecoration = "none";
  }

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

  // Check to see if there is help for this skill.
  CheckForHelp( node.name );

  if (typeof skillKeys[skill] == "undefined")
  {
    debug.trace("No info found for " + skill + ".");
    return;
  }

  CheckSkillAttribute( node );

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
    skillRow.cells[2].firstChild.checked = _getClassBitSet() & classSkills[skillRow.cells[0].firstChild.value] ? "checked" : "";

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
  var rows = SkillsCount();

  // Now copy all the data in each row (the first two are headers and
  // the last is a footer).
  debug.trace("Copying skill data...");
  var rows_c = new Array();
  for (var i = 1; i <= rows; i++)
  {
    var num = FormatNumber(i);

    r = new Object();
    r.skill = sheet()["Skill" + num].value;
    r.ab    = sheet()["Skill" + num + "Ab"].value;
    r.cc    = sheet()["Skill" + num + "CC"].checked;
    r.mod   = sheet()["Skill" + num + "Mod"].value;
    r.abmod = sheet()["Skill" + num + "AbMod"].value;
    r.rank  = sheet()["Skill" + num + "Rank"].value;
    r.misc  = sheet()["Skill" + num + "MiscMod"].value;
    r.checkpen  = sheet()["Skill" + num + "CheckPen"].value;
    rows_c.push(r);
  }

  // Sort the data.
  debug.trace("Sorting skill data...");
  rows_c.sort(sortfunc);

  // Now, restore the sorted data.
  debug.trace("Copying sorted skill data...");
  for (var i = 1; i <= rows; i++)
  {
    var num = FormatNumber(i);
    var r = rows_c.shift();

    sheet()["Skill" + num].value             = r.skill;
    sheet()["Skill" + num].style.textDecoration = "none";
    sheet()["Skill" + num + "Ab"].value      = r.ab;
    sheet()["Skill" + num + "CC"].checked    = r.cc;               
    sheet()["Skill" + num + "Mod"].value     = r.mod;
    sheet()["Skill" + num + "AbMod"].value   = r.abmod;
    sheet()["Skill" + num + "Rank"].value    = r.rank;
    sheet()["Skill" + num + "MiscMod"].value = r.misc;
    sheet()["Skill" + num + "CheckPen"].value = r.checkpen;
    CheckSkillAttribute(sheet()["Skill" + num]);
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

function SkillsUpdateCheckPen() {
  var penalty = 0;
  
  for (var i = 1; i <= 4; i++) {
    if( sheet()["Armor" + i + "Worn"].checked ) {
    penalty = Add(penalty, sheet()["Armor" + i + "Check"].value);
    }
  }

  var weightPenalty = 0;
  if( parseFloat(sheet()["TotalWeight"].value) > parseFloat(sheet()["MediumLoad"].value) ) {
    weightPenalty = -6;
  } else if( parseFloat(sheet()["TotalWeight"].value) > parseFloat(sheet()["LightLoad"].value) ) {
    weightPenalty = -3;
  }
  if( weightPenalty < penalty ) {
    penalty = weightPenalty;
  }


  for (var i = 1; i <= SkillsCount(); i++) {
    var num = FormatNumber(i);
    var skill_name = sheet()["Skill" + num].value.toLowerCase();
    if (skill_name.length == 0)
      continue;

    var skill_pen = sheet()["Skill" + num + "CheckPen"];

    var skillAttr = skillAttributes[skill_name];
    if( skillAttr == null ) {
      skill_pen.value = 0;
      continue;
    }

    if( skillAttr[1] ) {
    if( skill_name == "swim" ) {
      skill_pen.value = 2 * penalty
    } else {
      skill_pen.value = penalty;
    }
    } else {
    skill_pen.value = 0;
    }

    SkillCalc(sheet()["Skill" + num]);
  }
  
  
}

// Update the cross-class checkboxes according to the class information.
function SkillsUpdateCC()
{
  if (!confirm("UpdateCC will compare your skills against the classes the your character has been assigned and determine if each skill is a class skill or not. This method will usually only work for skills that have been assigned via AutoFill and for the core 3.5E classes...\n\nDo you wish to continue?"))
    return;

  // Create a shortcut to the rows of the skills table.
  var classes = _getClassBitSet();
  var unresolved = new Array();
  for (var i = 1; i <= SkillsCount(); i++)
  {
    var num = FormatNumber(i);

    debug.trace(" Skill = Skill" + num );
    debug.trace(" Skillname = " + sheet()["Skill" + num].value );
    var skill_name = sheet()["Skill" + num].value;
    if (skill_name.length == 0)
      continue;

    var skill_cc   = sheet()["Skill" + num + "CC"];

    if (classSkills[skill_name])
      skill_cc.checked = classes & classSkills[skill_name] ? "checked" : "";
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

/*

This function looks through the URL table looking for a member who's name
matches 'name'.  Matching means that it starts with the same letters.

For example, if name = "Ability: Favored enemy - orc" then it will match with
"Ability: Favored enemy".

If a match wasn't found, returns "".

*/
function _RetrieveMatchingURL( name, helpTable )
{
  name = Trim( name.toLowerCase() );

  // Remove any possible keyword text.
  if ( name.indexOf( "feat:" ) == 0 )
    name = Trim( name.substring( 6 ) );
  else
  if ( name.indexOf( "ability:" ) == 0 )
    name = Trim( name.substring( 9 ) );

  // Loop through each of the members in skillsHelpURL.
  for ( URL in helpTable )
  {
    // If the URL member name starts with the same chars as name, then it matches.
     if ( name.indexOf( URL ) == 0 )
     {
       return helpTable[ URL ];
     }
  }

  // If we get here we didn't find a match.
  return "";
}

// Pops up a new window displaying help for a skill.  'node' is the name of the
// input element that contains the name of the skill.
function ShowHelp(node)
{
  var skillName = document.getElementsByName(node)[0].value;
  var URL;

  URL = _RetrieveMatchingURL( skillName, skillsHelpURL )

  // Check to see if a matching skill was found.
  if ( URL == "" )
    return;

  window.open( URL );
  return;
}

/*

    Checks to see if a skill has a help URL associated with it.  If it does
    then the "help" link will be set to a '?'.  If there is no URL, then the
    link is set to a null string, basically hiding it.

    'node' is the name of the input field containing the skill text.

*/
function CheckForHelp(node)
{
  var skillName = document.getElementsByName(node)[0].value;
  var link      = document.getElementsByName(node + "Link")[ 0 ];

  if ( _RetrieveMatchingURL( skillName, skillsHelpURL ) != "" )
  {
    link.innerHTML = "?";
  }
  else
  {
    link.innerHTML = "";
  }

  return;
}


//////////////////////////////////////////////////////////////////////////
// Internal functions

// Clear the skill table.
function _skillClear()
{
  var slots = SkillsCount();
  // Calculate the total ranks.
  for (var i = 1; i <= slots; i++)
  {
    var num = FormatNumber(i);
    sheet()["Skill" + num].value             = '';
    sheet()["Skill" + num + "Ab"].value      = '';
    sheet()["Skill" + num + "CC"].value      = '';
    sheet()["Skill" + num + "Mod"].value     = '';
    sheet()["Skill" + num + "AbMod"].value   = '';
    sheet()["Skill" + num + "Rank"].value    = '';
    sheet()["Skill" + num + "MiscMod"].value = '';
  }

  debug.trace("Cleared all skills.");
}

// Fill the skill table with the 3.5E skillset.
function _skillFill()
{
  var row = 1;
  var skilltable = document.getElementById("skills");
  for (var skill in classSkills)
  {
    // Don't actually print out the language skill.
    if (skill == 'Speak Language')
      continue;

    // Don't continue if we're out of skill slots.
    if (row > skilltable.rows)
      break;

    var skillNum = "Skill" + FormatNumber(row);
    row++;

    // Don't alter if we already have some data.
    // (Can happen from an legacy character on first load).
    if (sheet()[ skillNum ].value)
      continue;

    // Set the skill and the key ability.
    sheet()[ skillNum ].value = skill;
     //CheckSkillAttribute( sheet()[ skillNum ] )
    SkillLookUp( sheet()[ skillNum ] );
  } // for...
}

// void _calcSkills(ability)
// Resets the ability modifier and recalculates the skills whose key
// ability match skillname.
function _calcSkills(ability)
{
  var numskills = SkillsCount();
  for (var i = 1; i <= numskills; i++)
  {
    var num = FormatNumber(i);
    if (String(sheet()["Skill" + num + "Ab"].value).toLowerCase() == ability)
      SkillLookUpKeyAb(sheet()["Skill" + num + "Ab"]);
  }
}
