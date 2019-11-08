<?php echo('<?xml version="1.0" encoding="iso-5589-1"?>');?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>
    <?php
    $sheetVer = "0.1";
    
    // Lists for skills and traits.
    require_once("v4_Include.php");
    ?>

    <title><?= $TITLE ?> - D&amp;D Fourth Edition</title>
    <link type="text/css" rel="stylesheet" href="v4/main.css" media="screen,print"/>
    <link type="text/css" rel="stylesheet" href="v4/print.css" media="print" />

    <script type="text/javascript">var READONLY = <?= $READONLY ? "true" : "false"; ?>;</script>
    <script type="text/javascript" src="./v4/prototype.js"></script>
    <script type="text/javascript" src="./v4/jquery-1.6.1.min.js"></script>
    <script type="text/javascript">
        jQuery.noConflict();
    </script>

    <script type="text/javascript" src="./v4/attributes.js"></script>
    <script type="text/javascript" src="./v4/general.js"></script>
    <script type="text/javascript" src="./v4/money.js"></script>
    <script type="text/javascript" src="./v4/sheet.js"></script>
    <script type="text/javascript" src="./v4/pic.js"></script>

    <meta name="viewport" content="width=720,maximum-scale=1.0" />
  </head>
  <body onload="init()" onunload="cleanup()">
  <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

  <form action="ajax_save.php" method="post" id="charactersheet">

<?php if ($SHOWSAVE) { ?>
<div id="buttons">
    <input type="image" src="v4/save.png" title="Save Character" onclick="SetSaveDate(); Save(); return false;"/><br/>
    <input type="image" src="v4/undo.png" title="Reset Changes" onclick="if( confirm('Are you sure you want to reset the character sheet? You will lose all changes you made since you last saved.')) { $('charactersheet').reset(); } return false;" /><br/>
</div>
<div id="processing">
    <img src="v4/loading.gif"/>
</div>
<?php } ?>

<input type="hidden" name="firstload" value="<?php echo isset($DATA['firstload']) ? "false" : "true"; ?>" />
<input type="hidden" <?php getnv('PicURL'); ?> />
<input type="hidden" name="id" value="<?php echo $CHARID; ?>" />
<input type="hidden" <?php getnv('LastSaveDate'); ?> />

<!-- Character -->
<div id="character">
    <div class="row">
        <div class="attr textleft"><input type="text" <?php getnv("Player"); ?> class="medium bottomborder"><br/>Player</div>
        <div class="attr textleft"><input type="text" <?php getnv("CharacterName"); ?> class="large bottomborder"><br/>Character Name</div>
        <div class="attr textleft"><input type="text" <?php getnv("Level"); ?> pattern="\d*" class="small" onchange="updateLevel();"><br/>Level</div>
        
        <div class="attr textleft"><input type="text" <?php getnv("ParagonPath"); ?> class="medium bottomborder"><br/>Paragon Path</div>
        <div class="attr textleft"><input type="text" <?php getnv("EpicDestiny"); ?> class="medium bottomborder"><br/>Epic Destiny</div>
        <div class="attr textleft"><input type="text" <?php getnv("TotalXP"); ?> pattern="\d*" class="small"><br/>Total XP</div>
    </div>
    <div class="row">
        <div class="attr textleft"><input type="text" <?php getnv("Race"); ?> class="medium bottomborder"><br/>Race</div>
        <div class="attr textleft"><input type="text" <?php getnv("Class"); ?> class="medium bottomborder"><br/>Class</div>
        
        <div class="attr textleft"><input type="text" <?php getnv("Size"); ?> class="tiny bottomborder"><br/>Size</div>
        <div class="attr textleft"><input type="text" <?php getnv("Age"); ?> pattern="\d*" class="tiny bottomborder"><br/>Age</div>
        <div class="attr textleft"><input type="text" <?php getnv("Gender"); ?> class="tiny bottomborder"><br/>Gender</div>
        <div class="attr textleft"><input type="text" <?php getnv("Height"); ?> class="tiny bottomborder"><br/>Height</div>
        <div class="attr textleft"><input type="text" <?php getnv("Weight"); ?> class="tiny bottomborder"><br/>Weight</div>
        
        <div class="attr textleft"><input type="text" <?php getnv("Alignment"); ?> class="medium bottomborder"><br/>Alignment</div>
        <div class="attr textleft"><input type="text" <?php getnv("Deity"); ?> class="medium bottomborder"><br/>Deity</div>
    </div>
</div>
<br class="clear"/>

<div class="column">
    
    <!-- ======================================== -->
    <!-- Initiative -->
    <!-- ======================================== -->
    <div id="initiative" class="section">
        <h2>Initiative</h2>
        <div class="textleft attr">
            Score<br/><input type="text" <?php getnv("Initiative"); ?> class="tiny" readonly>
            <span class="mediumlabel">Initiative</span>
        </div>
        <div class="attr">Dex<br/><input type="text" <?php getnv("InitiativeDex"); ?> class="tiny" readonly></div>
        <div class="attr">&frac12; Lev<br/><input type="text" <?php getnv("InitiativeLevel"); ?> class="tiny" readonly></div>
        <div class="attr">Misc<br/><input type="text" <?php getnv("InitiativeMisc"); ?> pattern="\d*" class="tiny" onchange="updateInitiative();"></div>
        <div class="attr textleft">Conditional Modifiers<br/><input type="text" <?php getnv("InitiativeModifier"); ?> class="full bottomborder"></div>
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
            <input type="text" <?php getnv("Strength"); ?> pattern="\d*" class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">STR</p>
            <input type="text" <?php getnv("StrengthModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("StrengthBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Constitution"); ?> pattern="\d*" class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">CON</p>
            <input type="text" <?php getnv("ConstitutionModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("ConstitutionBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Dexterity"); ?> pattern="\d*" class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">DEX</p>
            <input type="text" <?php getnv("DexterityModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("DexterityBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Intelligence"); ?> pattern="\d*" class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">INT</p>
            <input type="text" <?php getnv("IntelligenceModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("IntelligenceBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability">
            <input type="text" <?php getnv("Wisdom"); ?> pattern="\d*" class="quarter" onchange="updateAbility(this);"/>
            <p class="quarter label">WIS</p>
            <input type="text" <?php getnv("WisdomModifier"); ?> class="quarter" readonly/>
            <input type="text" <?php getnv("WisdomBonus"); ?> class="quarter" readonly/>
        </div>
        <div class="ability last">
            <input type="text" <?php getnv("Charisma"); ?> pattern="\d*" class="quarter" onchange="updateAbility(this);"/>
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
            <br/>
            Max HP<br/>
            <input type="text" pattern="\d*" <?php getnv("MaxHitPoints"); ?> class="tiny" onchange="updateHP();"/>
        </div>
        <div class="attr" id="bloodied">
            <br/>
            Bloodied<br/>
            <input type="text" <?php getnv("BloodiedHitPoints"); ?> class="tiny" readonly/><br/>
            &frac12; HP
        </div>
        <div class="attr">
            Surge<br/>Value<br/>
            <input type="text" <?php getnv("SurgeValue"); ?> class="tiny" readonly/><br/>
            &frac14; HP
        </div>
        <div class="attr">
            Surges/<br/>Day<br/>
            <input type="text" pattern="\d*" <?php getnv("SurgesPerDay"); ?> class="tiny"/>
        </div>
        <div class="attr">
            Surge<br/>Bonus<br/>
            <input type="text" pattern="\d*" <?php getnv("SurgeBonus"); ?> class="tiny" onchange="updateHP();"/>
        </div>
        <br class="clear"/>
        <div class="attr textleft">
            Current Hit Points<br/>
            <input type="text" pattern="\d*" <?php getnv("HitPoints"); ?> class="half tall bottomborder" onchange="updateHP();"/>
        </div>
        <div class="attr textright">
            Current Surge Uses<br/>
            <input type="text" pattern="\d*" <?php getnv("CurrentSurgeUses"); ?> class="half tall bottomborder"/>
        </div>
        <h3>
            <span class="right"><p class="top">Used</p> <input type="checkbox" <?php getnc("SecondWind"); ?> class="smallcheck"/></span>
            Second Wind 1/Enc
        </h3>
        <div class="attr textleft">
            Temporary Hit Points<br/>
            <input type="text" pattern="\d*" <?php getnv("TemporaryHitPoints"); ?> class="full noborder"/>
        </div>
        <h3>
            <span class="right"><input type="checkbox" <?php getnc("DeathFail1"); ?> class="smallcheck"/><input type="checkbox" <?php getnc("DeathFail2"); ?> class="smallcheck"/><input type="checkbox" <?php getnc("DeathFail3"); ?> class="smallcheck"/></span>
            Death Saving Throw Fails
        </h3>
        <div class="attr textleft">
            Saving Throw Mods<br/>
            <input type="text" <?php getnv("SavingThrowMods"); ?> class="full bottomborder"/>
        </div>
        <div class="attr textleft">
            Resistances<br/>
            <input type="text" <?php getnv("Resistances"); ?> class="full bottomborder"/>
        </div>
        <div class="attr textleft">
            Current Conditions and Effects<br/>
            <input type="text" <?php getnv("CurrentConditions"); ?> class="full bottomborder"/>
        </div>
        
    </div>
    
    
    <!-- ======================================== -->
    <!-- Skills -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Skills</h2>
        <div class="skilltitle">
            <p class="skillbonuslabel">Bon</p>
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
        <div class="skill<?php if( $skillNum % 2 == 0 ) { ?> oddbg<?php } ?>">
            <input type="text" <?php getnv($skillName . "SkillBonus"); ?> class="skillbonus" readonly/>
            <p class="skillname"><?= $skillName ?></p>
            <p class="skillattr"><?= $ability ?></p>
            <input type="text" <?php getnv($skillName . "SkillAbility"); ?> class="skilltiny" readonly/>
            <input type="text" <?php getnv($skillName . "SkillTrained"); ?> pattern="\d*" class="skilltiny" onchange="updateSkill('<?=$skillName?>');"/>
            <?php if( $penalty ) { ?>
                <input type="text" <?php getnv($skillName . "SkillPenalty"); ?> class="skilltiny bottomborder<?php if( $skillNum % 2 == 0 ) { ?> oddbg<?php } ?>" onchange="updateSkill('<?=$skillName?>');"/>
            <?php } else { ?>
                <div class="skillnopenalty">n/a</div>
            <?php } ?>
            <input type="text" <?php getnv($skillName . "SkillMisc"); ?> pattern="\d*" class="skilltiny bottomborder<?php if( $skillNum % 2 == 0 ) { ?> oddbg<?php } ?>" onchange="updateSkill('<?=$skillName?>');"/>
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
            <div class="attr defensetotal">
                <span class="largelabel">AC<br/></span>
                <input type="text" <?php getnv("AC"); ?> class="xsmall tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <?php getnv("ACBase"); ?> class="xtiny" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">Armor/<br/>Abil<br/></span>
                <input type="text" <?php getnv("ACArmor"); ?> pattern="\d*" class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <?php getnv("ACClass"); ?> pattern="\d*" class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <?php getnv("ACFeat"); ?> pattern="\d*" class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <?php getnv("ACEnhance"); ?> pattern="\d*" class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("ACMisc"); ?> pattern="\d*" class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("ACMisc2"); ?> pattern="\d*" class="xtiny" onchange="updateAC();"/>
            </div>
            <div class="attr">
                <input type="text" <?php getnv("ACSpecial"); ?> class="full bottomborder"/>
            </div>
        </div>

        <div class="defence">
            <div class="attr defensetotal">
                <span class="largelabel">FORT<br/></span>
                <input type="text" <?php getnv("Fort"); ?> class="xsmall tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <?php getnv("FortBase"); ?> class="xtiny" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Abil<br/></span>
                <input type="text" <?php getnv("FortArmor"); ?> pattern="\d*" class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <?php getnv("FortClass"); ?> pattern="\d*" class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <?php getnv("FortFeat"); ?> pattern="\d*" class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <?php getnv("FortEnhance"); ?> pattern="\d*" class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("FortMisc"); ?> pattern="\d*" class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("FortMisc2"); ?> pattern="\d*" class="xtiny" onchange="updateFort();"/>
            </div>
            <div class="attr">
                <input type="text" <?php getnv("FortSpecial"); ?> class="full bottomborder"/>
            </div>
        </div>

        <div class="defence">
            <div class="attr defensetotal">
                <span class="largelabel">REF<br/></span>
                <input type="text" <?php getnv("Reflex"); ?> class="xsmall tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <?php getnv("ReflexBase"); ?> class="xtiny" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">Abil/<br/>Shield<br/></span>
                <input type="text" <?php getnv("ReflexArmor"); ?> pattern="\d*" class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <?php getnv("ReflexClass"); ?> pattern="\d*" class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <?php getnv("ReflexFeat"); ?> pattern="\d*" class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <?php getnv("ReflexEnhance"); ?> pattern="\d*" class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("ReflexMisc"); ?> pattern="\d*" class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("ReflexMisc2"); ?> pattern="\d*" class="xtiny" onchange="updateReflex();"/>
            </div>
            <div class="attr">
                <input type="text" <?php getnv("ReflexSpecial"); ?> class="full bottomborder"/>
            </div>
        </div>

        <div class="defence">
            <div class="attr defensetotal">
                <span class="largelabel">WILL<br/></span>
                <input type="text" <?php getnv("Will"); ?> class="xsmall tall" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel">10 + <br/>&frac12;Lvl<br/></span>
                <input type="text" <?php getnv("WillBase"); ?> class="xtiny" readonly/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Abil<br/></span>
                <input type="text" <?php getnv("WillArmor"); ?> pattern="\d*" class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Class<br/></span>
                <input type="text" <?php getnv("WillClass"); ?> pattern="\d*" class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Feat<br/></span>
                <input type="text" <?php getnv("WillFeat"); ?> pattern="\d*" class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Enh<br/></span>
                <input type="text" <?php getnv("WillEnhance"); ?> pattern="\d*" class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("WillMisc"); ?> pattern="\d*" class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><br/>Misc<br/></span>
                <input type="text" <?php getnv("WillMisc2"); ?> pattern="\d*" class="xtiny" onchange="updateWill();"/>
            </div>
            <div class="attr">
                <input type="text" <?php getnv("WillSpecial"); ?> class="full bottomborder"/>
            </div>
        </div>

    </div>

    <!-- ======================================== -->
    <!-- Action Points -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Action Points</h2>
        <div class="attr">
            <input type="text" <?php getnv("ActionPoints"); ?> pattern="\d*" class="small"/>
            <span class="largelabel">Action Points</span>
        </div>
        <div class="attr textleft">
            Additional Effects for Spending Action Points<br/>
            <input type="text" <?php getnv("ActionPointsEffect"); ?> class="full bottomborder"/>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Race Features -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Race Features</h2>
        <div class="attr textleft">
            <textarea <?php getn("RaceFeatures"); ?> class="full racefeatures"><?php getv("RaceFeatures"); ?></textarea>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Class/Path/Destiny Features -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Class/Path/Destiny Features</h2>
        <div class="attr textleft">
            <textarea <?php getn("ClassFeatures"); ?> class="full classfeatures"><?php getv("ClassFeatures"); ?></textarea>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Languages Known -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Languages Known</h2>
        <div class="attr textleft">
            <textarea <?php getn("Languages"); ?> class="full languages"><?php getv("Languages"); ?></textarea>
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
                    <input type="text" <?php getnv("MovementBase"); ?> pattern="\d*" class="xtiny" onchange="updateMovement();"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Armor<br/></span>
                    <input type="text" <?php getnv("MovementArmor"); ?> pattern="\d*" class="xtiny" onchange="updateMovement();"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Item<br/></span>
                    <input type="text" <?php getnv("MovementItem"); ?> pattern="\d*" class="xtiny" onchange="updateMovement();"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <?php getnv("MovementMisc"); ?> pattern="\d*" class="xtiny" onchange="updateMovement();"/>
                </div>
            </div>
            <div class="attr textleft">
                <span class="smalllabel">Score<br/></span>
                <input type="text" <?php getnv("Movement"); ?> class="tiny" readonly/>
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
                    <input type="text" <?php getnv("SenseInsightBonus"); ?> class="tiny" readonly/>
                </div>
            </div>
            <div class="attr textleft">
                <span class="smalllabel">Score<br/></span>
                <input type="text" <?php getnv("SenseInsight"); ?> class="tiny" readonly/>
                <span class="mediumlabel">Passive Insight</span>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="mediumlabel">10 +</span>
                </div>
                <div class="attr">
                    <input type="text" <?php getnv("SensePerceptionBonus"); ?> class="tiny" readonly/>
                </div>
            </div>
            <div class="attr textleft">
                <input type="text" <?php getnv("SensePerception"); ?> class="tiny" readonly/>
                <span class="mediumlabel">Passive Perception</span>
            </div>
        </div>
        <div class="row">
            <div class="attr textleft">
                Special Senses<br/>
                <input type="text" <?php getnv("SpecialSenses"); ?> class="full bottomborder"/>
            </div>
        </div>
    </div>

    <!-- ======================================== -->
    <!-- Attack Workspace -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Attack Workspace</h2>
        <?php for( $i = 1; $i <= 2; $i++ ) { ?>
        <div class="row">
            <div class="attr textleft">
                Ability<br/>
                <input type="text" <?php getnv("AttackAbilityText" . $i); ?> class="full bottomborder"/>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">&frac12;Lvl<br/></span>
                    <input type="text" <?php getnv("AttackLevel" . $i); ?> class="xtiny" readonly/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Abil<br/></span>
                    <input type="text" <?php getnv("AttackAbility" . $i); ?> pattern="\d*" class="xtiny" onchange="updateAttack(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Class<br/></span>
                    <input type="text" <?php getnv("AttackClass" . $i); ?> pattern="\d*" class="xtiny" onchange="updateAttack(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Prof<br/></span>
                    <input type="text" <?php getnv("AttackProf" . $i); ?> pattern="\d*" class="xtiny" onchange="updateAttack(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Feat<br/></span>
                    <input type="text" <?php getnv("AttackFeat" . $i); ?> pattern="\d*" class="xtiny" onchange="updateAttack(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Enh<br/></span>
                    <input type="text" <?php getnv("AttackEnhance" . $i); ?> pattern="\d*" class="xtiny" onchange="updateAttack(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <?php getnv("AttackMisc" . $i); ?> pattern="\d*" class="xtiny" onchange="updateAttack(<?= $i ?>);"/>
                </div>
            </div>
            <div class="attr total">
                <span class="smalllabel">Att Bonus<br/></span>
                <input type="text" <?php getnv("Attack" . $i); ?> class="tiny" readonly/>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- ======================================== -->
    <!-- Damage Workspace -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Damage Workspace</h2>
        <?php for( $i = 1; $i <= 2; $i++ ) { ?>
        <div class="row">
            <div class="attr textleft">
                Ability<br/>
                <input type="text" <?php getnv("DamageAbilityText" . $i); ?> class="full bottomborder"/>
            </div>
        </div>
        <div class="row">
            <div class="right">
                <div class="attr">
                    <span class="smalllabel">Abil<br/></span>
                    <input type="text" <?php getnv("DamageAbility" . $i); ?> pattern="\d*" class="xtiny" onchange="updateDamage(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Feat<br/></span>
                    <input type="text" <?php getnv("DamageFeat" . $i); ?> pattern="\d*" class="xtiny" onchange="updateDamage(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Enh<br/></span>
                    <input type="text" <?php getnv("DamageEnhance" . $i); ?> pattern="\d*" class="xtiny" onchange="updateDamage(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <?php getnv("DamageMisc1" . $i); ?> pattern="\d*" class="xtiny" onchange="updateDamage(<?= $i ?>);"/>
                </div>
                <div class="attr">
                    <span class="smalllabel">Misc<br/></span>
                    <input type="text" <?php getnv("DamageMisc2" . $i); ?> pattern="\d*" class="xtiny" onchange="updateDamage(<?= $i ?>);"/>
                </div>
            </div>
            <div class="attr total">
                <span class="smalllabel">Bonus<br/></span>
                <input type="text" <?php getnv("Damage" . $i); ?> class="tiny" readonly/>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- ======================================== -->
    <!-- Basic Attacks -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Basic Attacks</h2>
        <?php for( $i = 1; $i <= 4; $i++ )  { ?>
        <div class="row">
            <div class="attr">
                <?php if( $i == 1 ) { ?><span class="smalllabel">Attack<br/></span><?php } ?>
                <input type="text" <?php getnv("BasicAttackAttack" . $i); ?> pattern="\d*" class="tiny"/>
            </div>
            <div class="attr">
                <span class="smalllabel"><?php if( $i == 1 ) { ?><br/><?php } ?>VS</span>
            </div>
            <div class="attr">
                <?php if( $i == 1 ) { ?><span class="smalllabel">Defense<br/></span><?php } ?>
                <input type="text" <?php getnv("BasicAttackDefense" . $i); ?> class="tiny"/>
            </div>
            <div class="attr">
                <?php if( $i == 1 ) { ?><span class="smalllabel">Weapon/Power<br/></span><?php } ?>
                <input type="text" <?php getnv("BasicAttackWeapon" . $i); ?> class="third bottomborder"/>
            </div>
            <div class="attr">
                <?php if( $i == 1 ) { ?><span class="smalllabel">Damage<br/></span><?php } ?>
                <input type="text" <?php getnv("BasicAttackDamage" . $i); ?> class="small bottomborder"/>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- ======================================== -->
    <!-- Feats -->
    <!-- ======================================== -->
    <div class="section">
        <h2>Feats</h2>
        <div class="attr textleft">
            <textarea <?php getn("Feats"); ?> class="full feats"><?php getv("Feats"); ?></textarea>
        </div>
        
    </div>
</div>

<div class="page">&nbsp;</div>

<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- SECOND PAGE - FIRST COLUMN -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<!-- ======================================== -->
<div class="column">
    <div class="section">
        <h2>Power Index</h2>
        <div class="attr whole">
            <em>List your powers below.<br/>
            Check the box when the power is used.<br/>
            Clear the box when the power renews.</em>
        </div>
    </div>
    
    <div class="section">
        <h2>At-Will Powers</h2>
        <?php for( $i = 1; $i <= 6; $i++ ) { ?>
        <div class="row">
            <div class="attr">
                <input type="text" <?php getnv("AtWillPower" . $i); ?> class="full bottomborder"/>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <div class="section">
        <h2>Encounter Powers</h2>
        <?php for( $i = 1; $i <= 6; $i++ ) { ?>
        <div class="row">
            <div class="attr">
                <input type="text" <?php getnv("EncounterPower" . $i); ?> class="fullpower bottomborder"/>
                <input type="checkbox" <?php getnc("EncounterPowerUsed" . $i); ?>/>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <div class="section">
        <h2>Daily Powers</h2>
        <?php for( $i = 1; $i <= 6; $i++ ) { ?>
        <div class="row">
            <div class="attr">
                <input type="text" <?php getnv("DailyPower" . $i); ?> class="fullpower bottomborder"/>
		<input type="checkbox" <?php getnc("DailyPowerUsed" . $i); ?>/>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <div class="section">
        <h2>Utility Powers</h2>
        <?php for( $i = 1; $i <= 8; $i++ ) { ?>
        <div class="row">
            <div class="attr">
                <input type="text" <?php getnv("UtilityPower" . $i); ?> class="fullpower bottomborder"/>
                <input type="checkbox" <?php getnc("UtilityPowerUsed" . $i); ?>/>
            </div>
        </div>
        <?php } ?>
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
    <div class="section">
        <h2>Magic Item Index</h2>
        <div class="attr whole">
            <em>List your powers below.<br/>
            Check the box when the power is used.<br/>
            Clear the box when the power renews.</em>
        </div>
    </div>
    
    <div class="section">
        <h2>Magic Items</h2>
        <?php 
            $titles = array("Weapon","Weapon","Weapon","Weapon","Armor","Arms","Feet","Hands","Head","Neck","Ring","Ring","Waist");
            for( $i = 1; $i <= 25; $i++ ) { 
        ?>
        <div class="row">
            <div class="attr">
                <?php 
                   $className = "fullpower";
                   if( $i <= sizeof($titles) ) { 
                       $className = "shortpower";
                ?>
                <div class="itemlabel textleft"><?= $titles[$i - 1] ?></div>
                <?php } ?>
                <input type="text" <?php getnv("MagicItem" . $i); ?> class="<?= $className ?> bottomborder"/>
                <input type="checkbox" <?php getnc("MagicItemUsed" . $i); ?>/>
            </div>
        </div>
        <?php } ?>
        
        <div class="row">
            <div class="attr whole">
                <span class="mediumlabel"><em>Daily Item Powers Per Day</em></span>
            </div>
        </div>
        
        <div class="row">
            <div class="powertitle">Heroic 1-10</div>
            <div class="powercheck">
                <input type="text" <?php getnv("HeroicCheck1"); ?> class="xxtiny" maxlength="1"/>
            </div>
            <div class="powertitletwo">Milestone</div>
            <div class="powerchecktwo">
                <input type="text" <?php getnv("HeroicMilestone1"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("HeroicMilestone2"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("HeroicMilestone3"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("HeroicMilestone4"); ?> class="xxtiny" maxlength="1"/>
            </div>
        </div>

        <div class="row">
            <div class="powertitle">Paragon 11-20</div>
            <div class="powercheck">
                <input type="text" <?php getnv("ParagonCheck1"); ?> class="xxtiny" maxlength="1"/>
                <input type="text" <?php getnv("ParagonCheck2"); ?> class="xxtiny" maxlength="1"/>
            </div>
            <div class="powertitletwo">Milestone</div>
            <div class="powerchecktwo">
                <input type="text" <?php getnv("ParagonMilestone1"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("ParagonMilestone2"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("ParagonMilestone3"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("ParagonMilestone4"); ?> class="xxtiny" maxlength="1"/>
            </div>
        </div>

        <div class="row">
            <div class="powertitle">Epic 21-30</div>
            <div class="powercheck">
                <input type="text" <?php getnv("EpicCheck1"); ?> class="xxtiny" maxlength="1"/>
                <input type="text" <?php getnv("EpicCheck2"); ?> class="xxtiny" maxlength="1"/>
                <input type="text" <?php getnv("EpicCheck3"); ?> class="xxtiny" maxlength="1"/>
            </div>
            <div class="powertitletwo">Milestone</div>
            <div class="powerchecktwo">
                <input type="text" <?php getnv("EpicMilestone1"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("EpicMilestone2"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("EpicMilestone3"); ?> class="xxtiny" maxlength="1"/>/
                <input type="text" <?php getnv("EpicMilestone4"); ?> class="xxtiny" maxlength="1"/>
            </div>
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
    <div id="charPic" style="display: none;">
    <img id="pic" src="" onclick="SetPic();"/>
    </div>
    
    <div id="noCharPic">
    <img id="pic" src="v4/click.png" onclick="SetPic();"/>
    </div>
    
    <div class="section">
        <h2>Money</h2>
    
        <div class="attr">
            <div class="cashtitle">Personal</div>
            <div class="cashtitle">Party</div>
        </div>
        <div class="attr">
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('CashAD' ); ?> /> ad
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('PartyCashAD' ); ?> /> ad
        </div>
        <div class="attr">
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('CashPP' ); ?> /> pp
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('PartyCashPP' ); ?> /> pp
        </div>
        <div class="attr">
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('CashGP' ); ?> /> gp
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('PartyCashGP' ); ?> /> gp
        </div>
        <div class="attr">
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('CashSP' ); ?> /> sp
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('PartyCashSP' ); ?> /> sp
        </div>
        <div class="attr">
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('CashCP' ); ?> /> cp
            <input onchange="sumCash();" pattern="\d*" class="cash" <?php getnv('PartyCashCP' ); ?> /> cp
        </div>
        <div class="attr whole">
            <hr/>
        </div>
        <div class="attr">
            <input class="cash" <?php getnv('CashTotal' ); ?> readonly/> gp
            <input class="cash" <?php getnv('PartyCashTotal' ); ?> readonly/>gp
        </div>
        <div class="attr">
            <textarea class="full money" <?php getn("MoneyText"); ?>><?php getv("MoneyText"); ?></textarea>
        </div>
    </div>
    
    <div class="section">
        <h2>Equipment</h2>
        <div class="attr">
            <textarea class="full equipment" <?php getn("Equipment"); ?>><?php getv("Equipment"); ?></textarea>
        </div>
    </div>
</div>

<br class="clear"/>

<div class="column">
    <div class="section">
        <h2>Rituals</h2>
        <?php for( $i = 1; $i <= 10; $i++ ) { ?>
        <div class="row">
            <div class="attr">
                <input type="text" <?php getnv("Ritual" . $i); ?> class="full bottomborder"/>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="twocolumn">
    <div class="attr whole">
        <h2>Notes</h2>
        <textarea <?php getn('Notes'); ?> class="whole notes" cols="10" rows="10"><?php getv('Notes'); ?></textarea>
    </div>
</div>

<?php if ($SHOWSAVE) { ?>
<div class="page">&nbsp;</div>

<!-- Notes -->
<input type="checkbox" <?php getnc('NotesDisp'); ?> onchange="ToggleDisplay('notes', this);" style="width:15px; border:none;"/>
Display Private Notes
<div id="notes">
    <!-- Private Notes -->
    <h2>Private Notes (Will not be displayed publically)</h2>
    <textarea <?php getn('PrivateNotes'); ?> class="whole privatenotes" cols="10" rows="10"><?php getv('PrivateNotes'); ?></textarea>
    
    <h2>Character Background (Will not be displayed publically)</h2>
    
    <textarea <?php getn('Background'); ?> class="whole privatenotes" cols="10" rows="10"><?php getv('Background'); ?></textarea>
</div>
<?php } ?>

<!-- Footer -->

          <div id="footer">
              <span class="right">4th Edition Character Sheet by Tarlen</span>
              Last saved = <span id="lastSavedDateDisplay"><?php getv("LastSaveDate"); ?></span>
          </div>

          <?php if ($SHOWSAVE) { ?>
          <div id="save">
            <input type="reset" value="Reset Changes" onclick="return confirm('Are you sure you want to reset the character sheet? You will lose all changes you made since you last saved.')" />
            &nbsp;&nbsp;
            <input type="submit" value="Save Changes" onclick="SetSaveDate(); Save(); return false;" />
          </div>
          <?php } ?>



</form>
</html>
