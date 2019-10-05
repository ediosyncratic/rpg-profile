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

    if( ability == "Dexterity" ) {
        sheet().InitiativeDex.value = Clean(modifier);
        updateInitiative();
    }

    for( obj in skillAbilities ) {
        if( obj.match(/^skill/) ) {
            var skillName = obj.substring(5);
            var skillAbil = skillAbilities[obj];
            if( ability.indexOf(skillAbil) == 0 ) {
                var skillAbilityNode = sheet()[skillName + "SkillAbility"];
                skillAbilityNode.value = Clean(bonus);

                updateSkill(skillName);
            }
        }
    }
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

// Update Hustle and Run attributes.
function updateMovement() {
    var movementTotal = 0;

    movementTotal = Add(movementTotal, GetNum(sheet().MovementBase));
    movementTotal = Add(movementTotal, GetNum(sheet().MovementArmor));
    movementTotal = Add(movementTotal, GetNum(sheet().MovementItem));
    movementTotal = Add(movementTotal, GetNum(sheet().MovementMisc));

    sheet().Movement.value = movementTotal;
}

function updateSkill(skillName) {
    var skillBonusNode = sheet()[skillName + "SkillBonus"];
    var skillAbilityNode = sheet()[skillName + "SkillAbility"];
    var skillTrainedNode = sheet()[skillName + "SkillTrained"];
    var skillPenaltyNode = sheet()[skillName + "SkillPenalty"];
    var skillMiscNode = sheet()[skillName + "SkillMisc"];

    var skillTotal = 0;
    skillTotal = Add(skillTotal, GetNum(skillAbilityNode));
    skillTotal = Add(skillTotal, GetNum(skillTrainedNode));
    skillTotal = Add(skillTotal, GetNum(skillMiscNode));
    if( skillPenaltyNode != undefined ) {
        skillTotal = Add(skillTotal, GetNum(skillPenaltyNode));
    }

    if( skillName == "Insight" ) {
        sheet().SenseInsightBonus.value = skillTotal;
        updateSenses();
    } else if( skillName == "Perception" ) {
        sheet().SensePerceptionBonus.value = skillTotal;
        updateSenses();
    }

    if( skillTotal > 0 ) {
        skillTotal = "+" + skillTotal;
    }

    skillBonusNode.value = skillTotal;
}

function updateAC() {
    var acTotal = 0;

    acTotal = Add(acTotal, GetNum(sheet().ACBase));
    acTotal = Add(acTotal, GetNum(sheet().ACArmor));
    acTotal = Add(acTotal, GetNum(sheet().ACClass));
    acTotal = Add(acTotal, GetNum(sheet().ACFeat));
    acTotal = Add(acTotal, GetNum(sheet().ACEnhance));
    acTotal = Add(acTotal, GetNum(sheet().ACMisc));
    acTotal = Add(acTotal, GetNum(sheet().ACMisc2));

    sheet().AC.value = acTotal;
}

function updateFort() {
    var fortTotal = 0;

    fortTotal = Add(fortTotal, GetNum(sheet().FortBase));
    fortTotal = Add(fortTotal, GetNum(sheet().FortArmor));
    fortTotal = Add(fortTotal, GetNum(sheet().FortClass));
    fortTotal = Add(fortTotal, GetNum(sheet().FortFeat));
    fortTotal = Add(fortTotal, GetNum(sheet().FortEnhance));
    fortTotal = Add(fortTotal, GetNum(sheet().FortMisc));
    fortTotal = Add(fortTotal, GetNum(sheet().FortMisc2));

    sheet().Fort.value = fortTotal;
}

function updateReflex() {
    var reflexTotal = 0;

    reflexTotal = Add(reflexTotal, GetNum(sheet().ReflexBase));
    reflexTotal = Add(reflexTotal, GetNum(sheet().ReflexArmor));
    reflexTotal = Add(reflexTotal, GetNum(sheet().ReflexClass));
    reflexTotal = Add(reflexTotal, GetNum(sheet().ReflexFeat));
    reflexTotal = Add(reflexTotal, GetNum(sheet().ReflexEnhance));
    reflexTotal = Add(reflexTotal, GetNum(sheet().ReflexMisc));
    reflexTotal = Add(reflexTotal, GetNum(sheet().ReflexMisc2));

    sheet().Reflex.value = reflexTotal;
}

function updateWill() {
    var willTotal = 0;

    willTotal = Add(willTotal, GetNum(sheet().WillBase));
    willTotal = Add(willTotal, GetNum(sheet().WillArmor));
    willTotal = Add(willTotal, GetNum(sheet().WillClass));
    willTotal = Add(willTotal, GetNum(sheet().WillFeat));
    willTotal = Add(willTotal, GetNum(sheet().WillEnhance));
    willTotal = Add(willTotal, GetNum(sheet().WillMisc));
    willTotal = Add(willTotal, GetNum(sheet().WillMisc2));

    sheet().Will.value = willTotal;
}

function updateInitiative() {
    var initTotal = 0;

    initTotal = Add(initTotal, GetNum(sheet().InitiativeDex));
    initTotal = Add(initTotal, GetNum(sheet().InitiativeLevel));
    initTotal = Add(initTotal, GetNum(sheet().InitiativeMisc));

    if (initTotal > 0) {
        initTotal = "+" + initTotal;
    }

    sheet().Initiative.value = initTotal;
}

function updateAttack(num) {
    var attackTotal = 0;

    attackTotal = Add(attackTotal, GetNum(sheet()["AttackLevel" + num]));
    attackTotal = Add(attackTotal, GetNum(sheet()["AttackAbility" + num]));
    attackTotal = Add(attackTotal, GetNum(sheet()["AttackClass" + num]));
    attackTotal = Add(attackTotal, GetNum(sheet()["AttackProf" + num]));
    attackTotal = Add(attackTotal, GetNum(sheet()["AttackFeat" + num]));
    attackTotal = Add(attackTotal, GetNum(sheet()["AttackEnhance" + num]));
    attackTotal = Add(attackTotal, GetNum(sheet()["AttackMisc" + num]));

    if (attackTotal > 0) {
        attackTotal = "+" + attackTotal;
    }

    sheet()["Attack" + num].value = attackTotal;
}

function updateDamage(num) {
    var damageTotal = 0;

    damageTotal = Add(damageTotal, GetNum(sheet()["DamageAbility" + num]));
    damageTotal = Add(damageTotal, GetNum(sheet()["DamageFeat" + num]));
    damageTotal = Add(damageTotal, GetNum(sheet()["DamageEnhance" + num]));
    damageTotal = Add(damageTotal, GetNum(sheet()["DamageMisc1" + num]));
    damageTotal = Add(damageTotal, GetNum(sheet()["DamageMisc2" + num]));

    if (damageTotal > 0) {
        damageTotal = "+" + damageTotal;
    }

    sheet()["Damage" + num].value = damageTotal;

}

function updateSenses() {
    var senseInsight = Add(10, GetNum(sheet().SenseInsightBonus));
    var sensePerception = Add(10, GetNum(sheet().SensePerceptionBonus));

    sheet().SenseInsight.value = senseInsight;
    sheet().SensePerception.value = sensePerception;
}

function updateLevel() {
    var bonus = _getLevelBonus();

    sheet().InitiativeLevel.value = bonus;
    updateInitiative();

    updateAbility(sheet().Strength);
    updateAbility(sheet().Constitution);
    updateAbility(sheet().Dexterity);
    updateAbility(sheet().Intelligence);
    updateAbility(sheet().Wisdom);
    updateAbility(sheet().Charisma);

    sheet().ACBase.value = Add(10, bonus);
    sheet().FortBase.value = Add(10, bonus);
    sheet().ReflexBase.value = Add(10, bonus);
    sheet().WillBase.value = Add(10, bonus);

    updateAC();
    updateFort();
    updateReflex();
    updateWill();

    for( var i = 1; i <= 2; i++ ) {
        sheet()["AttackLevel" + i].value = bonus;
        updateAttack(i);
    }

    for( obj in skillAbilities ) {
        if( obj.match(/^skill/) ) {
            var skillName = obj.substring(5);
            updateSkill(skillName);
        }
    }
}

function updateHP() {
    ZeroFill(sheet()["SurgeBonus"]);

    var currentHP = GetNum(sheet().HitPoints);
    var maxHP = GetNum(sheet().MaxHitPoints);
    var bloodiedHP = Math.floor(maxHP / 2);
    var surgeValue = Math.floor(maxHP / 4);
    surgeValue += GetNum(sheet().SurgeBonus);

    sheet().BloodiedHitPoints.value = bloodiedHP;
    sheet().SurgeValue.value = surgeValue;

    if( currentHP <= bloodiedHP ) {
        $('bloodied').style.color = 'red';
    } else {
        $('bloodied').style.color = '#888';
    }
}
