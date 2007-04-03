// abilities.js

// Maintains the ability scores.

// Dependencies:
//    everytning...almost

// void OnAbilityChanged(node)
// Called by the document when an ability score is changed.
function OnAbilityChanged(node)
{
  if (disable_autocalc())
    return;

  // If the score was deleted, delete the modifier...
  if (String(node.value).length == 0)
  {
    sheet()[node.name + "Mod"].value = "";
    debug.trace("Cleared the " + node.name + " modifier.");
  }
  // ...otherwise calculate the modifier.
  else
  {
    sheet()[node.name + "Mod"].value = _calcMod(sheet()[node.name].value);
    debug.trace("Set the " + node.name + " modifier.");
  }

  // Attempt to call the ability's apply method (extract the ability
  // name from the first three characters of the node name.
  _applyAbility(node.name);
}

//////////////////////////////////////////////////////////////////////////
// Internal functions

// void _applyAbility(string)
// Applies an ability modifier to all dependent objects.
function _applyAbility(nodename)
{
  // Determine the name of the ability we're working with.
  var ability = String(nodename).substr(0, 3);

  // Are we dealing with a temp ability?
  var isTemp = String(nodename).length > 3 ? true : false;

  // Now cascade through the sheet with the proper modifiers.
  if (isTemp)
  {
    // Determine which value we'll be applying (apply the normal mod if
    // the temp mod was cleared).
    var val = String(sheet()[ability + "TempMod"].value).length > 0
      ? sheet()[ability + "TempMod"].value
      : sheet()[ability + "Mod"].value;
    // Attempt to update the dependencies.
    eval("_calcDep" + ability + "('" + val + "')");
  }
  else
  {
    // Only apply the change if a temp mod does not exist.
    if (String(sheet()[ability + "TempMod"].value).length > 0)
      debug.trace(ability + "Temp exists: ignoring changes to " + ability + ".");
    else
      eval("_calcDep" + ability + "('" + sheet()[ability + "Mod"].value + "')");
  }
}

// void _calcDepStr(string)
// Calculates the strength dependencies, using the supplied modifier
// to fill in any slots that use a strength modifier.
function _calcDepStr(mod)
{
  debug.trace("Updating all Str dependencies...");

  // Remove the leading "+" if it exists.
  mod = Clean(mod);

  // The melee attack bonus.
  sheet().MABStr.value = mod;
  MBABCalc();

  // The carrying capacities.
  SetLoads();

  // Update the skills.
  _calcSkills('str');
}

// void _calcDepDex(string)
// Calculate the dexterity dependencies, using the supplied modifier
// to fill in any slots that use a dexterity modifier.
function _calcDepDex(mod)
{
  debug.trace("Updating all Dex dependencies...");

  // Remove the leading "+" from the mod if it exists.
  mod = Clean(mod);

  // The ranged attack bonus.
  sheet().RABDex.value = mod;
  RBABCalc();

  // The reflex save.
  sheet().ReflexAbility.value = mod;
  SaveCalc('Reflex');

  // The initiative.
  sheet().InitDex.value = mod;
  InitCalc();

  sheet().ACDex.value = mod;
  ACCalc();

  // Update the skills.
  _calcSkills('dex');
}

// void _calcDepCon(string)
// Calculate the constitution dependencies, using the supplied modifier
// to fill in any slots that use a constitution modifier.
function _calcDepCon(mod)
{
  debug.trace("Updating all Con dependencies...");

  mod = Clean(mod);

  //The fortitude save.
  sheet().FortAbility.value = mod;
  SaveCalc('Fort');

  // Update the skills.
  _calcSkills('con');
}

// void _calcDepInt(string)
// Calculate the intelligence dependencies, using the supplied modifier
// to fill in any slots that use an intelligence modifier.
function _calcDepInt(mod)
{
  debug.trace("Updating all Int dependencies...");

  // Update the skills.
  _calcSkills('int');
}

// void _calcDepWis(string)
// Calculate the wisdom dependencies, using the supplied modifier
// to fill in any slots that use a wisdom modifier.
function _calcDepWis(mod)
{
  debug.trace("Updating all Wis dependencies...");

  mod = Clean(mod);

  // The will save.
  sheet().WillAbility.value = mod;
  SaveCalc('Will');

  // Update the skills
  _calcSkills('wis');
}

// void _calcDepCha(string)
// Calculate the charisma dependencies, using the supplied modifier
// to fill in any slots that use a charisma modifier.
function _calcDepCha(mod)
{
  debug.trace("Updating all Cha dependencies...");

  //Update the skills
  _calcSkills('cha');
}

// string _calcMod(string)
// Returns the modifier for a supplied ability score. The return value is
// a string with a leading "+" sign if the modifier is positive.
function _calcMod(abilityScore)
{
  // Ensure a numeric value.
  var score = parseInt(abilityScore);
  if (isNaN(score))
    return "--";

  // Calculate the modifier.
  if ((score % 2) == 1)
    score -= 11;
  else
    score -= 10;
  score /= 2;

  // Append a "+" sign if positive
  if (score > 0)
    score = "+" + score;

  // Return the modifier.
  return score;
}

// bool _isTempAbility(node)
// Returns true if the supplied node is a temporary ability score.
function _isTempAbility(node)
{
  var names = new Array("Str", "Dex", "Con", "Int", "Wis", "Cha");
  for (var i in names)
    if (node.name == names[i])
      return false;
  return true;
}
