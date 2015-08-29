// sheet.js

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
  // Calculate off-character container totals
  ContainerWeight("Cont01");
  ContainerWeight("Cont02");
  ContainerWeight("Cont03");

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

  // Set the link for the spells.
  for (var i = 1; i <= 300; i++)
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

  for (var i = 0; i < child_windows.length; ++i)
    child_windows[i].close();
}

function SetSaveDate()
{
  var now = new Date();
  sheet().LastSaveDate.value =  now.getDate() + " " + m_names[now.getMonth()] + " " + now.getFullYear() + " " +
                now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
}

function Save() {
    $('processing').setStyle({display:'block'});
    $('charactersheet').request({
        method: 'post',
        onComplete: function(transport) {
            $('processing').setStyle({display:'none'});
            if( transport.responseText == 'SUCCESS' ) { 
                alert('Character saved!');
            } else {
                alert('Error: ' + transport.responseText);
            }
        }
    });
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
  ToggleDisplay("containers", sheet()["ContainerDisp"]);
}

