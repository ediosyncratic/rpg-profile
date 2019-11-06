<?php echo('<?xml version="1.0" encoding="iso-5589-1"?>');?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!--
  3EProfiler (tm) character sheet source file.

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
  <?php

  $sheetVer = "0.3";

  // Lists for skills and traits.
  require_once("Serenity_Include.php");

  ?>

  <head>
    <title><?php echo $TITLE; 3.5 ?></title>
    <link type="text/css" rel="stylesheet" href="Serenity/main.css" />
    <style type="text/css" media="print">
      #save
      , #notes tr.header span
      {
          display: none;
      }
    </style>
    <script type="text/javascript">var READONLY = <?php echo $READONLY ? "true" : "false"; ?>;</script>
    <script type="text/javascript" src="./Serenity/attributes.js"></script>
    <script type="text/javascript" src="./Serenity/general.js"></script>
    <script type="text/javascript" src="./Serenity/sheet.js"></script>
    <script type="text/javascript" src="./Serenity/pic.js"></script>
  </head>
  <body onload="init()" onunload="cleanup()">
  <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

  <form action="save.php" method="post" id="charactersheet">

  <div>
    <input type="hidden" name="firstload" value="<?php echo isset($DATA['firstload']) ? "false" : "true"; ?>" />
    <input type="hidden" <?php getnv('PicURL'); ?> />
    <input type="hidden" name="id" value="<?php echo $CHARID; ?>" />
    <input type="hidden" <?php getnv('LastSaveDate'); ?> />
  </div>

<!-- Character -->

<div class="section">

<table>
<tr>
<td colspan="2"><input type="text" <?php getnv("Name"); ?> class="full"><br>Name</td>
<td><input type="text" <?php getnv("Player"); ?> class="full"><br>Player</td>
<td><input type="text" <?php getnv("Campaign"); ?> class="full"><br>Campaign</td>
<td rowspan="3" colspan="2">
<img src="Serenity/serenity_small.jpg">
</td>
</tr>
<tr>
<td><input type="text" <?php getnv("Occupation"); ?> class="full"><br>Occupation</td>
<td><input type="text" <?php getnv("HeroicLevel"); ?> class="full"><br>Heroic Level</td>
<td><input type="text" <?php getnv("PlotPoints"); ?> class="full"><br>Plot Points</td>
<td><input type="text" <?php getnv("AdvancementPoints"); ?> class="full"><br>Adv Points</td>
</tr>
<tr>
<td><input type="text" <?php getnv("Gender"); ?> class="full"><br>Gender</td>
<td><input type="text" <?php getnv("Height"); ?> class="full"><br>Height</td>
<td><input type="text" <?php getnv("Weight"); ?> class="full"><br>Weight</td>
<td><input type="text" <?php getnv("Age"); ?> class="full"><br>Age</td>
</tr>
</table>

</div>

<!-- Attributes & Character Image -->

<div class="section-half">
<h1>Attributes</h1>

<table class="attributes">
<tr>
<td class="label">Agility</td>
<td>d<input type="text" <?php getnv("Agility"); ?> class="medium" onchange="updateAttributes();"></td>
</tr>
<tr>
<td class="label">Strength</td>
<td>d<input type="text" <?php getnv("Strength"); ?> class="medium" onchange="updateAttributes();"></td>
</tr>
<tr>
<td class="label">Vitality</td>
<td>d<input type="text" <?php getnv("Vitality"); ?> class="medium" onchange="updateAttributes();"></td>
</tr>
<tr>
<td class="label">Alertness</td>
<td>d<input type="text" <?php getnv("Alertness"); ?> class="medium" onchange="updateAttributes();"></td>
</tr>
<tr>
<td class="label">Intelligence</td>
<td>d<input type="text" <?php getnv("Intelligence"); ?> class="medium" onchange="updateAttributes();"></td>
</tr>
<tr>
<td class="label">Willpower</td>
<td>d<input type="text" <?php getnv("Willpower"); ?> class="medium" onchange="updateAttributes();"></td>
</tr>
</table>

<table class="attributes">
<tr>
<td class="label">LifePoints</td>
<td><input type="text" <?php getnv("LifePoints"); ?> class="medium" onchange="updateLife();"></td>
</tr>
<tr>
<td class="label">Initiative</td>
<td>d<input type="text" <?php getnv("Initiative1"); ?> class="tiny" readonly>
  + d<input type="text" <?php getnv("Initiative2"); ?> class="tiny" readonly></td>
</tr>
<tr>
<td class="label">Wound</td>
<td><input type="text" <?php getnv("Wound"); ?> class="medium" onchange="updateLife();"></td>
</tr>
<tr>
<td class="label">Stun</td>
<td><input type="text" <?php getnv("Stun"); ?> class="medium" onchange="updateLife();"></td>
</tr>
<tr>
<td class="label">Shock</td>
<td><input type="text" <?php getnv("Shock"); ?> class="medium" onchange="updateLife();"></td>
</tr>
<tr>
<td class="label">Status</td>
<td><div id="status"></div></td>
</tr>
</table>

<table class="attributes-bottom">
<tr>
<td class="label">Movement</td>
<td><input type="text" <?php getnv("Walk"); ?> class="medium" onchange="updateMovement();"><br>Walk</td>
<td><input type="text" <?php getnv("Hustle"); ?> class="medium" readonly><br>Hustle</td>
<td><input type="text" <?php getnv("Run"); ?> class="large" readonly><br>Run</td>
</tr>
</table>

</div>

<!-- Money & Character Image -->

<div class="section-half">
<h1>Money</h1>

<div id="charPic" style="display: none;">
<img id="pic" src="" onclick="SetPic();">
</div>

<div id="noCharPic">
<img id="pic" src="Serenity/click.png" onclick="SetPic();">
</div>

<table class="attributes">
<tr>
<td class="label">Credits</td>
<td>On Hand</td><td><input type="text" <?php getnv("CreditsOnHand"); ?> class="medium"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>Banked</td><td><input type="text" <?php getnv("CreditsBanked"); ?> class="medium"></td>
</tr>

<tr>
<td class="label">Cash</td>
<td>Platinum</td><td><input type="text" <?php getnv("CashPlatinum"); ?> class="medium"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>Gold</td><td><input type="text" <?php getnv("CashGold"); ?> class="medium"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>Silver</td><td><input type="text" <?php getnv("CashSilver"); ?> class="medium"></td>
</tr>

</table>

</div>

<br>

<!-- Weapons -->
<div class="section-half">
<h1>Weapons</h1>

<table>
<tr class="label">
<th colspan="2">Name</th><th>Damage</th><th>Typ</th><th>Rng</th><th>ROF</th><th>Mag</th>
</tr>

<?php for( $i = 1; $i <= 5; $i++ ) { ?>
<tr>
<td colspan="2"><input type="text" <?php getnv("WeaponName".$i); ?> class="full"></td>
<td><input type="text" <?php getnv("WeaponDamage".$i); ?> class="medium"></td>
<td><input type="text" <?php getnv("WeaponDamageType".$i); ?> class="small"></td>
<td><input type="text" <?php getnv("WeaponRange".$i); ?> class="small"></td>
<td><input type="text" <?php getnv("WeaponROF".$i); ?> class="small"></td>
<td><input type="text" <?php getnv("WeaponMagazine".$i); ?> class="small"></td>
</tr>
<?php } ?>

</table>

</div>


<!-- Armor -->

<div class="section-half">
<h1>Armor</h1>

<table>
<tr class="label">
<th colspan="2">Name</th><th>Rating</th><th>Covers</th><th>Penalty</th><th>Weight</th>
</tr>

<?php for( $i = 1; $i <= 5; $i++ ) { ?>
<tr>
<td colspan="2"><input type="text" <?php getnv("ArmorName".$i); ?> class="full"></td>
<td><input type="text" <?php getnv("ArmorRating".$i); ?> class="medium"></td>
<td><input type="text" <?php getnv("ArmorCovers".$i); ?> class="medium"></td>
<td><input type="text" <?php getnv("ArmorPenalty".$i); ?> class="medium"></td>
<td><input type="text" <?php getnv("ArmorWeight".$i); ?> class="medium"></td>
</tr>
<?php } ?>

</table>

</div>

<br>

<!-- Traits -->

<div class="section">
<h1>Traits</h1>

<table>
<tr class="label">
<th>Asset</th><th>Notes</th><th>Maj</th>
<th>Complication</th><th>Notes</th><th>Maj</th>
</tr>
<?php for( $i = 1; $i <= 5; $i++ ) { ?>
<tr>
<td><input type="text" <?php getnv("Asset".$i."Name"); ?> class="full-skill"></td>
<td><input type="text" <?php getnv("Asset".$i."Notes"); ?> class="full-skill"></td>
<td><input type="checkbox" <?php getnc("Asset".$i."Major"); ?> class="check"></td>
<td><input type="text" <?php getnv("Complication".$i."Name"); ?> class="full-skill"></td>
<td><input type="text" <?php getnv("Complication".$i."Notes"); ?> class="full-skill"></td>
<td><input type="checkbox" <?php getnc("Complication".$i."Major"); ?> class="check"></td>
</tr>
<?php } ?>
</table>

</div>

<br class="page">

<!-- Skills -->
<div class="section-half">
<h1>Skills</h1>

<table class="half">

<tr class="label"><th colspan="2">Name</th><th>Dice</th></tr>

<?php
$maxLineCount = 24; // Minimum of 24 equipment lines.
$lineCount = 0;
$skillNum = 0;
foreach( $skills as $skill => $trainedOnly ) {
$skillNum++;
$lineCount++;
$skillName = str_replace(" ", "_", $skill);

if( $skill == "Dicipline" ) {
    $skill = "Discipline";
}
?>
<tr>
<td colspan="2"><?php echo $skill; ?></td>
<td nowrap>d<input type="text" <?php getnv($skillName."Dice"); ?> class="skill"></td>
</tr>

  <?php
  for( $i = 1; $i <= 10; $i++ ) {
    $lineCount++;
    $maxLineCount = $lineCount > $maxLineCount ? $lineCount : $maxLineCount;
  ?>
  <tr>
  <td>&nbsp;</td>
  <td><input type="text" <?php getnv($skillName."Spec".$i); ?> class="full-skill"></td>
  <td nowrap>d<input type="text" <?php getnv($skillName."SpecDice".$i); ?> class="skill"></td>
  </tr>

  <?php
    if( ! isset($DATA[$skillName."Spec".$i]) ) {
	break;
    } // END IF
  } // END FOR
  if( $skillNum == 12 ) {
    $lineCount = 0;
  ?>
</table>
<table class="half">
<tr class="label"><th colspan="2">Name</th><th>Dice</th></tr>

  <?php
  } // END IF
} // END FOREACH
?>

</table>


</div>

<!-- Equipment -->
<div class="section-half">
<h1>Equipment</h1>

<table>
<tr class="label">
<th colspan="2">Item</th><th>Loc</th><th>Wgt Ea</th><th>Count</th><th>Tot Wgt</th>
</tr>

<?php for( $i = 1; $i <= $maxLineCount; $i++ ) { ?>
<tr>
<td colspan="2"><input type="text" <?php getnv("EquipmentName".$i); ?> class="full-skill"></td>
<td><input type="text" <?php getnv("EquipmentLocation".$i); ?> class="skill"></td>
<td><input type="text" <?php getnv("EquipmentWeight".$i); ?> class="skill"></td>
<td><input type="text" <?php getnv("EquipmentCount".$i); ?> class="skill"></td>
<td><input type="text" <?php getnv("EquipmentTotalWeight".$i); ?> class="skill"></td>
</tr>
<?php } ?>

</table>

</div>

<!-- Notes -->
<input type="checkbox" <?php getnc('NotesDisp'); ?> onchange="ToggleDisplay('notes', this);" style="width:15px; border:none;"/>
Display Notes
<div id="notes">

<div class="section">
<h1>Notes</h1>

<table>
<tr><td>
<textarea <?php getn('Notes'); ?> cols="10" rows="5"><?php getv('Notes'); ?></textarea>
</td></tr>
</table>

</div>

<?php if ($SHOWSAVE) { ?>
<!-- Private Notes -->
<div class="section">
<h1>Private Notes (Will not be displayed publically)</h1>

<table>
<tr><td>
<textarea <?php getn('PrivateNotes'); ?> cols="10" rows="5"><?php getv('PrivateNotes'); ?></textarea>
</td></tr>
</table>

</div>
<input type="checkbox" <?php getnc('BackgroundDisp'); ?> onchange="ToggleDisplay('background', this);" style="width:15px; border:none;"/>
Display Background

<br class="page">

<div id="background" class="section">
<h1>Character Background (Will not be displayed publically)</h1>

<table>
<tr><td>
<textarea <?php getn('Background'); ?> cols="10" rows="50"><?php getv('Background'); ?></textarea>
</td></tr>
</table>

</div>

<?php } ?>
</div>



<!-- Footer -->

          <div id="footer">
            <table width="100%" cellspacing="0">
               <tr>
                  <td>Last saved = <?php getv("LastSaveDate"); ?><br>
                      <a href="http://www.serenityrpg.com/">Serenity RPG</a> by Jamie Chambers &amp; Margaret Weis<br>
                      Serenity&copy; 2005, Universal Studios</td>
                  <td align="right">Serenity Character Sheet by Tarlen</td>
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
