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
function SetBAB(node)
{
  if (node.name = "MABBase")
  {
    sheet().RABBase.value = node.value;
    debug.trace("Copied BAB to the Ranged BAB input.");
    RBABCalc();
  }
  else if (node.name == "RABBase")
  {
    sheet().MABBase.value = node.value;
    debug.trace("Copied BAB to Melee BAB input.");
    MBABCalc();
  }
  else
    debug.traceErr("Incorrect node passed to <code>SetBAB</code>");
}