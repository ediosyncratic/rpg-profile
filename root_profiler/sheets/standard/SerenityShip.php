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

  $sheetVer = "0.1";

  // Lists for skills and traits.
  require_once("Serenity_Include.php");

  ?>

  <head>
    <title><?php echo $TITLE; ?></title>
    <link type="text/css" rel="stylesheet" href="Serenity/main.css" />
    <style type="text/css" media="print">
      #save
      , #notes tr.header span
      {
          display: none;
      }
    </style>
    <script type="text/javascript">var READONLY = <?php echo $READONLY ? "true" : "false"; ?>;</script>
    <script type="text/javascript" src="./Serenity/general.js"></script>
    <script type="text/javascript" src="./Serenity/ship.js"></script>
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

<!-- Ugly Internet Explorer Hack -->
<?php
$agent = $_SERVER['HTTP_USER_AGENT'];
$firefox = preg_match('/Firefox/i', $agent);
if( $firefox ) { echo '<!--'; } ?>
    <table id="maintable">
      <tr>
        <td>
        </td>
        <td id="main">
<?php if( $firefox ) { echo '-->'; } ?>


<!-- Character -->

<div class="section">

<table>
<tr>
<td colspan="2"><input type="text" <?php getnv("Name"); ?> class="full"><br>Name</td>
<td><input type="text" <?php getnv("Owner"); ?> class="full"><br>Owner</td>
<td><input type="text" <?php getnv("Campaign"); ?> class="full"><br>Campaign</td>
<td rowspan="3" colspan="2">
<img src="Serenity/serenity_small.jpg">
</td>
</tr>
<tr>
<td><input type="text" <?php getnv("Class"); ?> class="full"><br>Class</td>
<td><input type="text" <?php getnv("Type"); ?> class="full"><br>Type</td>
<td><input type="text" <?php getnv("Age"); ?> class="full"><br>Age</td>
<td><input type="text" <?php getnv("CrewCapacity"); ?> class="full"><br>Crew Capacity</td>

</tr>
<tr>
<td><input type="text" <?php getnv("Size"); ?> class="full"><br>Size</td>
<td><input type="text" <?php getnv("Tonnage"); ?> class="full"><br>Tonnage</td>
<td><input type="text" <?php getnv("Cargo"); ?> class="full"><br>Cargo Capacity</td>
<td><input type="text" <?php getnv("PassengerCapacity"); ?> class="full"><br>Passenger Capacity</td>
</tr>
</table>

</div>

<!-- Attributes & Character Image -->

<div class="section-half">
<h1>Attributes</h1>

<table class="attributes">
<tr>
<td class="label">Agility</td>
<td>d<input type="text" <?php getnv("Agility"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Strength</td>
<td>d<input type="text" <?php getnv("Strength"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Vitality</td>
<td>d<input type="text" <?php getnv("Vitality"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Alertness</td>
<td>d<input type="text" <?php getnv("Alertness"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Intelligence</td>
<td>d<input type="text" <?php getnv("Intelligence"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Willpower</td>
<td>d<input type="text" <?php getnv("Willpower"); ?> class="medium"></td>
</tr>
</table>

<table class="attributes">
<tr>
<td class="label">Life Points</td>
<td><input type="text" <?php getnv("LifePoints"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Wound</td>
<td><input type="text" <?php getnv("Wound"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Stun</td>
<td><input type="text" <?php getnv("Stun"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Cruise</td>
<td><input type="text" <?php getnv("Cruise"); ?> class="medium"></td>
</tr>
<tr>
<td class="label">Hard Burn</td>
<td><input type="text" <?php getnv("HardBurn"); ?> class="medium"></td>
</tr>
</table>

</div>

<!-- Vitals & Image -->

<div class="section-half">
<h1>Vitals</h1>

<div id="charPic" style="display: none;">
<img id="pic" src="" onclick="SetPic();">
</div>

<div id="noCharPic">
<img id="pic" src="Serenity/click.png" onclick="SetPic();">
</div>

<table class="attributes">
<tr>
<td class="label">Fuel</td>
<td>Max</td><td><input type="text" <?php getnv("FuelMax"); ?> class="medium"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>Current</td><td><input type="text" <?php getnv("FuelCurrent"); ?> class="medium"></td>
</tr>

<tr>
<td class="label">Food</td>
<td>Protein</td><td><input type="text" <?php getnv("FoodProtein"); ?> class="medium"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>Canned</td><td><input type="text" <?php getnv("FoodCanned"); ?> class="medium"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>Fresh</td><td><input type="text" <?php getnv("FoodFresh"); ?> class="medium"></td>
</tr>

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

<table>

<tr class="label"><th colspan="2">Name</th><th>Dice</th></tr>

<?php for( $i = 1; $i <= 10; $i++ ) { ?>
<tr>
<td colspan="2"><input type="text" <?php getnv("SkillName".$i); ?> class="full-skill"></td>
<td>d<input type="text" <?php getnv("SkillDice".$i); ?> class="skill"></td>
</tr>
<?php } ?>

</table>


</div>

<!-- Equipment -->
<div class="section-half">
<h1>Cargo</h1>

<table>
<tr class="label">
<th colspan="2">Item</th><th>Loc</th><th>Wgt Ea</th><th>Count</th><th>Tot Wgt</th>
</tr>

<?php for( $i = 1; $i <= 10; $i++ ) { ?>
<tr>
<td colspan="2"><input type="text" <?php getnv("CargoName".$i); ?> class="full-skill"></td>
<td><input type="text" <?php getnv("CargoLocation".$i); ?> class="skill"></td>
<td><input type="text" <?php getnv("CargoWeight".$i); ?> class="skill"></td>
<td><input type="text" <?php getnv("CargoCount".$i); ?> class="skill"></td>
<td><input type="text" <?php getnv("CargoTotalWeight".$i); ?> class="skill"></td>
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
<textarea <?php getn('Notes'); ?> cols="10" rows="15"><?php getv('Notes'); ?></textarea>
</td></tr>
</table>

</div>

<?php if ($SHOWSAVE) { ?>
<!-- Private Notes -->
<div class="section">
<h1>Private Notes (Will not be displayed publically)</h1>

<table>
<tr><td>
<textarea <?php getn('PrivateNotes'); ?> cols="10" rows="15"><?php getv('PrivateNotes'); ?></textarea>
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

<?php if( $firefox ) { echo '<!--'; } ?>
          </td>
        <td>
        </td>
      </tr>
    </table>
<?php if( $firefox ) { echo '-->'; } ?>



</form>
</html>
