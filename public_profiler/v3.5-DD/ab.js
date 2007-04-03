// ab.js

// Implements functions used for maintining the attack bonus table.

// Dependencies:
//    debug.js
//    general.js

// void MBABCalc(void)
// Calculates the melee attack bonus.
function MBABCalc()
{
  if (disable_autocalc())
    return;

  ZeroFill(
    sheet().MABBase,
    sheet().MABStr,
    sheet().MABSize,
    sheet().MABMisc,
    sheet().MABTemp);

  sheet().MBAB.value = ParsedAdd(
    sheet().MABBase.value,
    sheet().MABStr.value,
    sheet().MABSize.value,
    sheet().MABMisc.value,
    sheet().MABTemp.value);

  debug.trace("Calculated melee base attack bonus.");
}

// void GBABCalc(void)
// Calculates the grapple attack bonus.
function GBABCalc()
{
  if (disable_autocalc())
    return;

  ZeroFill(
    sheet().GABBase,
    sheet().GABStr,
    sheet().GABSize,
    sheet().GABMisc,
    sheet().GABTemp);

  sheet().GBAB.value = ParsedAdd(
    sheet().GABBase.value,
    sheet().GABStr.value,
    sheet().GABSize.value,
    sheet().GABMisc.value,
    sheet().GABTemp.value);

  debug.trace("Calculated grapple base attack bonus.");
}

// string ParsedAdd(string, ...)
// Parses the first string for multiple attack ratings, splitting it on
// each "/". Each attack fetched from this string is then parsed for an
// integer, which is summed with all consectutive inputs which are also
// scanned for integers.
function ParsedAdd(attackBase)
{
  var attackBases = attackBase.split("/");

  var attackBonuses = new Array();
  for (var i in attackBases)
  {
    var addString = "\"" + attackBases[i] + "\"";
    for (var j = 1; j < arguments.length; j++)
      addString += (", \"" + arguments[j] + "\"");
    eval("attackBonuses[i] = Add(" + addString+ ");");
  }

  return attackBonuses.join("/");
}

// void RBABCalc(void)
// Calculates the ranged attack bonus.
function RBABCalc()
{
  if (disable_autocalc())
    return;

  ZeroFill(
    sheet().RABBase,
    sheet().RABDex,
    sheet().RABSize,
    sheet().RABMisc,
    sheet().RABTemp);

  sheet().RBAB.value = ParsedAdd(
    sheet().RABBase.value,
    sheet().RABDex.value,
    sheet().RABSize.value,
    sheet().RABMisc.value,
    sheet().RABTemp.value);

  debug.trace("Calculated ranged base attack bonus.");
}

// void SetBAB(node)
// Sets the MABBase input if the node passed is the RABBase input, or
// vice versa, then trigger the other inputs onchange event.
//
// Now handles GABBase as well.
function SetBAB(node)
{
  if (node.name = "MABBase")
  {
    sheet().RABBase.value = node.value;
    sheet().GABBase.value = node.value;
    debug.trace("Copied BAB to the Grapple/Ranged BAB input.");
    RBABCalc();
    GBABCalc();
  }
  else if (node.name == "GABBase")
  {
    sheet().MABBase.value = node.value;
    sheet().RABBase.value = node.value;
    debug.trace("Copied BAB to Melee/Range BAB input.");
    MBABCalc();
    RBABCalc();
  }
  else if (node.name == "RABBase")
  {
    sheet().MABBase.value = node.value;
    sheet().GABBase.value = node.value;
    debug.trace("Copied BAB to Melee/Grapple BAB input.");
    MBABCalc();
    GBABCalc();
  }
  else
    debug.traceErr("Incorrect node passed to <code>SetBAB</code>");
}
