// size.js

// Global event handler for handling size changes.

// Dependencies:
//    capacity.js
//    ogl/capacity.js
//    ab.js

function OnSizeChanged()
{
  if (disable_autocalc())
    return;

  // Update the capacity inputs.
  SetLoads();

  // Update the AC inputs.
  sizeMod = Clean(sizeModifiers[sheet().Size.value.charAt(0).toLowerCase()]);
  sheet().ACSize.value = sizeMod;
  ACCalc();

  // Update the BAB inputs.
  sheet().MABSize.value = sizeMod;
  MBABCalc();
  sheet().RABSize.value = sizeMod;
  RBABCalc();
}
