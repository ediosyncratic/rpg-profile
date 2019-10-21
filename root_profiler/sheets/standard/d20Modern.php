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

  ?>

  <head>
    <title><?php echo $TITLE; ?></title>
    <link type="text/css" rel="stylesheet" href="d20Modern/main.css" />
    <style type="text/css" media="print">
      #save
      , #notes tr.header span
      {
          display: none;
      }
    </style>
    <script type="text/javascript">var READONLY = <?php echo $READONLY ? "true" : "false"; ?>;</script>
    <script type="text/javascript" src="./d20Modern/attributes.js"></script>
    <script type="text/javascript" src="./d20Modern/general.js"></script>
    <script type="text/javascript" src="./d20Modern/sheet.js"></script>
    <script type="text/javascript" src="./d20Modern/pic.js"></script>
    <script type="text/javascript" src="./d20Modern/calcs.js"></script>
    <script type="text/javascript" src="./d20Modern/gear.js"></script>
    <script type="text/javascript" src="./d20Modern/sort.js"></script>
    <script type="text/javascript" src="./d20Modern/skills.js"></script>
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

<table class="character">
<tr>
<td rowspan="3" width="83"><img src="d20Modern/d20Modern.jpg"></td>
<td colspan="2"><input type="text" <?php getnv("Name"); ?> class="full"><br><div class="caption">NAME</div></td>
<td colspan="2"><input type="text" <?php getnv("Player"); ?> class="full"><br><div class="caption">PLAYER</div></td>
<td colspan="2"><input type="text" <?php getnv("Campaign"); ?> class="full"><br><div class="caption">CAMPAIGN</div></td>
<td><input type="text" <?php getnv("Experience"); ?> class="full"><br><div class="caption">EXPERIENCE</div></td>
</tr>

<tr>
<td colspan="2"><input type="text" <?php getnv("Class"); ?> class="full"><br><div class="caption">CLASS</div></td>
<td colspan="2" nowrap><input type="text" <?php getnv("CharacterLevel"); ?> class="full"><br><div class="caption">CHARACTER LEVEL</div></td>
<td colspan="3"><input type="text" <?php getnv("Occupation"); ?> class="full"><br><div class="caption">OCCUPATION</div></td>
</tr>
<tr>
<td><input type="text" <?php getnv("Age"); ?> class="full"><br><div class="caption">AGE</div></td>
<td><input type="text" <?php getnv("Gender"); ?> class="full"><br><div class="caption">GENDER</div></td>
<td><input type="text" <?php getnv("Height"); ?> class="full"><br><div class="caption">HEIGHT</div></td>
<td><input type="text" <?php getnv("Weight"); ?> class="full"><br><div class="caption">WEIGHT</div></td>
<td><input type="text" <?php getnv("Eyes"); ?> class="full"><br><div class="caption">EYES</div></td>
<td><input type="text" <?php getnv("Hair"); ?> class="full"><br><div class="caption">HAIR</div></td>
<td><input type="text" <?php getnv("Skin"); ?> class="full"><br><div class="caption">SKIN</div></td>
</tr>
</table>
</div>

<hr/>

<!-- Attributes -->
<div class="section">
<table class="abilities-nb">
<tr><td width="250"rowspan="2">

<h1>Abilities</h1>

<table class="abilities" cellspacing="0">
<tr>
<th class="abilities"></th>
<th class="abilities">SCORE</th>
<th class="abilities">MOD</th>
<th class="abilities">TEMP</th>
<th class="abilities">MOD</th>
</tr>
<tr>
<td class="label"><div class="label">STR</div></td>
<td><input type="text" <?php getnv("Str"); ?> class="mod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("StrMod"); ?> class="mod" readonly></td>
<td><input type="text" <?php getnv("StrTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("StrTempMod"); ?> class="tempmod" readonly></td>
</tr>
<tr>
<td class="label"><div class="label">DEX</div></td>
<td><input type="text" <?php getnv("Dex"); ?> class="mod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("DexMod"); ?> class="mod" readonly></td>
<td><input type="text" <?php getnv("DexTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("DexTempMod"); ?> class="tempmod" readonly></td>
</tr>
<tr>
<td class="label"><div class="label">CON</div></td>
<td><input type="text" <?php getnv("Con"); ?> class="mod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("ConMod"); ?> class="mod" readonly></td>
<td><input type="text" <?php getnv("ConTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("ConTempMod"); ?> class="tempmod" readonly></td>
</tr>
<tr>
<td class="label"><div class="label">INT</div></td>
<td><input type="text" <?php getnv("Int"); ?> class="mod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("IntMod"); ?> class="mod" readonly></td>
<td><input type="text" <?php getnv("IntTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("IntTempMod"); ?> class="tempmod" readonly></td>
</tr>
<tr>
<td class="label"><div class="label">WIS</div></td>
<td><input type="text" <?php getnv("Wis"); ?> class="mod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("WisMod"); ?> class="mod" readonly></td>
<td><input type="text" <?php getnv("WisTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("WisTempMod"); ?> class="tempmod" readonly></td>
</tr>
<tr>
<td class="label"><div class="label">CHA</div></td>
<td><input type="text" <?php getnv("Cha"); ?> class="mod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("ChaMod"); ?> class="mod" readonly></td>
<td><input type="text" <?php getnv("ChaTemp"); ?> class="tempmod" onchange="updateAttribute(this);"></td>
<td><input type="text" <?php getnv("ChaTempMod"); ?> class="tempmod" readonly></td>
</tr>
</table>

</td>
<td colspan="2">
<!-- HP & Defense -->

<table class="abilities-nb">
<tr>
<th>&nbsp;</th>
<th>TOTAL</th>
<th></th>
<th colspan="12">CURRENT HP</th>
</tr>

<tr>
<td class="label"><div class="label">&nbsp;HP&nbsp;</div></td>
<td><input type="text" <?php getnv("HP"); ?> class="smod"></td>
<td></td>
<td colspan="12"><input type="text" <?php getnv("HPCurrent"); ?> class="mod"></td>
</tr>

<tr>
<td class="label"><div class="label">&nbsp;DEFENSE&nbsp;</div></td>
<td><input type="text" <?php getnv("Defense"); ?> class="smod" readonly></td>
<td>=</td>
<td nowrap><b>10 +</b></td>
<td nowrap><input type="text" <?php getnv("DefenseClass"); ?> class="smod" onchange="updateDefense();"></td>
<td>+</td>
<td nowrap><input type="text" <?php getnv("DefenseEquipment"); ?> class="smod" onchange="updateDefense();"></td>
<td>+</td>
<td nowrap><input type="text" <?php getnv("DefenseDexterity"); ?> class="smod" readonly></td>
<td>+</td>
<td nowrap><input type="text" <?php getnv("DefenseSize"); ?> class="smod" onchange="updateDefense();"></td>
<td>+</td>
<td nowrap><input type="text" <?php getnv("DefenseMisc"); ?> class="smod" onchange="updateDefense();"></td>
<td>&nbsp;</td>
<td nowrap><input type="text" <?php getnv("DefenseArmor"); ?> class="smod" onchange="updateDefense();"></td>
</tr>

<tr>
<th></th>
<th>TOTAL</th>
<th colspan="2"></th>
<th>CLASS BONUS</th>
<th></th>
<th>EQUIP BONUS</th>
<th></th>
<th>DEX MOD</th>
<th></th>
<th>SIZE MOD</th>
<th></th>
<th>MISC BONUS</th>
<th></th>
<th>ARMOR PEN</th>
</tr>
</table>


</td>

<!-- Character Image -->
<td rowspan="2" width="127">
<div id="picDiv">
<div id="charPic" style="display: none;">
<img id="pic" src="" onclick="SetPic();">
</div>

<div id="noCharPic">
<img id="pic" src="d20Modern/click.png" onclick="SetPic();">
</div>
</div>
</td>

</tr>
<tr>
<td>
<!-- Initiative, Base Attack & Speed -->

<table class="abilities-nb">

<tr>
<th></th>
<th>TOTAL</th>
<th></th>
<th>DEX</th>
<th></th>
<th>MISC</th>
</tr>

<tr>
<td class="label"><div class="label">&nbsp;INITIATIVE&nbsp;</div></td>
<td nowrap><input type="text" <?php getnv("Init"); ?> class="mmod" readonly></td>
<td>=</td>
<td nowrap><input type="text" <?php getnv("InitDex"); ?> class="mmod" readonly></td>
<td>+</td>
<td nowrap><input type="text" <?php getnv("InitMisc"); ?> class="mmod" onchange="updateInitiative();"></td>
</tr>

<tr>
<td colspan="2" nowrap class="label"><div class="label">&nbsp;BASE ATTACK&nbsp;</div></td>
<td></td>
<td colspan="3"><input type="text" <?php getnv("BaseAttack"); ?> class="mod" onchange="updateBaseAttack();"></td>
</tr>

<tr>
<td colspan="2" nowrap class="label"><div class="label">&nbsp;SPEED&nbsp;</div></td>
<td></td>
<td colspan="3"><input type="text" <?php getnv("Speed"); ?> class="mod"></td>
</tr>

</table>


</td>
<td>
<!-- Reputation, Action Points & Wealth -->

<table class="abilities-nb">
<tr>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<tr>
<td class="label"><div class="label">&nbsp;REPUTATION&nbsp;</div></td>
<td><input type="text" <?php getnv("Reputation"); ?> class="smod"></td>
</tr>
<tr>
<td class="label" nowrap><div class="label">&nbsp;ACTION POINTS&nbsp;</div></td>
<td><input type="text" <?php getnv("ActionPoints"); ?> class="smod"></td>
</tr>
<tr>
<td class="label" nowrap><div class="label">&nbsp;WEALTH BONUS&nbsp;</div></td>
<td><input type="text" <?php getnv("WealthBonus"); ?> class="smod"></td>
</tr>
</table>


</td>
</tr>
</table>
</div>

<!-- Attacks -->

<table>
<tr>
<td class="half">
<h1>Attacks</h1>

<table class="abilities" cellspacing="0">

<tr>
<th></th>
<th>TOTAL</th>
<th></th>
<th>BASE</th>
<th></th>
<th>STR</th>
<th></th>
<th>SIZE</th>
<th></th>
<th>MISC</th>
</tr>

<tr>
<td class="label"><div class="label">MELEE</div></td>
<td><input type="text" <?php getnv("MeleeAttack"); ?> class="smod" readonly></td>
<td>=</td>
<td><input type="text" <?php getnv("MeleeBase"); ?> class="smod" readonly></td>
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
<td><input type="text" <?php getnv("RangedBase"); ?> class="smod" readonly></td>
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
<th></th>
<th>BASE<br/>&nbsp;</th>
<th></th>
<th>DEX<br/>&nbsp;</th>
<th></th>
<th>SIZE<br/>&nbsp;</th>
<th></th>
<th>MISC<br/>&nbsp;</th>
</tr>


</table>

</td>

<!-- Saving Throws -->

<td class="quarter">

<h1>Saving Throws</h1>

<table class="abilities" cellspacing="0">

<tr>
<th></th>
<th>TOTAL</th>
<th></th>
<th>BASE</th>
<th></th>
<th>ABILITY</th>
<th></th>
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

</table>

</td>

<!-- Weapon & Armour Toggles -->

<td class="quarter">
<table>
<tr><td>Weapons:</td>
<td><?php for ( $i = 1; $i <= 4; $i++ ) { ?>
<input type="checkbox" <?php getnc('Wep'.$i.'Disp'); ?> onclick="ToggleDisplay('weapon<?php echo $i ?>', this);" style="width:12px; border:none;"/>
<?php } ?></td>
</tr>
<tr><td>Armor:</td>
<td><?php for ( $i = 1; $i <= 4; $i++ ) { ?>
<input type="checkbox" <?php getnc('Arm'.$i.'Disp'); ?> onclick="ToggleDisplay('armor<?php echo $i ?>', this);" style="width:12px; border:none;"/>
<?php } ?></td>
</tr>
</table>

</td>
</table>

<!-- Weapons -->

<?php for( $i = 1; $i <= 4; $i++ ) { ?>
<div id="weapon<?php echo $i; ?>">
<table class="weapon" cellspacing="0">

<tr class="header">
<td colspan="3"><div class="header">WEAPON</div></td>
<td colspan="2"><div class="header">ATTACK BONUS</div></td>
<td><div class="header">DAMAGE</div></td>
<td><div class="header">CRITICAL</div></td>
</tr>

<tr>
<td colspan="3"><input type="text" <?php getnv("Weapon".$i); ?> class="full borderless left"></td>
<td colspan="2"><input type="text" <?php getnv("WeaponAttack".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("WeaponDamage".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("WeaponCritical".$i); ?> class="full borderless"></td>
</tr>

<tr class="header">
<td><div class="header">RANGE</div></td>
<td><div class="header">WEIGHT</div></td>
<td><div class="header">TYPE</div></td>
<td><div class="header">SIZE</div></td>
<td colspan="3"><div class="header">PROPERTIES</div></td>
</tr>

<tr>
<td><input type="text" <?php getnv("WeaponRange".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("WeaponWeight".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("WeaponType".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("WeaponSize".$i); ?> class="full borderless"></td>
<td colspan="3"><input type="text" <?php getnv("WeaponProperties".$i); ?> class="full borderless left"></td>
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
<td colspan="2"><div class="header">TYPE</div></td>
<td><div class="header">EQUIPMENT BONUS</div></td>
<td><div class="header">PROFICIENT</div></td>
</tr>

<tr>
<td colspan="3"><input type="text" <?php getnv("Armor".$i); ?> class="full borderless left"></td>
<td colspan="2"><input type="text" <?php getnv("ArmorType".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("ArmorBonus".$i); ?> class="full borderless"></td>
<td><input type="checkbox" <?php getnc("ArmorProficient".$i); ?> class="borderless"></td>
</tr>

<tr class="header">
<td><div class="header">PENALTY</div></td>
<td><div class="header">WEIGHT</div></td>
<td><div class="header">SPEED</div></td>
<td><div class="header">SIZE</div></td>
<td><div class="header">MAX DEX</div></td>
<td colspan="2"><div class="header">PROPERTIES</div></td>
</tr>

<tr>
<td><input type="text" <?php getnv("ArmorPenalty".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("ArmorWeight".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("ArmorSpeed".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("ArmorSize".$i); ?> class="full borderless"></td>
<td><input type="text" <?php getnv("ArmorMaxDex".$i); ?> class="full borderless"></td>
<td colspan="2"><input type="text" <?php getnv("WeaponProperties".$i); ?> class="full borderless left"></td>
</tr>

</table>
</div>
<?php } ?>

<br class="page">


<table class="full">
<tr><td class="half">

<!-- Skills -->
<div class="section">
<h1>Skills</h1>

<?php $skillCount = 50; ?>

<table id="skills" class="abilities">
	<tr>
		<th>CLS</th>
		<th><a class="sort" href="javascript:SkillSort(Sort.ByName);">SKILL</a></th>
		<th><a class="sort" href="javascript:SkillSort(SkillSort.ByAbility);">ABILITY</a></th>
		<th>TOT</th>
		<th></th>
		<th>MOD</th>
		<th></th>
		<th>RANK</th>
		<th></th>
		<th>MISC</th>
	</tr>
<?php for( $i = 1; $i <= $skillCount; $i++ ) {
        $skillName = sprintf( "Skill%02d", $i );
?>

	<tr>
		<td><input type="checkbox" <?php getnv("SkillClass".$i); ?> class="check" style="width:10px;"></td>
		<td><input type="text" <?php getnv($skillName); ?> class="large skill left" onchange="updateSkill(this);"></td>
		<td><input type="text" <?php getnv($skillName."Ability"); ?> class="small skill center" onchange="updateSkill(this);"></td>
		<td><input type="text" <?php getnv($skillName."Total"); ?> class="small skill center" readonly></td>
		<td>=</td>
		<td><input type="text" <?php getnv($skillName."Mod"); ?> class="small skill center" readonly></td>
		<td>+</td>
		<td><input type="text" <?php getnv($skillName."Rank"); ?> class="small skill center" onchange="updateSkill(this);"></td>
		<td>+</td>
		<td><input type="text" <?php getnv($skillName."Misc"); ?> class="small skill center" onchange="updateSkill(this);"></td>
	</tr>

<?php } ?>

</table>

</div>

</td><td class="half" valign="top">

<!-- Equipment -->
<div>
<h1>Gear</h1>

<?php $gearCount = 48; ?>

<table class="abilities">
<tr>
	<?php $gearTable = 0; ?>
	<?php for( $i = 1; $i <= $gearCount; $i++ ) { ?>
		<?php if( $i % ($gearCount / 2) == 1 ) { ?>
			<td>
				<table id="gear<?php echo $gearTable; ?>" class="abilities-nb">
					<tr class="label">
						<th class="full"><a class="sort" href="javascript:GearSort(Sort.ByName);">ITEM</a></th>
						<th><a class="sort" href="javascript:GearSort(Sort.ByWeight);">WEIGHT</a></th>
					</tr>
		<?php } ?>

					<tr>
						<td><input type="text" <?php getnv("Gear".$i); ?> class="full skill left"></td>
						<td><input type="text" <?php getnv("GearWeight".$i); ?> class="small skill"></td>
					</tr>

		<?php if( $i % ($gearCount / 2) == 0 ) { ?>
			<?php $gearTable++; ?>
				</table>
			</td>
		<?php } ?>
	<?php } ?>
</tr>
</table>
</div>

<br>

<!-- Feats -->
<div>
<h1>Feats</h1>

<table class="abilities">
<tr>

<?php $featCount = 24; ?>

<?php for( $i = 1; $i <= $featCount; $i++) { ?>
<?php if( $i % ($featCount / 2) == 1 ) { ?>
	<td>
	<table class="abilities-nb">
<?php } ?>

	<tr>
		<td><input type="text" <?php getnv("Feat".$i); ?> class="full skill left"></td>
	</tr>

<?php if( $i % ($featCount / 2) == 0 ) { ?>
	</table>
	</td>
<?php } ?>

<?php } ?>

</tr>
</table>
</div>

<br>

<!-- Allegiances -->
<div>
<h1>Allegiances</h1>

<table class="abilities">
<tr>

<?php $allegianceCount = 6; ?>

<?php for( $i = 1; $i <= $allegianceCount; $i++) { ?>
<?php if( $i % ($allegianceCount / 2) == 1 ) { ?>
	<td>
	<table class="abilities-nb">
<?php } ?>

	<tr>
		<td><input type="text" <?php getnv("Allegiance".$i); ?> class="full skill left"></td>
	</tr>

<?php if( $i % ($allegianceCount / 2) == 0 ) { ?>
	</table>
	</td>
<?php } ?>

<?php } ?>

</tr>
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
			<th class="full">LANGUAGE</th><th>R/W</th>
		</tr>

<?php } ?>

	<tr>
		<td><input type="text" <?php getnv("Language".$i); ?> class="full skill left"></td>
		<td><input type="text" <?php getnv("LanguageRW".$i); ?> class="small skill"></td>
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

<br class="page">

<table class="full">
<tr><td class="half">
<!-- FX Abilities -->
<h1>FX Abilities</h1>
<table class="abilities spaced">

<?php $fxCount = 15; ?>

<tr>
<th>ARCANE SPELLS</th>
<th>DIVINE SPELLS</th>
<th>PSIONIC POWERS</th>
</tr>

<?php for( $i = 1; $i <= $fxCount; $i++ ) { ?>

<tr>
<td><input type="text" <?php getnv("Arcane".$i); ?> class="full skill left"></td>
<td><input type="text" <?php getnv("Divine".$i); ?> class="full skill left"></td>
<td><input type="text" <?php getnv("Psionic".$i); ?> class="full skill left"></td>
</tr>

<?php } ?>
</table>

</td><td class="half">
<!-- Talents & Special Abilities -->

<h1>Talents & Special Abilities</h1>
<table class="abilities spaced">
<tr>
<?php $talentCount = 30; ?>

<?php for( $i = 1; $i <= $talentCount; $i++ ) { ?>

	<?php if( $i % ($talentCount / 2) == 1 ) { ?>
		<td>
		<table class="abilities-nb">
			<tr><th>TALENT</th></tr>
	<?php } ?>

	<tr>
	<td><input type="text" <?php getnv("Talent".$i); ?> class="full skill left"></td>
	</tr>

	<?php if( $i % ($talentCount / 2) == 0 ) { ?>
		</table>
		</td>
	<?php } ?>

<?php } ?>
</table>

</td></tr>
</table>



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
                  <td align="right">d20Modern Character Sheet version <?php echo $sheetVer; ?> by Tarlen</td>
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
