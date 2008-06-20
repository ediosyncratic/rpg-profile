// Autofill Life Points and Initiative attributes
function updateAbility(node) {
    var ability = node.name;	
	var modifier = _calcMod(node.value);
	
    var levelBonus = _getLevelBonus();
    var bonus = Add(modifier, levelBonus);
    if (bonus > 0) {
        bonus = "+" + bonus;
    }


    sheet()[ability + "Modifier"].value = modifier;
    sheet()[ability + "Bonus"].value = bonus;
}

function _getLevelBonus() {
    var levelNode = sheet().Level;
    var level = parseInt(levelNode.value);
    if( isNaN(level) ) {
        level = 1; // Assume level 1 if not defined.
        levelNode.value = 1;
    }
    if( level % 2 == 1 ) {
        level -= 1;
    }
    return level / 2;
}

// string _calcMod(string)
// Returns the modifier for a supplied ability score. The return value is
// a string with a leading "+" sign if the modifier is positive.
function _calcMod(abilityScore)
{
	// Ensure a numeric value.
	var score = parseInt(abilityScore);
	if (isNaN(score)) {
	    return "--";
	}
	
	// Calculate the modifier.
	if ((score % 2) == 1) {
	    score -= 11;
	} else {
	    score -= 10;
	}
	score /= 2;
	
	// Append a "+" sign if positive
	if (score > 0) {
	    score = "+" + score;
	}
	
	// Return the modifier.
	return score;
}


// Check current damage and figure out status.
function updateLife() {
}

// Update Hustle and Run attributes.
function updateMovement() {
  ZeroFill(sheet().Walk);
  //var running = sheet()["AthleticsSpec"+i];
}

function updateSkill(skillName) {

}

function updateAC() {

}

function updateFort() {

}

function updateReflex() { 

}

function updateWill() {

}
