// Autofill Life Points and Initiative attributes
function updateAttribute(node) {
    // If the score was deleted, delete the modifier...
    if (String(node.value).length == 0) {
        sheet()[node.name + "Mod"].value = "";
    } else {
        sheet()[node.name + "Mod"].value = calculateMod(sheet()[node.name].value);
    }
    
    applyAbility(node.name);
}

function calculateMod(abilityScore) {
  // Ensure a numeric value.
  var score = parseInt(abilityScore);
  if (isNaN(score))
    return "--";

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

function applyAbility(nodename) {
  // Determine the name of the ability we're working with.
  var ability = String(nodename).substr(0, 3);

  // Are we dealing with a temp ability?
  var isTemp = String(nodename).length > 3 ? true : false;

  // Now cascade through the sheet with the proper modifiers.
  if (isTemp) {
    // Determine which value we'll be applying (apply the normal mod if
    // the temp mod was cleared).
    var val = String(sheet()[ability + "TempMod"].value).length > 0
              ? sheet()[ability + "TempMod"].value
              : sheet()[ability + "Mod"].value;
    // Attempt to update the dependencies.
    eval("update" + ability + "('" + Clean(val) + "')");
  } else {
    // Only apply the change if a temp mod does not exist.
    if (String(sheet()[ability + "TempMod"].value).length > 0) {
      debug.trace(ability + "Temp exists: ignoring changes to " + ability + ".");
    } else {
      eval("update" + ability + "('" + Clean(sheet()[ability + "Mod"].value) + "')");
    }
  }

  updateSkills(ability);
}

function getAbilityMod(name) {
    var ability = name.substr(0,3).toLowerCase();
    ability = name.substr(0,1).toUpperCase() + name.substr(1,2);
    
    var val = String(sheet()[ability + "TempMod"].value).length > 0
                     ? sheet()[ability + "TempMod"].value
                     : sheet()[ability + "Mod"].value;
    
    return Clean(val);
}

function updateStr(val) {
    sheet().MeleeStrength.value = val;
    
    updateMeleeAttack();
}

function updateDex(val) {
    sheet().RangedDexterity.value = val;
    sheet().InitDex.value = val;
    sheet().DefenseDexterity.value = val;
    sheet().ReflexAbility.value = val;
    
    updateDefense();
    updateInitiative();
    updateRangedAttack();
    updateReflexSave();
}

function updateCon(val) {
    sheet().FortAbility.value = val;
    
    updateFortitudeSave();
}

function updateInt(val) {
	sheet().EducationAbility.value = val;

	updateEducation();
}

function updateWis(val) {
    sheet().WillAbility.value = val;
    sheet().InspirationAbility.value = val;

    updateWillSave();
    updateInspiration();
}

function updateCha(val) {

}