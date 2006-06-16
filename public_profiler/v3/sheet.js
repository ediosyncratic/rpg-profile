// sheet.js

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

// Initialization and cleanup functions for the character sheet.

// Dependencies:
//    (alot...)

// void init(void)
// Called to initialize the document as the body.onload handler.
function init()
{
  // Do total calculations for the skill and weight tables.
  SkillCalcRanks();
  CalcWeight();

  if (sheet().firstload.value == "true")
  {
    sheet().firstload.value = "false";
    _skillFill();
  }

  RefreshPic();
}

// void cleanup(void)
// Called to clean up from the body.onunload handler.
function cleanup()
{
  debug.close();

  for (var i in child_windows)
    child_windows[i].close();
}
