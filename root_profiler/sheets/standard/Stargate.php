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

  $sheetVer = "1.0";

  ?>

  <head>
    <title><?php echo $TITLE; ?></title>
    <link type="text/css" rel="stylesheet" href="Stargate/main.css" />
    <style type="text/css" media="print">
      #save
      , #notes tr.header span
      {
          display: none;
      }
    </style>
    <script type="text/javascript">var READONLY = <?php echo $READONLY ? "true" : "false"; ?>;</script>
    <script type="text/javascript" src="./Stargate/attributes.js"></script>
    <script type="text/javascript" src="./Stargate/general.js"></script>
    <script type="text/javascript" src="./Stargate/sheet.js"></script>
    <script type="text/javascript" src="./Stargate/pic.js"></script>
    <script type="text/javascript" src="./Stargate/calcs.js"></script>
    <script type="text/javascript" src="./Stargate/gear.js"></script>
    <script type="text/javascript" src="./Stargate/sort.js"></script>
    <script type="text/javascript" src="./Stargate/skills.js"></script>
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

<table class="character">
	<tr>
	<td colspan="4"><input type="text" <?php getnv("Name"); ?> class="full"><br><div class="caption">CHARACTER NAME</div></td>
	<td colspan="2"><input type="text" <?php getnv("Player"); ?> class="full"><br><div class="caption">PLAYER</div></td>
	<td colspan="1"><input type="text" <?php getnv("Age"); ?> class="full"><br><div class="caption">AGE</div></td>
	<td colspan="1"><input type="text" <?php getnv("Gender"); ?> class="full"><br><div class="caption">GENDER</div></td>
	</tr>

	<tr>
	<td colspan="3"><input type="text" <?php getnv("CharacterLevel"); ?> class="full"><br><div class="caption">LEVEL</div></td>
	<td colspan="1"><input type="text" <?php getnv("Rank"); ?> class="full"><br><div class="caption">RANK</div></td>
	<td colspan="1"><input type="text" <?php getnv("Size"); ?> class="full"><br><div class="caption">SIZE</div></td>
	<td colspan="1"><input type="text" <?php getnv("Speed"); ?> class="full"><br><div class="caption">BASE SPEED</div></td>
	<td colspan="1"><input type="text" <?php getnv("Height"); ?> class="full"><br><div class="caption">HEIGHT</div></td>
	<td colspan="1"><input type="text" <?php getnv("Weight"); ?> class="full"><br><div class="caption">WEIGHT</div></td>
	</tr>

	<tr>
	<td colspan="4"><input type="text" <?php getnv("Class"); ?> class="full"><br><div class="caption">CLASS</div></td>
	<td colspan="2" nowrap><input type="text" <?php getnv("Race"); ?> class="full"><br><div class="caption">SPECIALITY/SPECIES</div></td>
	<td colspan="1"><input type="text" <?php getnv("Eyes"); ?> class="full"><br><div class="caption">EYES</div></td>
	<td colspan="1"><input type="text" <?php getnv("Hair"); ?> class="full"><br><div class="caption">HAIR</div></td>
	</tr>
</table>
</div>

<hr />

<!-- Attributes -->
<div class="section">
<table class="abilities-nb">
	<tr><td width="150">

	<table class="abilities" cellspacing="0">
		<tr>
		<th class="abilities">&nbsp;</th>
		<th class="abilities">ABIL</th>
		<th class="abilities">MOD</th>
		<th>&nbsp;</th>
		<th class="abilities">TEMP</th>
		<th class="abilities">MOD</th>
		</tr>
		<tr>
		<td class="label"><div class="label">STR</div></td>
		<td><input type="text" <?php getnv("Str"); ?> class="mod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("StrMod"); ?> class="mod" readonly></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("StrTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("StrTempMod"); ?> class="tempmod" readonly></td>
		</tr>
		<tr>
		<td class="label"><div class="label">DEX</div></td>
		<td><input type="text" <?php getnv("Dex"); ?> class="mod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("DexMod"); ?> class="mod" readonly></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("DexTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("DexTempMod"); ?> class="tempmod" readonly></td>
		</tr>
		<tr>
		<td class="label"><div class="label">CON</div></td>
		<td><input type="text" <?php getnv("Con"); ?> class="mod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("ConMod"); ?> class="mod" readonly></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("ConTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("ConTempMod"); ?> class="tempmod" readonly></td>
		</tr>
		<tr>
		<td class="label"><div class="label">INT</div></td>
		<td><input type="text" <?php getnv("Int"); ?> class="mod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("IntMod"); ?> class="mod" readonly></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("IntTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("IntTempMod"); ?> class="tempmod" readonly></td>
		</tr>
		<tr>
		<td class="label"><div class="label">WIS</div></td>
		<td><input type="text" <?php getnv("Wis"); ?> class="mod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("WisMod"); ?> class="mod" readonly></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("WisTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("WisTempMod"); ?> class="tempmod" readonly></td>
		</tr>
		<tr>
		<td class="label"><div class="label">CHA</div></td>
		<td><input type="text" <?php getnv("Cha"); ?> class="mod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("ChaMod"); ?> class="mod" readonly></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("ChaTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
		<td><input type="text" <?php getnv("ChaTempMod"); ?> class="tempmod" readonly></td>
		</tr>
	</table>

	</td>
	<td>
	<!-- HP & Defense -->

	<table class="abilities-nb">
		<tr>
		<th>&nbsp;</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th colspan="3">CURRENT</th>
		<td>&nbsp;</td>
		<th colspan="2">DIE</th>
		</tr>

		<tr>
		<td class="label"><div class="label">&nbsp;VITALITY&nbsp;</div></td>
		<td><input type="text" <?php getnv("Vitality"); ?> class="smod"></td>
		<td>&nbsp;</td>
		<td colspan="3"><input type="text" <?php getnv("VitalityCurrent"); ?> class="mod"></td>
		<td>&nbsp;</td>
		<td colspan="3"><input type="text" <?php getnv("VitalityDie"); ?> class="mod"></td>
		</tr>

		<tr>
		<td class="label"><div class="label">&nbsp;WOUNDS&nbsp;</div></td>
		<td><input type="text" <?php getnv("WoundsTotal"); ?> class="smod"></td>
		<td>&nbsp;</td>
		<td colspan="3"><input type="text" <?php getnv("WoundsCurrent"); ?> class="mod"></td>
		<td>&nbsp;</td>
		<td colspan="3"><input type="text" <?php getnv("SubdualCurrent"); ?> class="mod"></td>
		<td>&nbsp;</td>
		<th>SUBDUAL DAMAGE</th>
		</tr>

		<tr>
		<td class="label"><div class="label">&nbsp;DEFENSE&nbsp;</div></td>
		<td><input type="text" <?php getnv("Defense"); ?> class="smod" readonly></td>
		<td nowrap><b>=10+</b></td>
		<td nowrap><input type="text" <?php getnv("DefenseClass"); ?> class="smod" onchange="updateDefense();"></td>
		<td>/</td>
		<td nowrap><input type="text" <?php getnv("DefenseEquipment"); ?> class="smod" onchange="updateDefense();"></td>
		<td>+</td>
		<td nowrap><input type="text" <?php getnv("DefenseDexterity"); ?> class="smod" readonly></td>
		<td>+</td>
		<td nowrap><input type="text" <?php getnv("DefenseSize"); ?> class="smod" onchange="updateDefense();"></td>
		<td>+</td>
		<td nowrap><input type="text" <?php getnv("DefenseMisc"); ?> class="smod" onchange="updateDefense();"></td>
		</tr>

		<tr>
		<th>&nbsp;</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th>CLASS</th>
		<td>&nbsp;</td>
		<th>ARMOR</th>
		<td>&nbsp;</td>
		<th>DEX MOD</th>
		<td>&nbsp;</td>
		<th>SIZE MOD</th>
		<td>&nbsp;</td>
		<th>MISC BONUS</th>
		</tr>
		<tr></tr>

		<!-- Initiative -->
		<tr>
		<th>&nbsp;</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th>CLASS</th>
		<th>&nbsp;</th>
		<th>DEX</th>
		<th>&nbsp;</th>
		<th>MISC</th>
		</tr>

		<tr>
		<td class="label"><div class="label">&nbsp;INITIATIVE&nbsp;</div></td>
		<td nowrap><input type="text" <?php getnv("Init"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("InitClass"); ?> class="smod" onchange="updateInitiative();"></td>
		<td>+</td>
		<td nowrap><input type="text" <?php getnv("InitDex"); ?> class="smod" readonly></td>
		<td>+</td>
		<td nowrap><input type="text" <?php getnv("InitMisc"); ?> class="smod" onchange="updateInitiative();"></td>
		</tr>
	</table>

	</td>
	<td>

	<!-- Inspiration & Education -->
	<table class="abilities-nb">
		<tr>
		<th>&nbsp;</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th>WIS MOD</th>
		<th>&nbsp;</th>
		<th>MISC</th>
		</tr>
		<tr>
		<td class="label" nowrap><div class="label">&nbsp;INSPIRATION&nbsp;</div></td>
		<td><input type="text" <?php getnv("Inspiration"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("InspirationAbility"); ?> class="smod" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv("InspirationMisc"); ?> class="smod" onchange="updateInspiration();"></td>
		</tr>
		<tr>
		<td class="label" nowrap><div class="label">&nbsp;EDUCATION&nbsp;</div></td>
		<td><input type="text" <?php getnv("Education"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("EducationAbility"); ?> class="smod" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv("EducationMisc"); ?> class="smod" onchange="updateEducation();"></td>
		</tr>
		<tr>
		<th>&nbsp;</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th>INT MOD</th>
		<th>&nbsp;</th>
		<th>MISC</th>
		</tr>

		<tr>
		<td colspan="6"><hr /></td>
		</tr>

		<!-- Action Points -->
		<tr>
		<th>&nbsp;</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th>DIETYPE</th>
		<th>&nbsp;</th>
		<th>SPENT</th>
		</tr>

		<tr>
		<td class="label" nowrap><div class="label">&nbsp;ACTION DICE&nbsp;</div></td>
		<td><input type="text" <?php getnv("ActionPoints"); ?> class="smod"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("ActionDie"); ?> class="smod"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("ActionSpent"); ?> class="smod"></td>
		</tr>

	</table>
	</td>
</table>

</div>

<!-- Saving Throws -->
<table>
	<tr>
	<td>

	<table class="abilities" cellspacing="0">
		<tr>
		<th>SAVING THROWS</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th>BASE</th>
		<th>&nbsp;</th>
		<th>ABILITY</th>
		<th>&nbsp;</th>
		<th>MISC</th>
		</tr>

		<tr>
		<td class="label"><div class="label">&nbsp;FORTITUDE&nbsp;</div></td>
		<td><input type="text" <?php getnv("FortSave"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("FortBase"); ?> class="smod" onchange="updateFortitudeSave();"></td>
		<td>+</td>
		<td><input type="text" <?php getnv("FortAbility"); ?> class="smod" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv("FortMisc"); ?> class="smod" onchange="updateFortitudeSave();"></td>
		</tr>
		<tr>
		<td class="label"><div class="label">&nbsp;REFLEX&nbsp;</div></td>
		<td><input type="text" <?php getnv("ReflexSave"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("ReflexBase"); ?> class="smod" onchange="updateReflexSave();"></td>
		<td>+</td>
		<td><input type="text" <?php getnv("ReflexAbility"); ?> class="smod" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv("ReflexMisc"); ?> class="smod" onchange="updateReflexSave();"></td>
		</tr>

		<tr>
		<td class="label"><div class="label">&nbsp;WILL&nbsp;</div></td>
		<td><input type="text" <?php getnv("WillSave"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("WillBase"); ?> class="smod" onchange="updateWillSave();"></td>
		<td>+</td>
		<td><input type="text" <?php getnv("WillAbility"); ?> class="smod" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv("WillMisc"); ?> class="smod" onchange="updateWillSave();"></td>
		</tr>

	    <!-- Attacks -->
		<tr>
		<th>BASE ATTACKS</th>
		<th>TOTAL</th>
		<th>&nbsp;</th>
		<th>BASE</th>
		<th>&nbsp;</th>
		<th>STR</th>
		<th>&nbsp;</th>
		<th>SIZE</th>
		<th>&nbsp;</th>
		<th>MISC</th>
		</tr>

		<tr>
		<td class="label"><div class="label">MELEE</div></td>
		<td><input type="text" <?php getnv("MeleeAttack"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("MeleeBase"); ?> class="smod" onchange="updateMeleeAttack();"></td>
		<td>+</td>
		<td><input type="text" <?php getnv("MeleeStrength"); ?> class="smod" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv("MeleeSize"); ?> class="smod" onchange="updateMeleeAttack();"></td>
		<td>+</td>
		<td><input type="text" <?php getnv("MeleeMisc"); ?> class="smod" onchange="updateMeleeAttack();"></td>
		</tr>

		<tr>
		<td class="label"><div class="label">RANGED</div></td>
		<td><input type="text" <?php getnv("RangedAttack"); ?> class="smod" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv("RangedBase"); ?> class="smod" onchange="updateRangedAttack();"></td>
		<td>+</td>
		<td><input type="text" <?php getnv("RangedDexterity"); ?> class="smod" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv("RangedSize"); ?> class="smod" onchange="updateRangedAttack();"></td>
		<td>+</td>
		<td><input type="text" <?php getnv("RangedMisc"); ?> class="smod" onchange="updateRangedAttack();"></td>
		</tr>

		<tr>
		<th><div style="height: 20px;">&nbsp;</div></th>
		<th>TOTAL<br/>&nbsp;</th>
		<th>&nbsp;</th>
		<th>BASE<br/>&nbsp;</th>
		<th>&nbsp;</th>
		<th>DEX<br/>&nbsp;</th>
		<th>&nbsp;</th>
		<th>SIZE<br/>&nbsp;</th>
		<th>&nbsp;</th>
		<th>MISC<br/>&nbsp;</th>
		</tr>
	</table>
	</td>

	<td rowspan="2" width="100%">
	<!-- Campaign notes -->
	<table width="100%">
		<tr>
		<td colspan="2"><input type="text" <?php getnv("Campaign"); ?> class="full"><br><div class="caption">CAMPAIGN</div></td>
		</tr><tr>
		<td><input type="text" <?php getnv("Experience"); ?> class="full"><br><div class="caption">EXPERIENCE POINTS</div></td>
		<td><input type="text" <?php getnv("ExperienceNextLevel"); ?> class="full"><br><div class="caption">NEXT LEVEL</div></td>
		</tr><tr>
		<td><input type="text" <?php getnv("GearPicks"); ?> class="full"><br><div class="caption">GEAR PICKS</div></td>
		<td><input type="text" <?php getnv("ResourcePoints"); ?> class="full"><br><div class="caption">RESOURCE POINTS</div></td>
		</tr>
		<tr>
		<td colspan="2"><img src="stargate/stargate.png"></td>
		</tr>
	</table>
	</td>
	<td rowspan="2" width="127">

	<!-- Character image -->
    <div id="picDiv">
	<div id="charPic" style="display: none;">
	<img id="pic" src="" onclick="SetPic();">
	</div>

	<div id="noCharPic">
	<img id="pic" src="stargate/click.png" onclick="SetPic();">
	</div>
	</div>

	</td>
	</tr>
	<!-- Weapon & Armour Toggles -->
	<tr><td>
	<table width="300">
		<tr><td>Weapons:</td>
		<td><?php for ( $i = 1; $i <= 4; $i++ ) { ?>
		<input type="checkbox" <?php getnc('Wep'.$i.'Disp'); ?> onclick="ToggleDisplay('weapon<?php echo $i ?>', this);" style="width:12px; border:none;"/>
		<?php } ?></td>
		<td>Armor:</td>
		<td><?php for ( $i = 1; $i <= 4; $i++ ) { ?>
		<input type="checkbox" <?php getnc('Arm'.$i.'Disp'); ?> onclick="ToggleDisplay('armor<?php echo $i ?>', this);" style="width:12px; border:none;"/>
		<?php } ?></td>
		</tr>
	</table>
	</td></tr>
</table>

<!-- Weapons -->
<?php for( $i = 1; $i <= 4; $i++ ) { ?>
<div id="weapon<?php echo $i; ?>">
<table class="weapon" cellspacing="0">
	<tr class="header">
	<td colspan="5"><div class="header">WEAPON</div></td>
	<td><div class="sheader">ATK</div></td>
	<td><div class="sheader">DAM</div></td>
	<td><div class="sheader">ERROR</div></td>
	<td><div class="sheader">THREAT</div></td>
	<td><div class="sheader">RANGE</div></td>
	<td><div class="sheader">WEIGHT</div></td>
	<td colspan="5"><div class="sheader">PROPERTIES</div></td>
	</tr>

	<tr>
	<td colspan="5"><input type="text" <?php getnv("Weapon".$i); ?> class="full borderless left"></td>
	<td><input type="text" <?php getnv("WeaponAttack".$i); ?> class="full borderless"></td>
	<td><input type="text" <?php getnv("WeaponDamage".$i); ?> class="full borderless"></td>
	<td><input type="text" <?php getnv("WeaponError".$i); ?> class="full borderless"></td>
	<td><input type="text" <?php getnv("WeaponThreat".$i); ?> class="full borderless"></td>
	<td><input type="text" <?php getnv("WeaponRange".$i); ?> class="full borderless"></td>
	<td><input type="text" <?php getnv("WeaponWeight".$i); ?> class="full borderless"></td>
	<td colspan="5"><input type="text" <?php getnv("WeaponProperties".$i); ?> class="large borderless"></td>
	</tr>

	<tr class="header">
	<td><div class="sheader">TYPE</div></td>
	<td><div class="sheader">SIZE</div></td>
	<td colspan="3"><div class="sheader">AMMOTYPE</div></td>
	<td colspan="2"><div class="sheader">PROPERTIES</div></td>
	<td colspan="2"><div class="sheader">AMMO COUNT</div></td>
	<td colspan="3"><div class="sheader">AMMOTYPE</div></td>
	<td colspan="2"><div class="sheader">PROPERTIES</div></td>
	<td colspan="2"><div class="sheader">AMMO COUNT</div></td>
	</tr>

	<tr>
	<td><input type="text" <?php getnv("WeaponType".$i); ?> class="full borderless"></td>
	<td><input type="text" <?php getnv("WeaponSize".$i); ?> class="full borderless"></td>
	<td colspan="3"><input type="text" <?php getnv("WeaponAmmo".$i); ?> class="full borderless"></td>
	<td colspan="2"><input type="text" <?php getnv("WeaponAmmoProperties".$i); ?> class="full borderless"></td>
	<td colspan="2"><input type="text" <?php getnv("WeaponAmmoCount".$i); ?> class="full borderless"></td>
	<td colspan="3"><input type="text" <?php getnv("WeaponSecondaryAmmo".$i); ?> class="full borderless"></td>
	<td colspan="2"><input type="text" <?php getnv("WeaponSecondaryAmmoProperties".$i); ?> class="full borderless"></td>
	<td colspan="2"><input type="text" <?php getnv("WeaponSecondaryAmmoCount".$i); ?> class="full borderless"></td>
	</tr>
</table>
</div>
<?php } ?>

<!-- Armour -->
<?php for( $i = 1; $i <= 4; $i++ ) { ?>
<div id="armor<?php echo $i; ?>">
<table class="weapon" cellspacing="0">
	<tr class="header">
	<td colspan="3"><div class="header">ARMOR / PROTECTIVE ITEM</div></td>
	<td><div class="sheader">DEFENSE<br />BONUS</div></td>
	<td><div class="sheader">DAMAGE<br />RESISTANCE</div></td>
	<td><div class="sheader">ARMOR<br />CHECK</div></td>
	<td><div class="sheader">TYPE</div></td>
	<td><div class="sheader">MAX DEX<br />MOD</div></td>
	<td><div class="sheader">SPEED</div></td>
	<td><div class="sheader">WEIGHT</div></td>
	<td colspan="4"><div class="sheader">PROPERTIES</div></td>
	</tr>

	<tr>
	<td colspan="3"><input type="text" <?php getnv("Armor".$i); ?> class="large borderless left"></td>
	<td><input type="text" <?php getnv("ArmorBonus".$i); ?> class="small borderless"></td>
	<td><input type="text" <?php getnv("ArmorDamageResistance".$i); ?> class="small borderless"></td>
	<td><input type="text" <?php getnv("ArmorPenalty".$i); ?> class="small borderless"></td>
	<td><input type="text" <?php getnv("ArmorType".$i); ?> class="medium borderless"></td>
	<td><input type="text" <?php getnv("ArmorMaxDex".$i); ?> class="small borderless"></td>
	<td><input type="text" <?php getnv("ArmorSpeed".$i); ?> class="small borderless"></td>
	<td><input type="text" <?php getnv("ArmorWeight".$i); ?> class="small borderless"></td>
	<td colspan="2"><input type="text" <?php getnv("ArmorProperties".$i); ?> class="full borderless"></td>
	</tr>
</table>
</div>
<?php } ?>

<br class="page" />

<table class="full">
	<tr><td class="half">

	<!-- Skills -->
	<div class="section">
	<h1>Skills</h1>

	<?php $skillCount = 60; ?>

	<table id="skills" class="abilities">
		<tr>
		<th>CLASS<br />SKILL</th>
		<th><a class="sort" href="javascript:SkillSort(Sort.ByName);">SKILL<br />NAME</a></th>
		<th><a class="sort" href="javascript:SkillSort(SkillSort.ByAbility);">KEY<br />ABILITY</a></th>
		<th><a class="sort" href="javascript:SkillSort(SkillSort.ByTotal);">SKILL<br />BONUS</a></th>
		<th>&nbsp;</th>
		<th><a class="sort" href="javascript:SkillSort(SkillSort.ByRanks);">RANKS</a></th>
		<th>&nbsp;</th>
		<th>ABILITY<br />MOD</th>
		<th>&nbsp;</th>
		<th>MISC<br />MOD</th>
		<th>&nbsp;</th>
		<th>ERROR<br />RANGE</th>
		<th>&nbsp;</th>
		<th>THREAT RANGE</th>
		</tr>
		<?php for( $i = 1; $i <= $skillCount; $i++ ) {
        $skillName = sprintf( "Skill%02d", $i );
		?>

		<tr>
		<td><input type="checkbox" <?php getnc("SkillClass".$i); ?> class="check" style="width:15px;"></td>
		<td><input type="text" <?php getnv($skillName); ?> class="large skill left" onchange="updateSkill(this);"></td>
		<td><input type="text" <?php getnv($skillName."Ability"); ?> class="small skill center" onchange="updateSkill(this);"></td>
		<td><input type="text" <?php getnv($skillName."Total"); ?> class="tiny skill center" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv($skillName."Rank"); ?> class="tiny skill center" onchange="updateSkill(this);"></td>
		<td>+</td>
		<td><input type="text" <?php getnv($skillName."Mod"); ?> class="tiny skill center" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv($skillName."Misc"); ?> class="tiny skill center" onchange="updateSkill(this);"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv($skillName."Error"); ?> class="tiny skill center"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv($skillName."Threat"); ?> class="tiny skill center"></td>
		</tr>
		<?php } ?>
	</table>

	</div>

	</td><td class="half" valign="top">

	<div>

	<h1>Operation Gear</h1>
	<?php $gearCount = 32; ?>

	<table class="abilities" id="gearList">
		<tr>
		<th class="full"><a class="sort" href="javascript:GearSort(Sort.ByName);">ITEM</a></th>
		<th>&nbsp;</th>
		<th><a class="sort" href="javascript:GearSort(Sort.ByWeight);">WT.</a></th>
		</tr>
		<?php for( $i = 1; $i <= $gearCount; $i++ ) { ?>
			<tr class="label">
			<td><input type="text" <?php getnv("Gear".$i); ?> class="full skill left"></td>
			<td>&nbsp;</td>
			<td><input type="text" <?php getnv("GearWeight".$i); ?> class="small skill"></td>
			</tr>
		<?php } ?>
	</table>

	</div>

	<br />

	<!-- Feats -->
	<div>
	<h1>Feats</h1>

    <?php $featCount = 20; ?>

	<table class="abilities">
		<tr>
		<th class="full">NAME</th>
		<th>&nbsp;</th>
		<th>EFFECT</th>
		</tr>
		<?php for( $i = 1; $i <= $featCount; $i++ ) { ?>
			<tr>
			<td><input type="text" <?php getnv("Feat".$i); ?> ></td>
			<td>&nbsp;</td>
			<td><input type="text" <?php getnv("FeatDesc".$i); ?> ></td>
			</tr>
		<?php } ?>
	</table>

	</div>

	<br>

	<!-- Languages -->
	<div>
	<h1>Languages</h1>

	<table class="abilities">
		<tr>

		<?php $languageCount = 10; ?>

		<?php for( $i = 1; $i <= $languageCount; $i++) { ?>
		<?php if( $i % ($languageCount / 2) == 1 ) { ?>
		<td>
		<table class="abilities-nb">
			<tr class="label">
			<th class="full">LANGUAGE</th><th>NATIVE</th>
			</tr>

			<?php } ?>

			<tr>
			<td><input type="text" <?php getnv("Language".$i); ?> class="full skill left"></td>
			<td><input type="checkbox" <?php getnc("LanguageNative".$i); ?> style="width:15px; border:none;"></td>
			</tr>

			<?php if( $i % ($languageCount / 2) == 0 ) { ?>
		</table>
		</td>
		<?php } ?>

		<?php } ?>

		</tr>
	</table>
	</div>

	</td></tr>
</table>

<br />

<div>
<!-- Personal Equipment -->
<h1>Personal Belongings</h1>
<?php $pgearCount = 30; ?>	<!-- Have to be an even number! -->

<table id="pGearList">
	<tr>
	<th class="half"><a class="sort" href="javascript:pGearSort(Sort.ByName);">ITEM</a></th>
	<th>&nbsp;</th>
	<th><a class="sort" href="javascript:pGearSort(Sort.ByLocation);">LOCATION</a></th>
	<th>&nbsp;</th>
	<th><a class="sort" href="javascript:pGearSort(Sort.ByWeight);">WT.</a></th>
	<th>&nbsp;</th>
	<th class="half"><a class="sort" href="javascript:p2GearSort(Sort.ByName);">ITEM</a></th>
	<th>&nbsp;</th>
	<th><a class="sort" href="javascript:p2GearSort(Sort.ByLocation);">LOCATION</a></th>
	<th>&nbsp;</th>
	<th><a class="sort" href="javascript:p2GearSort(Sort.ByWeight);">WT.</a></th>

	</tr>
	<?php for( $i = 1; $i <= $pgearCount; $i++ ) { ?>
		<tr class="label" id="pgear<?php echo $i; ?>">
		<td><input type="text" <?php getnv("pGear".$i); ?> class="full skill left"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("pGearLocation".$i); ?> class="skill left"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("pGearWeight".$i); ?> class="small skill"></td>
		<td>&nbsp;</td>
		<?php $i++; ?>
		<td><input type="text" <?php getnv("pGear".$i); ?> class="full skill left"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("pGearLocation".$i); ?> class="skill left"></td>
		<td>&nbsp;</td>
		<td><input type="text" <?php getnv("pGearWeight".$i); ?> class="small skill"></td>
		</tr>
	<?php } ?>
</table>

</div>


<br class="page">

<!-- Notes -->
<input type="checkbox" <?php getnc('NotesDisp'); ?> onchange="ToggleDisplay('notes', this);" style="width:15px; border:none;"/>
Display Notes

<div id="notes">

<div class="section">
<h1>Notes</h1>

<table class="abilities">
	<tr><td>
	<textarea <?php getn('Notes'); ?> rows="7" class="full"><?php getv('Notes'); ?></textarea>
	</td></tr>
</table>

</div>

<?php if ($SHOWSAVE) { ?>
<!-- Private Notes -->
<div class="section">
<h1>Private Notes (Will not be displayed publically)</h1>

<table class="abilities">
	<tr><td>
	<textarea <?php getn('PrivateNotes'); ?> rows="7" class="full"><?php getv('PrivateNotes'); ?></textarea>
	</td></tr>
</table>

</div>
<input type="checkbox" <?php getnc('BackgroundDisp'); ?> onchange="ToggleDisplay('background', this);" style="width:15px; border:none;"/>
Display Background

<div id="background" class="section">
<h1>Character Background (Will not be displayed publically)</h1>

<table class="abilities">
	<tr><td>
	<textarea <?php getn('Background'); ?> rows="20" class="full"><?php getv('Background'); ?></textarea>
	</td></tr>
</table>

</div>


<?php } ?>
</div>


<!-- Footer -->

          <div id="footer">
            <table width="100%" cellspacing="0">
               <tr>
                  <td>Last saved = <?php getv("LastSaveDate"); ?></td>
                  <td align="right">Stargate SG-1 Character Sheet version <?php echo $sheetVer; ?> by empty_other,<br /> based on the d20 Modern character sheet by Tarlen</td>
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
