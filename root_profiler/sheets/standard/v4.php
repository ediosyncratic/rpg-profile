<?php echo('<?xml version="1.0" encoding="iso-5589-1"?>');?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <?php
  $sheetVer = "0.1";

  // Lists for skills and traits.
  require_once("v4_Include.php");
  ?>

  <head>
    <title><?= $TITLE ?> - D&amp;D Fourth Edition</title>
    <link type="text/css" rel="stylesheet" href="v4/main.css" />
    <!--[if IE]>
    <link type="text/css" rel="stylesheet" href="v4/main-ie.css" />
    <![endif]-->

    <script type="text/javascript">var READONLY = <?= $READONLY ? "true" : "false"; ?>;</script>
    <script type="text/javascript" src="./v4/attributes.js"></script>
    <script type="text/javascript" src="./v4/general.js"></script>
    <script type="text/javascript" src="./v4/sheet.js"></script>
    <script type="text/javascript" src="./v4/pic.js"></script>
  </head>
  <body onload="init()" onunload="cleanup()">
  <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

  <form action="save.php" method="post" id="charactersheet">

<input type="hidden" name="firstload" value="<?php echo isset($DATA['firstload']) ? "false" : "true"; ?>" />
<input type="hidden" <?php getnv('PicURL'); ?> />
<input type="hidden" name="id" value="<?php echo $CHARID; ?>" />
<input type="hidden" <?php getnv('LastSaveDate'); ?> />

<!-- Character -->
<div id="character">
    <div class="attr"><input type="text" <?php getnv("CharacterName"); ?> class="large"><br/>Character Name</div>
    <div class="attr"><input type="text" <?php getnv("Level"); ?> class="small"><br/>Level</div>
    <div class="attr"><input type="text" <?php getnv("Class"); ?> class="medium"><br/>Class</div>
    
    <div class="attr"><input type="text" <?php getnv("ParagonPath"); ?> class="medium"><br/>Paragon Path</div>
    <div class="attr"><input type="text" <?php getnv("EpicDestiny"); ?> class="medium"><br/>Epic Destiny</div>
    <div class="attr"><input type="text" <?php getnv("TotalXP"); ?> class="small"><br/>Total XP</div>
    
    <div class="attr"><input type="text" <?php getnv("Race"); ?> class="medium"><br/>Race</div>
    
    <div class="attr"><input type="text" <?php getnv("Size"); ?> class="tiny"><br/>Size</div>
    <div class="attr"><input type="text" <?php getnv("Age"); ?> class="tiny"><br/>Age</div>
    <div class="attr"><input type="text" <?php getnv("Gender"); ?> class="tiny"><br/>Gender</div>
    <div class="attr"><input type="text" <?php getnv("Height"); ?> class="tiny"><br/>Height</div>
    <div class="attr"><input type="text" <?php getnv("Weight"); ?> class="tiny"><br/>Weight</div>
    
    <div class="attr"><input type="text" <?php getnv("Alignment"); ?> class="small"><br/>Alignment</div>
    <div class="attr"><input type="text" <?php getnv("Deity"); ?> class="small"><br/>Deity</div>
    <div class="attr"><input type="text" <?php getnv("Company"); ?> class="large"><br/>Adventuring Company/Affiliations</div>
</div>
<br class="clear"/>

<div class="column">
    
    <!-- ======================================== -->
    <!-- Initiative -->
    <!-- ======================================== -->
    <div id="initiative" class="section">
        <h2>Initiative</h2>
        <div class="textleft attr">
            Score<br/><input type="text" <?php getnv("Initiative"); ?> class="tiny">
            <span class="largelabel">Initiative</span>
        </div>
        <div class="attr">Dex<br/><input type="text" <?php getnv("InitiativeDex"); ?> class="tiny"></div>
        <div class="attr">&frac12; Lev<br/><input type="text" <?php getnv("InitiativeLevel"); ?> class="tiny"></div>
        <div class="attr">Misc<br/><input type="text" <?php getnv("InitiativeMisc"); ?> class="tiny"></div>
        <div class="attr textleft">Conditional Modifiers<br/><input type="text" <?php getnv("InitiativeModifier"); ?> class="full"></div>
    </div>
    
    <!-- ======================================== -->
    <!-- Ability Scores -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Ability Scores</h2>
        
        <div class="ability heading">
            <p class="quarter heading">Score</p>
            <p class="quarter heading">Ability</p>
            <p class="quarter heading">Mod</p>
            <p class="quarter heading">Mod+&frac12;Lvl</p>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Strength"); ?> class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">STR</p>
            <input type="text" <?php getnv("StrengthModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("StrengthBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Constitution"); ?> class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">CON</p>
            <input type="text" <?php getnv("ConstitutionModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("ConstitutionBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Dexterity"); ?> class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">DEX</p>
            <input type="text" <?php getnv("DexterityModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("DexterityBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Intelligence"); ?> class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">INT</p>
            <input type="text" <?php getnv("IntelligenceModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("IntelligenceBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Wisdom"); ?> class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">WIS</p>
            <input type="text" <?php getnv("WisdomModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("WisdomBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Charisma"); ?> class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">CHA</p>
            <input type="text" <?php getnv("CharismaModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("CharismaBonus"); ?> class="quarter" readonly/>
        </div>
    </div>
    
    <!-- ======================================== -->
    <!-- Hit Points -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Hit Points</h2>
        <div class="attr">
            Max HP<br/>
            <input type="text" <?php getnv("MaxHitPoints"); ?> class="quarter tall"/>
        </div>
        <div class="attr">
            <br/>
            Bloodied<br/>
            <input type="text" <?php getnv("BloodiedHitPoints"); ?> class="quarter"/><br/>
            &frac12; HP
        </div>
        <div class="attr">
            Surge<br/>Value<br/>
            <input type="text" <?php getnv("SurgeValue"); ?> class="quarter"/><br/>
            &frac14; HP
        </div>
        <div class="attr">
            Surges/<br/>Day<br/>
            <input type="text" <?php getnv("SurgesPerDay"); ?> class="quarter"/>
        </div>
        <br class="clear"/>
        <div class="attr textleft">
            Current Hit Points<br/>
            <input type="text" <?php getnv("HitPoints"); ?> class="half"/>
        </div>
        <div class="attr textright">
            Current Surge Uses<br/>
            <input type="text" <?php getnv("CurrentSurgeUses"); ?> class="half"/>
        </div>
        <h3>
            <span class="right"><p class="top">Used</p> <input type="checkbox" <? getnc("SecondWind"); ?> class="smallcheck"/></span>
            Second Wind 1/Enc
        </h3>
        <div class="attr textleft">
            Temporary Hit Points<br/>
            <input type="text" <?php getnv("TemporaryHitPoints"); ?> class="full"/>
        </div>
        <h3>
            <span class="right"><input type="checkbox" <? getnc("DeathFail1"); ?> class="smallcheck"/><input type="checkbox" <? getnc("DeathFail2"); ?> class="smallcheck"/><input type="checkbox" <? getnc("DeathFail3"); ?> class="smallcheck"/></span>
            Death Saving Throw Fails
        </h3>
        <div class="attr textleft">
            Saving Throw Mods<br/>
            <input type="text" <?php getnv("SavingThrowMods"); ?> class="full"/>
        </div>
        <div class="attr textleft">
            Resistances<br/>
            <input type="text" <?php getnv("Resistances"); ?> class="full"/>
        </div>
        <div class="attr textleft">
            Current Conditions and Effects<br/>
            <input type="text" <?php getnv("CurrentConditions"); ?> class="full"/>
        </div>
        
    </div>
    
    
    <!-- ======================================== -->
    <!-- Skills -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Skills</h2>
        <div class="skilltitle">
            <p class="skilllabel">Bon</p>
            <p class="skillnamelabel">Skill Name</p>
            <p class="skillattr"></p>
            <p class="skilllabel">Mod</p>
            <p class="skilllabel">Trnd</p>
            <p class="skilllabel">Pen</p>
            <p class="skilllabel">Misc</p>
        </div>
        
    <?php
    $skillNum = 1;
    foreach( $skills as $skillName => $skillAttributes) {
        $ability = $skillAttributes[$ABILITY];
        $penalty = $skillAttributes[$PENALTY];
        $skillNum++;
    ?>
        <div class="skill<? if( $skillNum % 2 == 0 ) { ?> oddbg<? } ?>">
            <input type="text" <? getnv($skillName . "SkillBonus"); ?> class="skilltiny" readonly/>
            <p class="skillname"><?= $skillName ?></p>
            <p class="skillattr"><?= $ability ?></p>
            <input type="text" <? getnv($skillName . "SkillAbility"); ?> class="skilltiny" onchange="updateSkill('<?=$skillName?>');"/>
            <input type="text" <? getnv($skillName . "Trained"); ?> class="skilltiny" onchange="updateSkill('<?=$skillName?>');"/>
            <? if( $penalty ) { ?>
                <input type="text" <? getnv($skillName . "SkillPenalty"); ?> class="skilltiny bottomborder<? if( $skillNum % 2 == 0 ) { ?> oddbg<? } ?>" onchange="updateSkill('<?=$skillName?>');"/>
            <? } else { ?>
                <div class="skillnopenalty">n/a</div>
            <? } ?>
            <input type="text" <? getnv($skillName . "SkillMisc"); ?> class="skilltiny bottomborder<? if( $skillNum % 2 == 0 ) { ?> oddbg<? } ?>" onchange="updateSkill('<?=$skillName?>');"/>
        </div>
    <?
    }
    ?>
    </div>
</div>

<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- SECOND COLUMN -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->

<div class="column">
    <!-- ======================================== -->
    <!-- Defences -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Defenses</h2>
        
        <div class="defence">
            <div class="attr total">
                <span class="largelabel">AC<br/></span>
                <input type="text" <? getnv("AC"); ?> class="tiny tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <? getnv("ACBase"); ?> class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel">Armor/<br/>Abil<br/></span>
                <input type="text" <? getnv("ACArmor"); ?> class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <? getnv("ACClass"); ?> class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <? getnv("ACFeat"); ?> class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <? getnv("ACEnhance"); ?> class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("ACMisc"); ?> class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("ACMisc2"); ?> class="xtiny" onchange="updateAC();"/>
            </div>
        </div>

        <div class="defence">
            <div class="attr total">
                <span class="largelabel">FORT<br/></span>
                <input type="text" <? getnv("Fort"); ?> class="tiny tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <? getnv("FortBase"); ?> class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Abil<br/></span>
                <input type="text" <? getnv("FortArmor"); ?> class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <? getnv("FortClass"); ?> class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <? getnv("FortFeat"); ?> class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <? getnv("FortEnhance"); ?> class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("FortMisc"); ?> class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("FortMisc2"); ?> class="xtiny" onchange="updateFort();"/>
            </div>
        </div>

        <div class="defence">
            <div class="attr total">
                <span class="largelabel">REF<br/></span>
                <input type="text" <? getnv("Reflex"); ?> class="tiny tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <? getnv("ReflexBase"); ?> class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Abil<br/></span>
                <input type="text" <? getnv("ReflexArmor"); ?> class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <? getnv("ReflexClass"); ?> class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <? getnv("ReflexFeat"); ?> class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <? getnv("ReflexEnhance"); ?> class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("ReflexMisc"); ?> class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("ReflexMisc2"); ?> class="xtiny" onchange="updateReflex();"/>
            </div>
        </div>

        <div class="defence">
            <div class="attr total">
                <span class="largelabel">WILL<br/></span>
                <input type="text" <? getnv("Will"); ?> class="tiny tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <? getnv("WillBase"); ?> class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Abil<br/></span>
                <input type="text" <? getnv("WillArmor"); ?> class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <? getnv("WillClass"); ?> class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <? getnv("WillFeat"); ?> class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <? getnv("WillEnhance"); ?> class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("WillMisc"); ?> class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <? getnv("WillMisc2"); ?> class="xtiny" onchange="updateWill();"/>
            </div>
        </div>

    </div>

    <!-- ======================================== -->
    <!-- Action Points -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Action Points</h2>
        <div class="attr">
            <input type="text" <? getnv("ActionPoints"); ?> class="small"/>
            <span class="largelabel">Action Points</span>
        </div>
        <div class="attr textleft">
            Additional Effects for Spending Action Points<br/>
            <input type="text" <? getnv("ActionPointsEffect"); ?> class="full"/>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Race Features -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Race Features</h2>
        <div class="attr textleft">
            <textarea <? getn("RaceFeatures"); ?> class="full racefeatures"><? getv("RaceFeatures"); ?></textarea>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Class/Path/Destiny Features -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Class/Path/Destiny Features</h2>
        <div class="attr textleft">
            <textarea <? getn("ClassFeatures"); ?> class="full classfeatures"><? getv("ClassFeatures"); ?></textarea>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Languages Known -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Languages Known</h2>
        <div class="attr textleft">
            <textarea <? getn("Languages"); ?> class="full languages"><? getv("Languages"); ?></textarea>
        </div>
    </div>

</div>

<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- THIRD COLUMN -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->

<div class="column">
    <!-- ======================================== -->
    <!-- Movement -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Movement</h2>
        
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">Base<br/></span>
                    <input type="text" <? getnv("MovementBase"); ?> class="xtiny" onchange="updateMovement();"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Armor<br/></span>
                    <input type="text" <? getnv("MovementArmor"); ?> class="xtiny" onchange="updateMovement();"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Item<br/></span>
                    <input type="text" <? getnv("MovementItem"); ?> class="xtiny" onchange="updateMovement();"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <? getnv("MovementMisc"); ?> class="xtiny" onchange="updateMovement();"/>
                </div>
            </div>
            <div class="attr textleft">
                Score<br/>
                <input type="text" <? getnv("Movement"); ?> class="tiny" readonly/>
                <span class="mediumlabel">Speed</span>
            </div>
        </div>    
    </div>

    <!-- ======================================== -->
    <!-- Senses -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Senses</h2>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">Base<br/></span>
                    <span class="mediumlabel">10 +</span>
                </div>
                <div class="attr">
                    <span class="smalllabel">Skill<br/></span>
                    <input type="text" <? getnv("SenseInsightBonus"); ?> class="tiny" readonly/>
                </div>
            </div>
            <div class="attr textleft">
                Score<br/>
                <input type="text" <? getnv("SenseInsight"); ?> class="tiny" readonly/>
                <span class="mediumlabel">Passive Insight</span>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="mediumlabel">10 +</span>
                </div>
                <div class="attr">
                    <input type="text" <? getnv("SensePerceptionBonus"); ?> class="tiny" readonly/>
                </div>
            </div>
            <div class="attr textleft">
                <input type="text" <? getnv("SensePerception"); ?> class="tiny" readonly/>
                <span class="mediumlabel">Passive Perception</span>
            </div>
        </div>
        <div class="row">
            <div class="attr textleft">
                Special Senses<br/>
                <input type="text" <? getnv("SpecialSenses"); ?> class="full"/>
            </div>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Attack Workspace -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Attack Workspace</h2>
        <div class="row">
            <div class="attr textleft">
                Ability<br/>
                <input type="text" <? getnv("Attack1Ability"); ?> class="full"/>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">&frac12;Lvl<br/></span>
                    <input type="text" <? getnv("Attack1Level"); ?> class="xtiny" onchange="updateAttack(1);" readonly/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Abil<br/></span>
                    <input type="text" <? getnv("Attack1Ability"); ?> class="xtiny" onchange="updateAttack(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Class<br/></span>
                    <input type="text" <? getnv("Attack1Class"); ?> class="xtiny" onchange="updateAttack(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Prof<br/></span>
                    <input type="text" <? getnv("Attack1Prof"); ?> class="xtiny" onchange="updateAttack(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Feat<br/></span>
                    <input type="text" <? getnv("Attack1Feat"); ?> class="xtiny" onchange="updateAttack(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Enh<br/></span>
                    <input type="text" <? getnv("Attack1Enhance"); ?> class="xtiny" onchange="updateAttack(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <? getnv("Attack1Misc"); ?> class="xtiny" onchange="updateAttack(1);"/>
                </div>
            </div>
            <div class="attr total">
                <span class="smalllabel">Att Bonus<br/></span>
                <input type="text" <? getnv("Attack1"); ?> class="tiny" readonly/>
            </div>
        </div>
        <div class="row">
            <div class="attr textleft">
                Ability<br/>
                <input type="text" <? getnv("Attack2Ability"); ?> class="full"/>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">&frac12;Lvl<br/></span>
                    <input type="text" <? getnv("Attack2Level"); ?> class="xtiny" onchange="updateAttack(2);" readonly/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Abil<br/></span>
                    <input type="text" <? getnv("Attack2Ability"); ?> class="xtiny" onchange="updateAttack(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Class<br/></span>
                    <input type="text" <? getnv("Attack2Class"); ?> class="xtiny" onchange="updateAttack(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Prof<br/></span>
                    <input type="text" <? getnv("Attack2Prof"); ?> class="xtiny" onchange="updateAttack(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Feat<br/></span>
                    <input type="text" <? getnv("Attack2Feat"); ?> class="xtiny" onchange="updateAttack(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Enh<br/></span>
                    <input type="text" <? getnv("Attack2Enhance"); ?> class="xtiny" onchange="updateAttack(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <? getnv("Attack2Misc"); ?> class="xtiny" onchange="updateAttack(2);"/>
                </div>
            </div>
            <div class="attr total">
                <span class="smalllabel">Att Bonus<br/></span>
                <input type="text" <? getnv("Attack2"); ?> class="tiny" readonly/>
            </div>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Damage Workspace -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Damage Workspace</h2>
        <div class="row">
            <div class="attr textleft">
                Ability<br/>
                <input type="text" <? getnv("Damage1Ability"); ?> class="full"/>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">Abil<br/></span>
                    <input type="text" <? getnv("Damage1Ability"); ?> class="xtiny" onchange="updateDamage(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Feat<br/></span>
                    <input type="text" <? getnv("Damage1Feat"); ?> class="xtiny" onchange="updateDamage(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Enh<br/></span>
                    <input type="text" <? getnv("Damage1Enhance"); ?> class="xtiny" onchange="updateDamage(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <? getnv("Damage1Misc1"); ?> class="xtiny" onchange="updateDamage(1);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <? getnv("Damage1Misc2"); ?> class="xtiny" onchange="updateDamage(1);"/>
                </div>
            </div>
            <div class="attr total">
                <span class="smalllabel">Att Bonus<br/></span>
                <input type="text" <? getnv("Damage1"); ?> class="tiny" readonly/>
            </div>
        </div>
        <div class="row">
            <div class="attr textleft">
                Ability<br/>
                <input type="text" <? getnv("Damage2Ability"); ?> class="full"/>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">Abil<br/></span>
                    <input type="text" <? getnv("Damage2Ability"); ?> class="xtiny" onchange="updateDamage(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Feat<br/></span>
                    <input type="text" <? getnv("Damage2Feat"); ?> class="xtiny" onchange="updateDamage(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Enh<br/></span>
                    <input type="text" <? getnv("Damage2Enhance"); ?> class="xtiny" onchange="updateDamage(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <? getnv("Damage2Misc1"); ?> class="xtiny" onchange="updateDamage(2);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <? getnv("Damage2Misc2"); ?> class="xtiny" onchange="updateDamage(2);"/>
                </div>
            </div>
            <div class="attr total">
                <span class="smalllabel">Att Bonus<br/></span>
                <input type="text" <? getnv("Damage2"); ?> class="tiny" readonly/>
            </div>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Basic Attacks -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Basic Attacks</h2>
        <div class="row">
            <div class="attr">
                <span class="smalllabel">Attack<br/></span>
                <input type="text" <? getnv("BasicAttackAttack1"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>VS</span>
            </div>
            <div class="attr">
                <span class="smalllabel">Defense<br/></span>
                <input type="text" <? getnv("BasicAttackDefense1"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <span class="smalllabel">Weapon/Power<br/></span>
                <input type="text" <? getnv("BasicAttackWeapon1"); ?> class="third"/>
            </div>
            <div class="attr">
                <span class="smalllabel">Damage<br/></span>
                <input type="text" <? getnv("BasicAttackDamage1"); ?> class="small"/>
            </div>
        </div>
        <div class="row">
            <div class="attr">
                <input type="text" <? getnv("BasicAttackAttack2"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <span class="smalllabel">VS</span>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackDefense2"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackWeapon2"); ?> class="third"/>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackDamage2"); ?> class="small"/>
            </div>
        </div>
        <div class="row">
            <div class="attr">
                <input type="text" <? getnv("BasicAttackAttack3"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <span class="smalllabel">VS</span>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackDefense3"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackWeapon3"); ?> class="third"/>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackDamage3"); ?> class="small"/>
            </div>
        </div>
        <div class="row">
            <div class="attr">
                <input type="text" <? getnv("BasicAttackAttack4"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <span class="smalllabel">VS</span>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackDefense4"); ?> class="tiny"/>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackWeapon4"); ?> class="third"/>
            </div>
            <div class="attr">
                <input type="text" <? getnv("BasicAttackDamage4"); ?> class="small"/>
            </div>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Feats -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Feats</h2>
        <div class="attr textleft">
            <textarea <? getn("Feats"); ?> class="full feats"><? getv("Feats"); ?></textarea>
        </div>
        
    </div>
</div>

<br class="page"/>




<div id="charPic" style="display: none;">
<img id="pic" src="" onclick="SetPic();">
</div>

<div id="noCharPic">
<img id="pic" src="v4/click.png" onclick="SetPic();">
</div>

<br class="page"/>

<!-- Notes -->
<input type="checkbox" <?php getnc('NotesDisp'); ?> onchange="ToggleDisplay('notes', this);" style="width:15px; border:none;"/>
Display Notes
<div id="notes">

<h2>Notes</h2>
<textarea <?php getn('Notes'); ?> class="whole" cols="10" rows="10"><?php getv('Notes'); ?></textarea>

<?php if ($SHOWSAVE) { ?>
<!-- Private Notes -->
<h2>Private Notes (Will not be displayed publically)</h2>
<textarea <?php getn('PrivateNotes'); ?> class="whole" cols="10" rows="10"><?php getv('PrivateNotes'); ?></textarea>

<input type="checkbox" <?php getnc('BackgroundDisp'); ?> onchange="ToggleDisplay('background', this);" style="width:15px; border:none;"/>
Display Background

<br class="page">

<div id="background" class="section">
<h2>Character Background (Will not be displayed publically)</h2>

<textarea <?php getn('Background'); ?> class="whole" cols="10" rows="10"><?php getv('Background'); ?></textarea>
</div>
<?php } ?>
</div>

<!-- Footer -->

          <div id="footer">
            <table width="100%" cellspacing="0">
               <tr>
                  <td>Last saved = <?php getv("LastSaveDate"); ?></td>
                  <td align="right">D&D 4th Edition Character Sheet by Tarlen</td>
               </tr>
            </table>
          </div>

          <?php if ($SHOWSAVE) { ?>
          <div id="save">
            <input type="reset" value="Reset Changes" onclick="return confirm('Are you sure you want to reset the character sheet? You will lose all changes you made since you last saved.')" />
            &nbsp;&nbsp;
            <input type="submit" value="Save Changes" onclick="SetSaveDate(); return true;" />
          </div>
          <?php } ?>



</form>
</html>
