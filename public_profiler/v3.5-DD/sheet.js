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

var m_names = new Array("January", "February", "March", 
"April", "May", "June", "July", "August", "September", 
"October", "November", "December");

// int SkillCount(void)
// Returns the number of skills listed in the Skills table.
function SkillsCount()
{
	return document.getElementById("skills").rows.length - 6;
}

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
    for(var weap = 1; weap <= 4; weap++) {
      sheet()["Wep" + weap + "Disp"].checked=true;
    }
    for(var arm = 1; arm <= 4; arm++) {
      sheet()["Arm" + arm + "Disp"].checked=true;
    }
    sheet()["MagicDisp"].checked=true;
  }

  CheckDisplay(); 

  // Set the link for the skills.
  var slots = SkillsCount();
  for (var i = 1; i <= slots; i++)
  {
    var num = FormatNumber(i);
	 CheckForHelp( "Skill" + num );

	CheckSkillAttribute( sheet()[ "Skill" + num ] );
  }

  // Set the link for the feats and special abilities.
  for (var i = 1; i <= 30; i++)
  {
    var num = FormatNumber(i);
	 CheckForHelp( "Feat" + num );
  }

  // Set the link for the feats and special abilities.
  for (var i = 1; i <= 60; i++)
  {
    var num = FormatNumber(i);
	 CheckForSpellHelp( "Spell" + num );
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

function SetSaveDate()
{
  var now = new Date();
  sheet().LastSaveDate.value =  now.getDate() + " " + m_names[now.getMonth()] + " " + now.getFullYear() + " " +
  				now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
}

function CheckDisplay() {
  for(var i = 1; i <= 4; i++) {
    var obj = sheet()["Wep" + i + "Disp"];
    ToggleDisplay("we" + i, obj);
  }
  for(var i = 1; i <= 4; i++) {
    var obj = sheet()["Arm" + i + "Disp"];
    ToggleDisplay("ar" + i, obj);
  }
  ToggleDisplay("magic", sheet()["MagicDisp"]);
}

