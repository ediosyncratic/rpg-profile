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

var m_names = new Array("January", "February", "March",
"April", "May", "June", "July", "August", "September",
"October", "November", "December");

// Initialization and cleanup functions for the character sheet.
function init() {
    RefreshPic();

    if (sheet().firstload.value == "true") {
        sheet().firstload.value = "false";
        //_skillFill();
        
        for(var weap = 1; weap <= 4; weap++) {
            sheet()["Wep" + weap + "Disp"].checked=true;
        }
        for(var arm = 1; arm <= 4; arm++) {
            sheet()["Arm" + arm + "Disp"].checked=true;
        }
        sheet()["NotesDisp"].checked=true;
        sheet()["BackgroundDisp"].checked=true;
    }

    CheckDisplay();
}

function cleanup() {

}

function SetSaveDate()
{
  var now = new Date();
  sheet().LastSaveDate.value =  now.getDate() + " " + m_names[now.getMonth()] + " " + now.getFullYear() + " " +
                                now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();

}

function CheckDisplay() {
  for(var i = 1; i <= 4; i++) {
    ToggleDisplay("weapon" + i, sheet()["Wep" + i + "Disp"]);
    ToggleDisplay("armor" + i, sheet()["Arm" + i + "Disp"]);
  }
  ToggleDisplay("notes", sheet()["NotesDisp"]);
  ToggleDisplay("background", sheet()["BackgroundDisp"]);
}

