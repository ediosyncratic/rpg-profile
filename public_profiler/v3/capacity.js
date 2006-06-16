// capacity.js

// 3EProfiler (tm) character sheet source file.
// Copyright (C) 2003  Michael J. Eggertson.
// 
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

// **

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
