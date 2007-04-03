// capacity.js

// Defines functions used to maintain the (carrying) capacity table. See
// also ./ogl/capacity.js for data used by these functions.

// Dependencies:
//    ogl/capacity.js
//    debug.js
//    general.js

// void SetLoads(void)
// Sets the carying capacity inputs.
function SetLoads()
{
  if (disable_autocalc())
    return;

  // Determine which strength score to use.
  var str = (String(sheet().StrTemp.value).length > 0)
    ? GetNum(sheet().StrTemp)
    : GetNum(sheet().Str);

  // Calculate the multipler.

  // Scale the multiplier for strength scores above 29
  var multiplier = 1;
  while (str > 29)
  {
    str -= 10;
    multiplier *= 4;
  }

  // Scale the multiplier for size.
  var size = sheet().Size.value.charAt(0).toLowerCase();
  if (typeof sizeMultipliers[size] == "undefined")
    debug.trace("Unknown size found, assuming Medium.");
  else
    multiplier *= sizeMultipliers[size];

  sheet().LightLoad.value = loadLight[str] * multiplier;
  sheet().MediumLoad.value = loadMedium[str] * multiplier;
  sheet().HeavyLoad.value = loadHeavy[str] * multiplier;
  sheet().LiftOverHead.value = loadHeavy[str] * multiplier;
  sheet().LiftOffGround.value = loadHeavy[str] * multiplier * 2;
  sheet().LiftPushDrag.value = loadHeavy[str] * multiplier * 5;

  debug.trace("Set the carrying capacities.");
}
