// init.js

// Defines the functions to maintain the initiative table.

// Dependencies:
//    debug.js
//    general.js

// void InitCalc(void)
// Calculates the total initiative.
function InitCalc()
{
  if (disable_autocalc())
    return;

  ZeroFill(sheet().InitDex, sheet().InitMisc);

  sheet().Init.value = Add(sheet().InitDex.value, sheet().InitMisc.value);

  debug.trace("Calculated initiative.");
}
