function updateDefense() {
    ZeroFill(sheet().DefenseClass,
             sheet().DefenseDexterity,
             sheet().DefenseSize,
             sheet().DefenseMisc);
             
    sheet().Defense.value = Clean(Add(
        10,
        sheet().DefenseClass.value,
        sheet().DefenseDexterity.value,
        sheet().DefenseSize.value,
        sheet().DefenseMisc.value));
}

function updateInitiative() {
    ZeroFill(sheet().InitDex,
             sheet().InitMisc);
             
    sheet().Init.value = Clean(Add(
             sheet().InitDex.value,
             sheet().InitMisc.value));
}

function updateBaseAttack() {
    ZeroFill(sheet().BaseAttack);
    
    sheet().MeleeBase.value =  sheet().BaseAttack.value;
    sheet().RangedBase.value = sheet().BaseAttack.value;
    
    updateMeleeAttack();
    updateRangedAttack();
    
}

function updateMeleeAttack() {
    ZeroFill(sheet().MeleeBase,
             sheet().MeleeStrength,
             sheet().MeleeSize,
             sheet().MeleeMisc);
             
    sheet().MeleeAttack.value = Clean(Add(
             sheet().MeleeBase.value,
             sheet().MeleeStrength.value,
             sheet().MeleeSize.value,
             sheet().MeleeMisc.value));
}

function updateRangedAttack() {
    ZeroFill(sheet().RangedBase,
             sheet().RangedDexterity,
             sheet().RangedSize,
             sheet().RangedMisc);
             
    sheet().RangedAttack.value = Clean(Add(
             sheet().RangedBase.value,
             sheet().RangedDexterity.value,
             sheet().RangedSize.value,
             sheet().RangedMisc.value));

}

function updateFortitudeSave() {
    ZeroFill(sheet().FortBase,
             sheet().FortAbility,
             sheet().FortMisc);
             
    sheet().FortSave.value = Clean(Add(
             sheet().FortBase.value,
             sheet().FortAbility.value,
             sheet().FortMisc.value));
}

function updateWillSave() {
    ZeroFill(sheet().WillBase,
             sheet().WillAbility,
             sheet().WillMisc);
             
    sheet().WillSave.value = Clean(Add(
             sheet().WillBase.value,
             sheet().WillAbility.value,
             sheet().WillMisc.value));
}

function updateReflexSave() {
    ZeroFill(sheet().ReflexBase,
             sheet().ReflexAbility,
             sheet().ReflexMisc);
             
    sheet().ReflexSave.value = Clean(Add(
             sheet().ReflexBase.value,
             sheet().ReflexAbility.value,
             sheet().ReflexMisc.value));
}

function updateSkills(ability) {
    for( i = 1; i <= 50; i++ ) {
        var num = FormatNumber(i);
        var skillAbility = sheet()["Skill" + num + "Ability"];        
                
        if( skillAbility != null && skillAbility.value == ability ) {
            updateSkill(skillAbility);
        }
    }
    for( i = 1; i <= 15; i++ ) {
        var num = FormatNumber(i);
        var skillAbility = sheet()["ForceSkill" + num + "Ability"];        
                
        if( skillAbility != null && skillAbility.value == ability ) {
            updateForceSkill(skillAbility);
        }
    }
}

function updateSkill(node) {

    var name = String(node.name).substr(0,7);
    
    if( sheet()[name].value.length == 0 ) {
        sheet()[name + "Ability"].value = "";
        sheet()[name + "Total"].value = "";
        sheet()[name + "Mod"].value = "";
        sheet()[name + "Rank"].value = "";
        sheet()[name + "Misc"].value = "";    
    } else {        
        ZeroFill( sheet()[name + "Total"],
                  sheet()[name + "Mod"],
                  sheet()[name + "Rank"],
                  sheet()[name + "Misc"]);
                  
        sheet()[name + "Mod"].value = getAbilityMod(sheet()[name + "Ability"].value);
        sheet()[name + "Total"].value = Clean(Add(
            sheet()[name + "Mod"].value,
            sheet()[name + "Rank"].value,
            sheet()[name + "Misc"].value));
    }
}

function updateForceSkill(node) {

    var name = String(node.name).substr(0,12);
    
    if( sheet()[name].value.length == 0 ) {
        sheet()[name + "Ability"].value = "";
        sheet()[name + "Total"].value = "";
        sheet()[name + "Mod"].value = "";
        sheet()[name + "Rank"].value = "";
        sheet()[name + "Misc"].value = "";    
    } else {        
        ZeroFill( sheet()[name + "Total"],
                  sheet()[name + "Mod"],
                  sheet()[name + "Rank"],
                  sheet()[name + "Misc"]);
                  
        sheet()[name + "Mod"].value = getAbilityMod(sheet()[name + "Ability"].value);
        sheet()[name + "Total"].value = Clean(Add(
            sheet()[name + "Mod"].value,
            sheet()[name + "Rank"].value,
            sheet()[name + "Misc"].value));
    }
}