// xp.js

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

// Handles changes of XP.

// Dependencies:
//    general.js

// Event handler for changing the XP Change.
// The function reads the change in XP, then applies it to the current
// XP slot, also verifing if the next level XP should change.
function ApplyXPChange()
{
  if (disable_autocalc())
    return;

  // Ensure we have a value to change.
  if (!sheet().XPChange.value.length)
    return;

  // Parse the proper values from the sheet.
  var change = parseInt(sheet().XPChange.value);
  if (isNaN(change))
    return;

  var current = parseInt(sheet().XPCurrent.value);
  if (isNaN(current))
    current = 0;

  var updated = current + change;

  // Set the sheet.
  sheet().XPCurrent.value = updated;
  sheet().XPNext.value = _XPForNextLevel(updated);

  debug.trace("Calculated total XP.");
  debug.trace("Calculated next level XP.");
}

// Sets the next level XP if the current XP is edited directly.
function ApplyXPNext()
{
  if (disable_autocalc())
    return;

  // Parse the proper values from the sheet.
  if (!sheet().XPCurrent.value.length)
    return;

  var updated = parseInt(sheet().XPCurrent.value);
  if (isNaN(updated))
    return;

  // Update the sheet.
  sheet().XPNext.value = _XPForNextLevel(updated);
}

// Calculates the XP for the next level, based on the current XP.
function _XPForNextLevel(currentXP)
{
  // Sanity check.
  if (typeof currentXP != "number")
    return "?";

  var level = 0;
  var nextLevelXP = 0;
  while (currentXP >= nextLevelXP)
    nextLevelXP += level++ * 1000;
  return nextLevelXP;
}
