// sheet.js

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

