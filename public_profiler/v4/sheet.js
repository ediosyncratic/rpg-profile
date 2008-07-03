// sheet.js

var m_names = new Array("January", "February", "March","April", "May", "June", "July", "August", "September","October", "November", "December");

// Initialization and cleanup functions for the character sheet.
function init() {
    RefreshPic();

    CheckDisplay();
}

function cleanup() {

}

function SetSaveDate() {
	var now = new Date();
	sheet().LastSaveDate.value =  now.getDate() + " " + m_names[now.getMonth()] + " " + now.getFullYear() + " " +
	                              now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
}

function Save() {
    document.getElementById('processing').style.display = 'block';
	$('charactersheet').request({
	    method: 'post',
        onComplete: function(transport) {
            document.getElementById('processing').style.display = 'none';
            if( transport.responseText == 'SUCCESS' ) { 
                alert('Character saved!');
            } else {
                alert('Error: ' + transport.responseText);
            }
        }
	});
}

function CheckDisplay() {
    ToggleDisplay("notes", sheet()["NotesDisp"]);
}

