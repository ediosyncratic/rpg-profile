// saves.js

// Functions used for maintaining the saving throws table.

// Dependencies:
//    debug.js
//    general.js

// void SaveCalc(string)
// Calculates the saving throw based off the passed string.
function SaveCalc(save)
{
  if (disable_autocalc())
    return;

  ZeroFill(
    sheet()[save + "Base"],
    sheet()[save + "Ability"],
    sheet()[save + "Magic"],
    sheet()[save + "Misc"],
    sheet()[save + "Temp"]);

  sheet()[save].value = Add(
    sheet()[save + "Base"].value,
    sheet()[save + "Ability"].value,
    sheet()[save + "Magic"].value,
    sheet()[save + "Misc"].value,
    sheet()[save + "Temp"].value);

  debug.trace("Calculated " + save + " save.");
}