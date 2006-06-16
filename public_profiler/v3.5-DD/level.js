// level.js

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

// Maintains level dependent fields.

// Dependencies:
//     general.js

// Updates all level dependencies.
function OnLevelChanged()
{
  // All we need to do is update the max ranks for the skills.

  if (disable_autocalc())
    return;

  // Determine the toal level of the character.
  var levels = sheet().Level.value.split("/");
  var totalLevel = 0;
  for (var i in levels)
    totalLevel += isNaN(parseInt(levels[i])) ? 0 : parseInt(levels[i]);
  if (!totalLevel)
    return;

  sheet().MaxRank.value = totalLevel + 3;
  sheet().MaxRankCC.value = (totalLevel + 3) / 2;

  debug.trace("Calculated max ranks.");
}