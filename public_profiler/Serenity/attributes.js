// Autofill Life Points and Initiative attributes
function updateAttributes() {
  ZeroFill(sheet().Agility);
  ZeroFill(sheet().Alertness);
  ZeroFill(sheet().Vitality);
  ZeroFill(sheet().Willpower);
  ZeroFill(sheet().Strength);
  ZeroFill(sheet().Intelligence);  

  sheet().Initiative1.value = sheet().Agility.value;
  sheet().Initiative2.value = sheet().Alertness.value;
 
//  sheet().LifePoints.value = Add(sheet().Vitality.value, sheet().Willpower.value);

  // See if life stuff needs to change
  updateLife();
}

// Check current damage and figure out status.
function updateLife() {

  ZeroFill(sheet().LifePoints);
  ZeroFill(sheet().Stun);
  ZeroFill(sheet().Wound);
  ZeroFill(sheet().Shock);

  var status = "Dandy";

  var wounds = GetNum(sheet().Wound);
  var stun = GetNum(sheet().Stun) + wounds;
  var shock = GetNum(sheet().Shock);
  var lifePoints = GetNum(sheet().LifePoints);

  //alert("L:" + lifePoints + ", ST:" + stun + ", SH:" + shock + ", W:" + wounds);
 
  if( wounds >= lifePoints ) {
    status = "<font color='red'>Dyin'</font>";
  } else if( shock >= lifePoints ) {
    status = "<font color='red'><b>Comatose</b></font>";
  } else if( stun >= lifePoints ) {
    status = "<font color='red'>KO'd</font>";
  }

  if( wounds >= Math.floor(lifePoints / 2) ) {
    if( status == "Dandy") {
      status = "Hurtin'";
    }
    status += "<br><font color='red'><b>-2 Step Pen</b></font>";
  }

  GetObject('status').innerHTML = status;  
}

// Update Hustle and Run attributes.
function updateMovement() {
  ZeroFill(sheet().Walk);

  var athletics = GetNum(sheet().AthleticsDice);

  var walk = GetNum(sheet().Walk);
  var hustle = walk * 2;
  var run = hustle;

  for( var i = 1; i <= 10; i++ ) {
    var running = sheet()["AthleticsSpec"+i];
    if( running == null ) {
      break;
    }
    if( running.value == "Running" ) {
      athletics = GetNum(sheet()["AthleticsSpecDice"+i]);
      break;
    } 
  }
  
  if( athletics > 0 ) {
    run += "+d" + athletics;
  }
  run += "+Attr";

  sheet().Hustle.value = hustle;
  sheet().Run.value = run;

}
