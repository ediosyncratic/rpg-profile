<?php echo('<?xml version="1.0" encoding="iso-5589-1"?>');?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!--
  3EProfiler (tm) character sheet source file.
  Copyright (C) 2003  Michael J. Eggertson.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  **
-->
  <head>
    <title><?php echo $TITLE; ?></title>
    <link type="text/css" rel="stylesheet" href="v3/main.css" />
    <style type="text/css" media="print">
      #save
      , #notes tr.header span
      {
          display: none;
      }
    </style>
    <script type="text/javascript">var READONLY = <?php echo $READONLY ? "true" : "false"; ?>;</script>
    <script type="text/javascript" src="./v3/general.js"></script>
    <script type="text/javascript" src="./v3/debug.js"></script>
    <script type="text/javascript" src="./v3/ogl/skills.js"></script>
    <script type="text/javascript" src="./v3/ogl/size.js"></script>
    <script type="text/javascript" src="./v3/ogl/capacity.js"></script>
    <script type="text/javascript" src="./v3/ogl/class.js"></script>
    <script type="text/javascript" src="./v3/skills.js"></script>
    <script type="text/javascript" src="./v3/ac.js"></script>
    <script type="text/javascript" src="./v3/ab.js"></script>
    <script type="text/javascript" src="./v3/saves.js"></script>
    <script type="text/javascript" src="./v3/capacity.js"></script>
    <script type="text/javascript" src="./v3/init.js"></script>
    <script type="text/javascript" src="./v3/gear.js"></script>
    <script type="text/javascript" src="./v3/abilities.js"></script>
    <script type="text/javascript" src="./v3/sheet.js"></script>
    <script type="text/javascript" src="./v3/spells.js"></script>
    <script type="text/javascript" src="./v3/xp.js"></script>
    <script type="text/javascript" src="./v3/level.js"></script>
    <script type="text/javascript" src="./v3/size.js"></script>
    <script type="text/javascript" src="./v3/class.js"></script>
    <script type="text/javascript" src="./v3/pic.js"></script>
    <script type="text/javascript" src="./v3/notes.js"></script>
  </head>
  <body onload="init()" onunload="cleanup()">

  <form action="save.php" method="post" id="charactersheet">

  <div>
    <input type="hidden" name="firstload" value="<?php echo isset($DATA['firstload']) ? "false" : "true"; ?>" />
    <input type="hidden" <?php getnv('PicURL'); ?> />
    <input type="hidden" name="id" value="<?php echo $CHARID; ?>" />
  </div>

    <table id="maintable">
      <tr>
        <td>
          <!-- Left buffer cell -->
        </td>
        <td id="main">

          <!--
            table#info contains all the general information on the
            character that's found at the top of the character sheet.
          -->

          <table id="info" cellspacing="0">
            <tr>
              <td colspan="2"><input type="text" <?php getnv('Name'); ?> /><br />Character Name</td>
              <td colspan="2"><input type="text" <?php getnv('Player'); ?> /><br />Player</td>
              <td><input type="text" <?php getnv('Campaign'); ?> /><br />Campaign</td>
              <td><input type="text" <?php getnv('XPCurrent'); ?> onchange="ApplyXPNext()" /><br />Current XP</td>
              <td><input type="text" <?php getnv('XPNext'); ?> /><br />Next Level XP</td>
              <td><input type="text" <?php getnv('XPChange'); ?> onchange="ApplyXPChange()" /><br />XP Change</td>
            </tr>
            <tr>
              <td colspan="2"><input type="text" <?php getnv('Class'); ?> /><br />Class</td>
              <td colspan="2"><input type="text" <?php getnv('Race'); ?> /><br />Race</td>
              <td colspan="2"><input type="text" <?php getnv('Alignment'); ?> /><br />Alignment</td>
              <td colspan="2"><input type="text" <?php getnv('Deity'); ?> /><br />Deity</td>
            </tr>
            <tr>
              <td class="unit"><input type="text" <?php getnv('Level'); ?> onchange="OnLevelChanged()" /><br />Level</td>
              <td class="unit"><input type="text" <?php getnv('Size'); ?> onchange="OnSizeChanged()" /><br />Size</td>
              <td class="unit"><input type="text" <?php getnv('Age'); ?> /><br />Age</td>
              <td class="unit"><input type="text" <?php getnv('Gender'); ?> /><br />Gender</td>
              <td class="unit"><input type="text" <?php getnv('Height'); ?> /><br />Height</td>
              <td class="unit"><input type="text" <?php getnv('Weight'); ?> /><br />Weight</td>
              <td class="unit"><input type="text" <?php getnv('Eyes'); ?> /><br />Eyes</td>
              <td class="unit"><input type="text" <?php getnv('Hair'); ?> /><br />Hair</td>
            </tr>
          </table>

          <!--
            table#stats contains the statblock, saves, the picture...
            The layout is 3 columns, 3 rows.

            *************************  1: Ability scores (rowspan=2)
            *       *               *  2: AC, HP (colspan=2)
            *       *       2       *  3: Initiative, speed, armor type
            *       *               *  4: Image, load (rowspan=2)
            *   1   *****************  5: Saves (colspan=2)
            *       *       *       *
            *       *   3   *       *
            *       *       *       *
            *****************   4   *
            *               *       *
            *       5       *       *
            *               *       *
            *************************
          -->

          <table id="stats" cellspacing="0">
            <tr>
              <td rowspan="2" class="unit top">
                
                <table id="statblock">
                  <tr>
                    <td class="header">Ability</td>
                    <td class="header">Score</td>
                    <td class="header">Mod</td>
                    <td class="header">Temp<br />Score</td>
                    <td class="header">Temp<br />Mod</td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Strength" class="help">STR</span></td>
                    <td><input type="text" <?php getnv('Str'); ?> class="mod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('StrMod'); ?> class="mod" /></td>
                    <td><input type="text" <?php getnv('StrTemp'); ?> class="tempmod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('StrTempMod'); ?> class="tempmod" /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Dexterity" class="help">DEX</span></td>
                    <td><input type="text" <?php getnv('Dex'); ?> class="mod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('DexMod'); ?> class="mod" /></td>
                    <td><input type="text" <?php getnv('DexTemp'); ?> class="tempmod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('DexTempMod'); ?> class="tempmod" /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Constitution" class="help">CON</span></td>
                    <td><input type="text" <?php getnv('Con'); ?> class="mod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('ConMod'); ?> class="mod" /></td>
                    <td><input type="text" <?php getnv('ConTemp'); ?> class="tempmod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('ConTempMod'); ?> class="tempmod" /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Intelligence" class="help">INT</span></td>
                    <td><input type="text" <?php getnv('Int'); ?> class="mod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('IntMod'); ?> class="mod" /></td>
                    <td><input type="text" <?php getnv('IntTemp'); ?> class="tempmod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('IntTempMod'); ?> class="tempmod" /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Wisdom" class="help">WIS</span></td>
                    <td><input type="text" <?php getnv('Wis'); ?> class="mod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('WisMod'); ?> class="mod" /></td>
                    <td><input type="text" <?php getnv('WisTemp'); ?> class="tempmod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('WisTempMod'); ?> class="tempmod" /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Charisma" class="help">CHA</span></td>
                    <td><input type="text" <?php getnv('Cha'); ?> class="mod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('ChaMod'); ?> class="mod" /></td>
                    <td><input type="text" <?php getnv('ChaTemp'); ?> class="tempmod" onchange="OnAbilityChanged(this)" /></td>
                    <td><input type="text" <?php getnv('ChaTempMod'); ?> class="tempmod" /></td>
                  </tr>
                </table>

              </td>
              <td colspan="2" class="top">
                
                <table id="hp">
                  <tr>
                    <td />
                    <td class="header">TOTAL</td>
                    <td />
                    <td class="header" colspan="7">Current HP</td>
                    <td />
                    <td class="header" colspan="5">Nonlethal Damage</td>
                    <td />
                    <td class="header"><span title="Damage Reduction" class="help">Dmg<br />Red</span></td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Hit Points" class="help">HP</span></td>
                    <td><input type="text" <?php getnv('HP'); ?> /></td>
                    <td />
                    <td colspan="7"><input type="text" <?php getnv('HPWounds'); ?> /></td>
                    <td />
                    <td colspan="5"><input type="text" <?php getnv('HPSub'); ?> /></td>
                    <td />
                    <td><input type="text" <?php getnv('DamageRed'); ?> /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span title="Armor Class" class="help">AC</span></td>
                    <td class="unit"><input type="text" <?php getnv('AC'); ?> /></td>
                    <td class="char">=</td>
                    <td class="basenum"><span>10</span></td>
                    <td class="char">+</td>
                    <td class="unit"><input type="text" <?php getnv('ACArmor'); ?> onchange="ACCalc()" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input type="text" <?php getnv('ACShield'); ?> onchange="ACCalc()" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input type="text" <?php getnv('ACDex'); ?> onchange="ACCalc()" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input type="text" <?php getnv('ACSize'); ?> onchange="ACCalc()" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input type="text" <?php getnv('ACDeflect'); ?> onchange="ACCalc()" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input type="text" <?php getnv('ACNat'); ?> onchange="ACCalc()" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td class="unit"><input type="text" <?php getnv('ACMisc'); ?> onchange="ACCalc()" /></td>
                  </tr>
                  <tr>
                    <td />
                    <td class="footer">TOTAL</td>
                    <td />
                    <td />
                    <td />
                    <td class="footer">Armor</td>
                    <td />
                    <td class="footer">Shield</td>
                    <td />
                    <td class="footer">Dex</td>
                    <td />
                    <td class="footer">Size</td>
                    <td />
                    <td class="footer">Natural</td>
                    <td />
                    <td class="footer">Deflect</td>
                    <td />
                    <td class="footer">Misc</td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td class="unit bottom">
                
                <table id="init">
                  <tr>
                    <td />
                    <td class="header">Total</td>
                    <td />
                    <td class="header">Dex</td>
                    <td />
                    <td class="header">Misc</td>
                  </tr>
                  <tr>
                    <td class="tag"><span class="help" title="Initiative">INIT</span></td>
                    <td class="unit"><input type="text" <?php getnv('Init'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input type="text" <?php getnv('InitDex'); ?> onchange="InitCalc()" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input type="text" <?php getnv('InitMisc'); ?> onchange="InitCalc()" /></td>
                  </tr>
                </table>

                <table id="speed">
                  <tr>
                    <td><input type="text" <?php getnv('Speed'); ?> /></td>
                    <td><input type="text" <?php getnv('Armor'); ?> /></td>
                  </tr>
                  <tr>
                    <td class="footer">Speed</td>
                    <td class="footer">Armor Type</td>
                  </tr>
                </table>

              </td>
              <td rowspan="2">
              
                <table id="imgload">
                  <tr>
                    <td rowspan="6" class="piccell"><img id="pic" src="v3/click.png" alt="Character Portrait" onclick="SetPic()" /></td>
                    <td class="loadtext title">Light<br />Load</td>
                    <td class="loadinputs"><input type="text" <?php getnv('LightLoad'); ?> /></td>
                  </tr>
                  <tr>
                    <td class="loadtext title">Med<br />Load</td>
                    <td><input type="text" <?php getnv('MediumLoad'); ?> /></td>
                  </tr>
                  <tr>
                    <td class="loadtext title">Max<br />Load</td>
                    <td><input type="text" <?php getnv('HeavyLoad'); ?> /></td>
                  </tr>
                  <tr>
                    <td class="loadtext title">Over<br />Head</td>
                    <td><input type="text" <?php getnv('LiftOverHead'); ?> /></td>
                  </tr>
                  <tr>
                    <td class="loadtext title">Off<br />Ground</td>
                    <td><input type="text" <?php getnv('LiftOffGround'); ?> /></td>
                  </tr>
                  <tr>
                    <td class="loadtext title">Push/<br />Drag</td>
                    <td><input type="text" <?php getnv('LiftPushDrag'); ?> /></td>
                  </tr>
                </table>
              
              </td>
            </tr>
            <tr>
              <td colspan="2" class="bottom">
              
                <table id="saves">
                  <tr>
                    <td class="header">Saving Throws</td>
                    <td />
                    <td class="header">Total</td>
                    <td />
                    <td class="header">Base</td>
                    <td />
                    <td class="header">Ability<br />Mod</td>
                    <td />
                    <td class="header">Magic<br />Mod</td>
                    <td />
                    <td class="header">Misc<br />Mod</td>
                    <td />
                    <td class="header">Temp<br />Mod</td>
                  </tr>
                  <tr>
                    <td class="tag"><span class="help" title="Fortitude: Based on Constitution">FORTITUDE</span></td>
                    <td />
                    <td class="unit"><input type="text" <?php getnv('Fort'); ?> /></td>
                    <td class="char"><span class="dark">=</span></td>
                    <td class="unit"><input type="text" <?php getnv('FortBase'); ?> onchange="SaveCalc('Fort')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td class="unit"><input type="text" <?php getnv('FortAbility'); ?> onchange="SaveCalc('Fort')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td class="unit"><input type="text" <?php getnv('FortMagic'); ?> onchange="SaveCalc('Fort')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td class="unit"><input type="text" <?php getnv('FortMisc'); ?> onchange="SaveCalc('Fort')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td class="unit"><input type="text" class="temp" <?php getnv('FortTemp'); ?> onchange="SaveCalc('Fort')" /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span class="help" title="Reflex: Based on Dexterity">REFLEX</span></td>
                    <td />
                    <td><input type="text" <?php getnv('Reflex'); ?> /></td>
                    <td class="char"><span class="dark">=</span></td>
                    <td><input type="text" <?php getnv('ReflexBase'); ?> onchange="SaveCalc('Reflex')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" <?php getnv('ReflexAbility'); ?> onchange="SaveCalc('Reflex')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" <?php getnv('ReflexMagic'); ?> onchange="SaveCalc('Reflex')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" <?php getnv('ReflexMisc'); ?> onchange="SaveCalc('Reflex')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" class="temp" <?php getnv('ReflexTemp'); ?> onchange="SaveCalc('Reflex')" /></td>
                  </tr>
                  <tr>
                    <td class="tag"><span class="big help" title="Will: Based on Wisdom">WILL</span></td>
                    <td />
                    <td><input type="text" <?php getnv('Will'); ?> /></td>
                    <td class="char"><span class="dark">=</span></td>
                    <td><input type="text" <?php getnv('WillBase'); ?> onchange="SaveCalc('Will')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" <?php getnv('WillAbility'); ?> onchange="SaveCalc('Will')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" <?php getnv('WillMagic'); ?> onchange="SaveCalc('Will')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" <?php getnv('WillMisc'); ?> onchange="SaveCalc('Will')" /></td>
                    <td class="char"><span class="dark">+</span></td>
                    <td><input type="text" class="temp" <?php getnv('WillTemp'); ?> onchange="SaveCalc('Will')" /></td>
                  </tr>
                </table>

              </td>
            </tr>
          </table>

          <!--
            table#attacks contains the base melee and ranged attack bonuses.
          -->

          <table id="attacks">
            <tr>
              <td />
              <td class="header">Total Attack Bonus</td>
              <td />
              <td class="header">Base Attack Bonus</td>
              <td />
              <td class="header">Str Mod</td>
              <td />
              <td class="header">Size Mod</td>
              <td />
              <td class="header">Misc Mod</td>
              <td />
              <td class="header">Temp Mod</td>
            </tr>
            <tr>
              <td class="tag"><span class="help" title="Melee Attack Bonus">MELEE</span></td>
              <td class="wide"><input type="text" <?php getnv('MBAB'); ?> /></td>
              <td class="char">=</td>
              <td class="wide"><input type="text" <?php getnv('MABBase'); ?> onchange="MBABCalc(); SetBAB(this);" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" <?php getnv('MABStr'); ?> onchange="MBABCalc()" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" <?php getnv('MABSize'); ?> onchange="MBABCalc()" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" <?php getnv('MABMisc'); ?> onchange="MBABCalc()" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" class="temp" <?php getnv('MABTemp'); ?> onchange="MBABCalc()" /></td>
            </tr>
            <tr>
              <td class="tag"><span class="help" title="Ranged Attack Bonus">RANGED</span></td>
              <td class="wide"><input type="text" <?php getnv('RBAB'); ?> /></td>
              <td class="char">=</td>
              <td class="wide"><input type="text" <?php getnv('RABBase'); ?> onchange="RBABCalc(); SetBAB(this)" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" <?php getnv('RABDex'); ?> onchange="RBABCalc()" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" <?php getnv('RABSize'); ?> onchange="RBABCalc()" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" <?php getnv('RABMisc'); ?> onchange="RBABCalc()" /></td>
              <td class="char">+</td>
              <td class="unit"><input type="text" class="temp" <?php getnv('RABTemp'); ?> onchange="RBABCalc()" /></td>
            </tr>
            <tr>
              <td />
              <td class="footer">Total Attack Bonus</td>
              <td />
              <td class="footer">Base Attack Bonus</td>
              <td />
              <td class="footer">Dex Mod</td>
              <td />
              <td class="footer">Size Mod</td>
              <td />
              <td class="footer">Misc Mod</td>
              <td />
              <td class="footer">Temp Mod</td>
            </tr>
          </table>
          
          <!--
            table.weapon are weapon slots.
          -->

          <table class="weapon" cellspacing="0">
            <tr class="header">
              <td class="type wide">Weapon</td>
              <td class="wide">Total Attack Bonus</td>
              <td class="medium">Damage</td>
              <td class="small">Critical</td>
              <td class="small">Range</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('Weapon1'); ?> /></td>
              <td><input <?php getnv('Weapon1AB'); ?> /></td>
              <td><input <?php getnv('Weapon1Damage'); ?> /></td>
              <td><input <?php getnv('Weapon1Crit'); ?> /></td>
              <td><input <?php getnv('Weapon1Range'); ?> /></td>
            </tr>
            <tr class="header">
              <td>Special Properties</td>
              <td>Ammunition</td>
              <td>Weight</td>
              <td>Size</td>
              <td>Type</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('Weapon1Special'); ?> /></td>
              <td><input <?php getnv('Weapon1Ammo'); ?> /></td>
              <td><input <?php getnv('Weapon1Weight'); ?> /></td>
              <td><input <?php getnv('Weapon1Size'); ?> /></td>
              <td><input <?php getnv('Weapon1Type'); ?> /></td>
            </tr>
          </table>

          <table class="weapon" cellspacing="0">
            <tr class="header">
              <td class="type wide">Weapon</td>
              <td class="wide">Total Attack Bonus</td>
              <td class="medium">Damage</td>
              <td class="small">Critical</td>
              <td class="small">Range</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('Weapon2'); ?> /></td>
              <td><input <?php getnv('Weapon2AB'); ?> /></td>
              <td><input <?php getnv('Weapon2Damage'); ?> /></td>
              <td><input <?php getnv('Weapon2Crit'); ?> /></td>
              <td><input <?php getnv('Weapon2Range'); ?> /></td>
            </tr>
            <tr class="header">
              <td>Special Properties</td>
              <td>Ammunition</td>
              <td>Weight</td>
              <td>Size</td>
              <td>Type</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('Weapon2Special'); ?> /></td>
              <td><input <?php getnv('Weapon2Ammo'); ?> /></td>
              <td><input <?php getnv('Weapon2Weight'); ?> /></td>
              <td><input <?php getnv('Weapon2Size'); ?> /></td>
              <td><input <?php getnv('Weapon2Type'); ?> /></td>
            </tr>
          </table>

          <table class="weapon" cellspacing="0">
            <tr class="header">
              <td class="type wide">Weapon</td>
              <td class="wide">Total Attack Bonus</td>
              <td class="medium">Damage</td>
              <td class="small">Critical</td>
              <td class="small">Range</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('Weapon3'); ?> /></td>
              <td><input <?php getnv('Weapon3AB'); ?> /></td>
              <td><input <?php getnv('Weapon3Damage'); ?> /></td>
              <td><input <?php getnv('Weapon3Crit'); ?> /></td>
              <td><input <?php getnv('Weapon3Range'); ?> /></td>
            </tr>
            <tr class="header">
              <td>Special Properties</td>
              <td>Ammunition</td>
              <td>Weight</td>
              <td>Size</td>
              <td>Type</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('Weapon3Special'); ?> /></td>
              <td><input <?php getnv('Weapon3Ammo'); ?> /></td>
              <td><input <?php getnv('Weapon3Weight'); ?> /></td>
              <td><input <?php getnv('Weapon3Size'); ?> /></td>
              <td><input <?php getnv('Weapon3Type'); ?> /></td>
            </tr>
          </table>
          
          <!--
            table.armor are armor slots.
          -->

          <table class="armor" cellspacing="0">
            <tr class="header">
              <td class="type wide">Armor/Protective Item</td>
              <td class="small">Type</td>
              <td class="small">AC Bonus</td>
              <td class="small">Check Pen</td>
              <td class="small">Max Dex</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('ArmorName'); ?> /></td>
              <td><input <?php getnv('ArmorType'); ?> /></td>
              <td><input <?php getnv('ArmorBonus'); ?> onchange="ACChangeArmor()" /></td>
              <td><input <?php getnv('ArmorCheck'); ?> /></td>
              <td><input <?php getnv('ArmorDex'); ?> /></td>
            </tr>
            <tr class="header">
              <td colspan="2">Special Properties</td>
              <td>Weight</td>
              <td>Spell Fail</td>
              <td>Speed</td>
            </tr>
            <tr>
              <td colspan="2"><input class="left" <?php getnv('ArmorSpecial'); ?> /></td>
              <td><input <?php getnv('ArmorWeight'); ?> /></td>
              <td><input <?php getnv('ArmorSpell'); ?> /></td>
              <td><input <?php getnv('ArmorSpeed'); ?> /></td>
            </tr>
          </table>

          <table class="armor" cellspacing="0">
            <tr class="header">
              <td class="type wide">Shield/Protective Item</td>
              <td class="small">Type</td>
              <td class="small">AC Bonus</td>
              <td class="small">Check Pen</td>
              <td class="small">Max Dex</td>
            </tr>
            <tr>
              <td><input class="left" <?php getnv('ShieldName'); ?> /></td>
              <td><input <?php getnv('ShieldType'); ?> /></td>
              <td><input <?php getnv('ShieldBonus'); ?> onchange="ACChangeShield()" /></td>
              <td><input <?php getnv('ShieldCheck'); ?> /></td>
              <td><input <?php getnv('ShieldDex'); ?> /></td>
            </tr>
            <tr class="header">
              <td colspan="2">Special Properties</td>
              <td>Weight</td>
              <td>Spell Fail</td>
              <td>Speed</td>
            </tr>
            <tr>
              <td colspan="2"><input class="left" <?php getnv('ShieldSpecial'); ?> /></td>
              <td><input <?php getnv('ShieldWeight'); ?> /></td>
              <td><input <?php getnv('ShieldSpell'); ?> /></td>
              <td><input <?php getnv('ShieldSpeed'); ?> /></td>
            </tr>
          </table>
          


          <!--
            table#skillsandgear holds both the skills and gear tables
          -->

          <table id="skillsandgear">
            <tr>
              <td id="skillcontainer">

                <table id="skills" cellspacing="0" cellpadding="0" onmouseover="Show('skillcontext', true)" onmouseout="Show('skillcontext', false)">
                  <tr class="title">
                    <td colspan="10">
                      <div id="skillranks">
                        <div>
                          <input type="text" <?php getnv('MaxRank'); ?> />/<input type="text" <?php getnv('MaxRankCC'); ?> />
                        </div>
                        Max Rank
                      </div>
                      Skills
                      <span id="skillcontext">
                      <?php if (!$READONLY) { ?>
                        [ <a href="javascript:SkillAutoFill()" title="Fill table with the core 3.5E skills.">Auto Fill</a> | <a href="javascript:SkillsUpdateCC();" title="Determine which skills are class skills.">Update CC</a> | <a href="javascript:SkillClear()" title="Clear the entire contents of this table.">Clear</a> ]
                      <?php } ?>
                      </span>
                    </td>
                  </tr>
                  <tr class="header">
                    <td class="name"><a href="javascript:SkillSort(SkillSort.ByName)" title="Sort by Skill Name">Skill Name</a></td>
                    <td><a href="javascript:SkillSort(SkillSort.ByAbility)" title="Sort by Key Ability">Key<br />Ab</a></td>
                    <td><a href="javascript:SkillSort(SkillSort.ByCC)" title="Sort by Cross Class">CC</a></td>
                    <td><a href="javascript:SkillSort(SkillSort.ByMod)" title="Sort by Skill Modifier">Skill<br />Mod</a></td>
                    <td />
                    <td><a href="javascript:SkillSort(SkillSort.ByAbMod)" title="Sort by Ability Modifier">Ab<br />Mod</a></td>
                    <td />
                    <td><a href="javascript:SkillSort(SkillSort.ByRank)" title="Sort by Rank">Rank</a></td>
                    <td />
                    <td><a href="javascript:SkillSort(SkillSort.ByMisc)" title="Sort by Miscelaneous Modifier">Misc<br />Mod</a></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill01'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill01Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill01CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill01Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill01AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill01Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill01MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill02'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill02Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill02CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill02Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill02AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill02Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill02MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill03'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill03Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill03CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill03Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill03AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill03Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill03MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill04'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill04Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill04CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill04Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill04AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill04Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill04MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill05'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill05Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill05CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill05Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill05AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill05Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill05MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill06'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill06Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill06CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill06Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill06AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill06Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill06MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill07'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill07Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill07CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill07Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill07AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill07Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill07MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill08'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill08Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill08CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill08Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill08AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill08Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill08MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill09'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill09Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill09CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill09Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill09AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill09Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill09MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill10'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill10Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill10CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill10Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill10AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill10Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill10MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill11'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill11Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill11CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill11Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill11AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill11Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill11MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill12'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill12Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill12CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill12Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill12AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill12Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill12MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill13'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill13Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill13CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill13Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill13AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill13Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill13MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill14'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill14Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill14CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill14Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill14AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill14Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill14MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill15'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill15Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill15CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill15Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill15AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill15Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill15MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill16'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill16Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill16CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill16Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill16AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill16Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill16MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill17'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill17Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill17CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill17Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill17AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill17Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill17MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill18'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill18Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill18CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill18Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill18AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill18Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill18MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill19'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill19Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill19CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill19Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill19AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill19Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill19MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill20'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill20Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill20CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill20Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill20AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill20Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill20MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill21'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill21Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill21CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill21Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill21AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill21Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill21MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill22'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill22Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill22CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill22Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill22AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill22Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill22MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill23'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill23Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill23CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill23Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill23AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill23Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill23MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill24'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill24Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill24CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill24Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill24AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill24Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill24MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill25'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill25Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill25CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill25Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill25AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill25Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill25MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill26'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill26Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill26CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill26Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill26AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill26Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill26MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill27'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill27Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill27CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill27Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill27AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill27Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill27MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill28'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill28Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill28CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill28Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill28AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill28Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill28MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill29'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill29Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill29CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill29Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill29AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill29Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill29MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill30'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill30Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill30CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill30Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill30AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill30Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill30MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill31'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill31Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill31CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill31Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill31AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill31Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill31MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill32'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill32Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill32CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill32Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill32AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill32Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill32MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill33'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill33Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill33CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill33Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill33AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill33Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill33MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill34'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill34Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill34CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill34Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill34AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill34Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill34MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill35'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill35Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill35CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill35Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill35AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill35Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill35MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill36'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill36Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill36CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill36Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill36AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill36Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill36MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill37'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill37Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill37CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill37Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill37AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill37Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill37MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill38'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill38Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill38CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill38Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill38AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill38Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill38MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill39'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill39Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill39CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill39Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill39AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill39Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill39MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill40'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill40Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill40CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill40Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill40AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill40Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill40MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill41'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill41Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill41CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill41Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill41AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill41Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill41MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill42'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill42Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill42CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill42Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill42AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill42Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill42MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill43'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill43Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill43CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill43Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill43AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill43Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill43MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill44'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill44Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill44CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill44Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill44AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill44Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill44MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill45'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill45Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill45CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill45Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill45AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill45Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill45MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill46'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill46Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill46CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill46Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill46AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill46Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill46MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill47'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill47Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill47CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill47Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill47AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill47Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill47MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill48'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill48Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill48CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill48Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill48AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill48Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill48MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill49'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill49Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill49CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill49Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill49AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill49Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill49MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill50'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill50Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill50CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill50Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill50AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill50Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill50MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="skillslot">
                    <td class="name"><input class="text" type="text" <?php getnv('Skill51'); ?> onchange="SkillLookUp(this)" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill51Ab'); ?> onchange="SkillLookUpKeyAb(this)" /></td>
                    <td class="char"><input class="chk" type="checkbox" <?php getnc('Skill51CC'); ?> onchange="SkillCalcRanks()" /></td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill51Mod'); ?> /></td>
                    <td class="char">=</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill51AbMod'); ?> onchange="SkillCalc(this)" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill51Rank'); ?> onchange="SkillCalc(this);SkillCalcRanks();" /></td>
                    <td class="char">+</td>
                    <td class="unit"><input class="text" type="text" <?php getnv('Skill51MiscMod'); ?> onchange="SkillCalc(this)" /></td>
                  </tr>
                  <tr class="footer">
                    <td>Total Skill Points:</td>
                    <td />
                    <td />
                    <td />
                    <td />
                    <td />
                    <td />
                    <td class="total"><span id="totalranks">0</span></td>
                    <td />
                    <td />
                  </tr>
                </table>

              </td>
              <td class="spacer"></td>

              <td id="featsandgearcontainer">

                <!--
                  table#feats is the feats table.
                -->
                <table id="feats">
                  <tr class="title">
                    <td colspan="4">Feats &amp; Special Abilities</td>
                  </tr>
                  <tr>
                    <td>
                      
                      <!--
                        Keep each column in a table to enforce a vertical tab order.
                        It's easier to do this rather than specify the tab order of
                        each of the thousand or so inputs.
                      -->

                      <table cellspacing="0">
                        <tr><td><input type="text" <?php getnv('Feat01'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat02'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat03'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat04'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat05'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat06'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat07'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat08'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat09'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat10'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat11'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat12'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat13'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat14'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat15'); ?> /></td></tr>
                      </table>

                    </td>
                    <td>
                      
                      <table cellspacing="0">
                        <tr><td><input type="text" <?php getnv('Feat16'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat17'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat18'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat19'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat20'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat21'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat22'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat23'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat24'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat25'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat26'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat27'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat28'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat29'); ?> /></td></tr>
                        <tr><td><input type="text" <?php getnv('Feat30'); ?> /></td></tr>
                      </table>
                    
                    </td>

                  </tr>
                </table>

                <table id="gear" cellspacing="0">
                  <tr class="title">
                    <td colspan="3">Other Possessions</td>
                  </tr>
                  <tr class="header">
                    <td class="name"><a href="javascript:GearSort(GearSort.ByName)" title="Sort by Item">Item</a></td>
                    <td class="unit"><a href="javascript:GearSort(GearSort.ByWeight)" title="Sort by Weight">Weight<br />(lbs)</a></td>
                    <td class="unit"><a href="javascript:GearSort(GearSort.ByLoc)" title="Sort by Location">Loc</a></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear01'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear01W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear01Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear02'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear02W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear02Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear03'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear03W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear03Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear04'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear04W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear04Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear05'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear05W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear05Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear06'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear06W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear06Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear07'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear07W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear07Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear08'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear08W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear08Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear09'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear09W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear09Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear10'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear10W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear10Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear11'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear11W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear11Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear12'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear12W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear12Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear13'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear13W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear13Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear14'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear14W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear14Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear15'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear15W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear15Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear16'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear16W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear16Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear17'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear17W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear17Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear18'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear18W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear18Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear19'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear19W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear19Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear20'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear20W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear20Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear21'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear21W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear21Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear22'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear22W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear22Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear23'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear23W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear23Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear24'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear24W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear24Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear25'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear25W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear25Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear26'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear26W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear26Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear27'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear27W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear27Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear28'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear28W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear28Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear29'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear29W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear29Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear30'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear30W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear30Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear31'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear31W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear31Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear32'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear32W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear32Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear33'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear33W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear33Loc'); ?> /></td>
                  </tr>
                  <tr class="slot">
                    <td><input class="name" type="text" <?php getnv('Gear34'); ?> /></td>
                    <td><input type="text" <?php getnv('Gear34W'); ?> onchange="CalcWeight()" /></td>
                    <td><input type="text" <?php getnv('Gear34Loc'); ?> /></td>
                  </tr>
                  <tr class="footer">
                    <td>Total Weight:</td>
                    <td class="total"><span id="totalweight">0</span></td>
                    <td />
                  </tr>
                </table>

              </td>
            </tr>
          </table>

          <!--
            Page 3 stuff, Spell Saves, Spells & Powers, Currency, Language...
          -->

          <table id="spellstuff" cellspacing="0">
            <tr>
              <td class="saves">

                <table id="spellsaves" cellspacing="0">
                  <tr class="title">
                    <td colspan="4">Spell Saves</td>
                  </tr>
                  <tr class="header">
                    <td>Save<br />DC</td>
                    <td class="level">LEVEL</td>
                    <td>Spells<br />/Day</td>
                    <td>Bonus<br />Spells</td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC0'); ?> /></td>
                    <td class="level">0</td>
                    <td><input type="text" <?php getnv('SpellPerDay0'); ?> /></td>
                    <td class="noinput">0</td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC1'); ?> /></td>
                    <td class="level">1st</td>
                    <td><input type="text" <?php getnv('SpellPerDay1'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells1'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC2'); ?> /></td>
                    <td class="level">2nd</td>
                    <td><input type="text" <?php getnv('SpellPerDay2'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells2'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC3'); ?> /></td>
                    <td class="level">3rd</td>
                    <td><input type="text" <?php getnv('SpellPerDay3'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells3'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC4'); ?> /></td>
                    <td class="level">4th</td>
                    <td><input type="text" <?php getnv('SpellPerDay4'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells4'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC5'); ?> /></td>
                    <td class="level">5th</td>
                    <td><input type="text" <?php getnv('SpellPerDay5'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells5'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC6'); ?> /></td>
                    <td class="level">6th</td>
                    <td><input type="text" <?php getnv('SpellPerDay6'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells6'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC7'); ?> /></td>
                    <td class="level">7th</td>
                    <td><input type="text" <?php getnv('SpellPerDay7'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells7'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC8'); ?> /></td>
                    <td class="level">8th</td>
                    <td><input type="text" <?php getnv('SpellPerDay8'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells8'); ?> /></td>
                  </tr>
                  <tr class="save">
                    <td><input type="text" <?php getnv('SpellDC9'); ?> /></td>
                    <td class="level">9th</td>
                    <td><input type="text" <?php getnv('SpellPerDay9'); ?> /></td>
                    <td><input type="text" <?php getnv('BonusSpells9'); ?> /></td>
                  </tr>
                </table>

              </td>
              <td class="list" rowspan="3">

                <table id="spells" cellspacing="0">
                  <tr class="title">
                    <td colspan="2">Spells &amp; Powers</td>
                  </tr>
                  <tr>
                    <td colspan="4">

                      <table cellspacing="0" class="spellsknown">
                        <tr class="header">
                          <td colspan="5">Number of Spells/Powers Known (Bards, Sorcerers, Psions &amp; Psi Warriors)</td>
                        </tr>
                        <tr>
                          <td>0<input type="text" <?php getnv('SpellsKnown0'); ?> /></td>
                          <td>1st<input type="text" <?php getnv('SpellsKnown1'); ?> /></td>
                          <td>2nd<input type="text" <?php getnv('SpellsKnown2'); ?> /></td>
                          <td>3rd<input type="text" <?php getnv('SpellsKnown3'); ?> /></td>
                          <td>4th<input type="text" <?php getnv('SpellsKnown4'); ?> /></td>
                        </tr>
                        <tr>
                          <td>5th<input type="text" <?php getnv('SpellsKnown5'); ?> /></td>
                          <td>6th<input type="text" <?php getnv('SpellsKnown6'); ?> /></td>
                          <td>7th<input type="text" <?php getnv('SpellsKnown7'); ?> /></td>
                          <td>8th<input type="text" <?php getnv('SpellsKnown8'); ?> /></td>
                          <td>9th<input type="text" <?php getnv('SpellsKnown9'); ?> /></td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                  <tr>
                    <td>

                      <table cellspacing="0" class="spelllist">
                        <tr class="header">
                          <td><a href="javascript:SpellSort(SpellSort.ByName)" title="Sort by Spell Name">Spell Name</a></td>
                          <td class="mem"><a href="javascript:SpellSort(SpellSort.ByMem)" title="Sort by Number of times cast, memorized, or manifested"># Cast<br />/Mem</a></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell01'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell01Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell02'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell02Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell03'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell03Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell04'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell04Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell05'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell05Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell06'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell06Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell07'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell07Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell08'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell08Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell09'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell09Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell10'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell10Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell11'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell11Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell12'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell12Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell13'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell13Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell14'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell14Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell15'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell15Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell16'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell16Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell17'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell17Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell18'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell18Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell19'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell19Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell20'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell20Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell21'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell21Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell22'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell22Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell23'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell23Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell24'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell24Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell25'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell25Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell26'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell26Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell27'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell27Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell28'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell28Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell29'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell29Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell30'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell30Cast'); ?> /></td>
                        </tr>
                      </table>

                    </td>
                    <td>
                      
                      <table cellspacing="0" class="spelllist">
                        <tr class="header">
                          <td><a href="javascript:SpellSort(SpellSort.ByName)" title="Sort by Spell Name">Spell Name</a></td>
                          <td class="mem"><a href="javascript:SpellSort(SpellSort.ByMem)" title="Sort by Number of times cast, memorized, or manifested"># Cast<br />/Mem</a></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell31'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell31Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell32'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell32Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell33'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell33Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell34'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell34Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell35'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell35Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell36'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell36Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell37'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell37Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell38'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell38Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell39'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell39Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell40'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell40Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell41'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell41Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell42'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell42Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell43'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell43Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell44'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell44Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell45'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell45Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell46'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell46Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell47'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell47Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell48'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell48Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell49'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell49Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell50'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell50Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell51'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell51Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell52'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell52Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell53'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell53Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell54'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell54Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell55'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell55Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell56'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell56Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell57'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell57Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell58'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell58Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell59'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell59Cast'); ?> /></td>
                        </tr>
                        <tr>
                          <td class="name"><input type="text" <?php getnv('Spell60'); ?> /></td>
                          <td class="mem"><input type="text" <?php getnv('Spell60Cast'); ?> /></td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td class="currency">

                <table id="currency">
                  <tr class="title">
                    <td>Currency</td>
                  </tr>
                  <tr>
                    <td><textarea <?php getn('Cash'); ?> rows="10" cols="10"><?php getv('Cash'); ?></textarea></td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td class="languages">

                <table id="languages" cellspacing="0">
                  <tr class="title"><td>Languages</td></tr>
                  <tr><td><input type="text" <?php getnv('Lang1'); ?> /></td></tr>
                  <tr><td><input type="text" <?php getnv('Lang2'); ?> /></td></tr>
                  <tr><td><input type="text" <?php getnv('Lang3'); ?> /></td></tr>
                  <tr><td><input type="text" <?php getnv('Lang4'); ?> /></td></tr>
                  <tr><td><input type="text" <?php getnv('Lang5'); ?> /></td></tr>
                  <tr><td><input type="text" <?php getnv('Lang6'); ?> /></td></tr>
                  <tr><td><input type="text" <?php getnv('Lang7'); ?> /></td></tr>
                  <tr><td><input type="text" <?php getnv('Lang8'); ?> /></td></tr>
                </table>

              </td>
            </tr>
          </table>

          <table id="notes">
            <tr class="header">
              <td>
                Other Notes <span>[ <a href="javascript:ShowNotes();">Show Printable Version</a> ]</span>
              </td>
            </tr>
            <tr>
              <td><textarea <?php getn('Notes'); ?> cols="10" rows="10"><?php getv('Notes'); ?></textarea></td>
            </tr>
          </table>

          <div id="footer">
            3EProfiler&trade; Character Sheet, &copy; 2003 by M. J. Eggertson.
          </div>

          <?php if ($SHOWSAVE) { ?>
          <div id="save">
            <input type="reset" value="Reset Changes" onclick="return confirm('Are you sure you want to reset the character sheet? You will lose all changes you made since you last saved.')" />
            &nbsp;&nbsp;
            <input type="submit" value="Save Changes" />
          </div>
          <?php } ?>

        </td>
        <td>
          <!-- Right buffer cell -->
        </td>
      </tr>
    </table>

  </form>

  </body>
</html>
