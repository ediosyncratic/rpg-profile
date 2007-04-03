// sheet.js

var m_names = new Array("January", "February", "March",
"April", "May", "June", "July", "August", "September",
"October", "November", "December");

// Initialization and cleanup functions for the character sheet.
function init() {
    RefreshPic();

    updateAttributes();
    updateLife();
    updateMovement();

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
  ToggleDisplay("background", sheet()["BackgroundDisp"]);
  ToggleDisplay("notes", sheet()["NotesDisp"]);
}

