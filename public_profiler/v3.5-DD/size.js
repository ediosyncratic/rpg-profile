// size.js

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
  sheet().GABSize.value = Clean(grappleSizeModifiers[sheet().Size.value.charAt(0).toLowerCase()]);
  GBABCalc();

}
