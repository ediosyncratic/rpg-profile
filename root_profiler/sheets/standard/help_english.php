<?php

  /*

     staticHelp is a multi-dimensional array that contains the links for static help.
   The first dimension is the "name" of the static help.  IT SHOULD NOT BE CHANGED.
   For example, in:

      staticHelp[ "ac" ][0]

   "ac" is the name of the help.

   The second dimension has 3 values, 0-2.
      0 - This is the title (i.e. tooltip) for the link.
      1 - Text of the link.
      2 - Link

   To change the help to a different language, the only thing that needs to be changed
   are the values in the second dimension of the array.


  */

  $staticHelp = array();

  $staticHelp[ "ac" ]        = array( "Armor Class", "AC", "http://www.d20srd.org/srd/combat/combatStatistics.htm#armorClass" );
  $staticHelp[ "action points" ] = array( "Action Points", "ACTION POINTS", "http://www.d20srd.org/srd/variant/adventuring/actionPoints.htm" );
  $staticHelp[ "age" ]       = array( "Age of character",
                                        "Age",
                                       "http://www.d20srd.org/srd/description.htm#age" );
  $staticHelp[ "alignment" ] = array( "Lawful/Neutral/Chaotic-Good/Neutral/Evil",
                                        "Alignment",
                                          "http://www.d20srd.org/srd/description.htm#alignment" );
  $staticHelp[ "armor1" ]    = array( "Main armor owned by character",
                                        "Armor/Protective Item",
                                          "http://www.d20srd.org/srd/equipment/armor.htm#armorDescriptions" );
  $staticHelp[ "armor2" ]    = array( "Secondary armor owned by character",
                                        "Protective Item",
                                          "http://www.d20srd.org/srd/equipment/armor.htm#armorDescriptions" );
  $staticHelp[ "armor check penalty" ] = array( "Help on Armor Check Penalty",
                                        "Armor check penalty",
                                       "http://www.d20srd.org/srd/equipment/armor.htm#armorCheckPenalty" );
  $staticHelp[ "bonus spells" ] = array( "Bonus spells based on ability.",
                                        "Bonus <br />Spells",
                                       "http://www.d20srd.org/srd/theBasics.htm#tableAbilityModifiersandBonusSpells" );
  $staticHelp[ "cha" ]       = array( "Charisma",
                                        "CHA",
                                       "http://www.d20srd.org/srd/theBasics.htm#charismaCha" );
  $staticHelp[ "class" ]     = array( "Supported classes: barbarian (bbn), bard (brd), cleric (clr), druid (drd), fighter (ftr), monk (mnk), paladin (pal), ranger (rgr), rogue (rog), sorcerer (sor), wizard (wiz)",
                                        "Class",
                                       "http://www.d20srd.org/indexes/classes.htm" );
  $staticHelp[ "con" ]       = array( "Constitution",
                                        "CON",
                                       "http://www.d20srd.org/srd/theBasics.htm#constitutionCon" );
  $staticHelp[ "dex" ]       = array( "Dexterity",
                                        "DEX",
                                       "http://www.d20srd.org/srd/theBasics.htm#dexterityDex" );
  $staticHelp[ "dmg red" ]   = array( "Damage Reduction",
                                        "Dmg<br />Red",
                                       "http://www.d20srd.org/srd/naturalSpecialAbilities.htm#damageReduction" );
  $staticHelp[ "encumbrance" ] = array( "Help on encumbrance penalty",
                                        "encumbrance penalty",
                                       "http://www.d20srd.org/srd/carryingCapacity.htm#tableCarryingLoads" );
  $staticHelp[ "feats" ]     = array( "Feats usable by the character",
                                        "Feats",
                                       "http://www.d20srd.org/indexes/feats.htm" );
  $staticHelp[ "flat" ]      = array( "Flat-footed AC",
                                        "FLAT",
                                       "http://www.d20srd.org/srd/conditionSummary.htm#flatFooted" );
  $staticHelp[ "fortitude" ] = array( "Saving throw against vitality and health attacks",
                                        "FORTITUDE",
                                       "http://www.d20srd.org/srd/combat/combatStatistics.htm#savingThrows" );
  $staticHelp[ "grapple" ]   = array( "Total attack bonus for grapple attacks",
                                        "GRAPPLE",
                                       "http://www.d20srd.org/srd/combat/specialAttacks.htm#grapple" );
  $staticHelp[ "height" ]    = array( "Height and weight of character",
                                        "Height",
                                       "http://www.d20srd.org/srd/description.htm#heightAndWeight" );
  $staticHelp[ "hp" ]        = array( "Hit Points",
                                        "HP",
                                       "http://www.d20srd.org/srd/combat/combatStatistics.htm#hitPoints" );
  $staticHelp[ "init" ]      = array( "Initiative check",
                                        "INIT",
                                       "http://www.d20srd.org/srd/combat/initiative.htm" );
  $staticHelp[ "int" ]       = array( "Intelligence",
                                        "INT",
                                       "http://www.d20srd.org/srd/theBasics.htm#intelligenceInt" );
  $staticHelp[ "melee" ]     = array( "Total attack bonus for melee",
                                        "MELEE",
                                       "http://www.d20srd.org/srd/combat/combatStatistics.htm#attackBonus" );
  $staticHelp[ "nonlethal damage" ] = array( "Nonlethal Damage",
                                        "Nonlethal Damage",
                                       "http://www.d20srd.org/srd/combat/injuryandDeath.htm#nonlethalDamage" );
  $staticHelp[ "other possessions" ] = array( "Characters possessions",
                                        "Other Possessions",
                                       "http://www.d20srd.org/srd/equipment/goodsAndServices.htm" );
  $staticHelp[ "race" ]      = array( "Race of character",
                                        "Race",
                                       "http://www.d20srd.org/srd/races.htm" );
  $staticHelp[ "ranged" ]    = array( "Total attack bonus for ranged attacks",
                                        "RANGED",
                                       "http://www.d20srd.org/srd/combat/combatStatistics.htm#attackBonus" );
  $staticHelp[ "reflex" ]    = array( "Saving throw to dodge area attacks",
                                        "REFLEX",
                                       "http://www.d20srd.org/srd/combat/combatStatistics.htm#savingThrows" );
  $staticHelp[ "save dc" ]   = array( "Saving throw DC for spells",
                                        "Save<br />DC",
                                          "http://www.d20srd.org/srd/magicOverview/spellDescriptions.htm#savingThrow" );
  $staticHelp[ "shield" ]    = array( "Shield owned by character",
                                        "Shield/Protective Item",
                                          "http://www.d20srd.org/srd/equipment/armor.htm#armorDescriptions" );
  $staticHelp[ "size" ]      = array( "Supported classes: (F)ine, (D)iminutive, (T)iny, (S)mall, (M)edium, (L)arge, (H)uge, (G)argantuan, (C)olossal",
                                        "Size",
                                       "http://www.d20srd.org/srd/combat/movementPositionAndDistance.htm#bigandLittleCreaturesInCombat" );
  $staticHelp[ "skills" ]    = array( "Character skills",
                                        "Skills",
                                          "http://www.d20srd.org/indexes/skills.htm" );
  $staticHelp[ "special abilities" ] = array( "Special and class-related abilities",
                                        "Special abilities",
                                       "http://www.d20srd.org/indexes/abilities.htm" );
  $staticHelp[ "spell resist" ] = array( "Spell resistance",
                                        "SPELL RESISTANCE",
                                          "http://www.d20srd.org/srd/magicOverview/spellDescriptions.htm#spellResistance" );
  $staticHelp[ "spells" ]    = array( "Spells",
                                        "Spells",
                                          "http://www.d20srd.org/indexes/spellLists.htm" );
  $staticHelp[ "spellsknown"] = array( "Spells/Powers Known (Bards, Sorcerers, Psions & Psi Warriors)",
                                       "Spells/Powers Known",
                                       "#");
  $staticHelp[ "str" ]       = array( "Strength",
                                        "STR",
                                       "http://www.d20srd.org/srd/theBasics.htm#strengthStr" );
  $staticHelp[ "total weight" ] = array( "Total weight of gear carried",
                                        "Total <br /> Weight",
                                       "http://www.d20srd.org/srd/carryingCapacity.htm" );
  $staticHelp[ "touch" ]     = array( "AC against Touch attacks",
                                        "TOUCH",
                                       "http://www.d20srd.org/srd/combat/actionsInCombat.htm#spellTouchAttacks" );
  $staticHelp[ "untrained skill" ] = array( "Skill check help for untrained skill",
                                        "untrained",
                                       "http://www.d20srd.org/srd/skills/usingSkills.htm#untrainedSkillChecks" );
  $staticHelp[ "weapon" ]    = array( "Weapon owned by character",
                                        "Weapon",
                                       "http://www.d20srd.org/srd/equipment/weapons.htm#weaponDescriptions" );
  $staticHelp[ "weight" ]    = array( "Height and weight of character",
                                        "Weight",
                                       "http://www.d20srd.org/srd/description.htm#heightAndWeight" );
  $staticHelp[ "will" ]      = array( "Saving throw to resist magical/mental attacks",
                                        "WILL",
                                       "http://www.d20srd.org/srd/combat/combatStatistics.htm#savingThrows" );
  $staticHelp[ "wis" ]       = array( "Wisdom",
                                        "WIS",
                                       "http://www.d20srd.org/srd/theBasics.htm#wisdomWis" );

?>



