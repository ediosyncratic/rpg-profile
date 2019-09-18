<?php

// Define constants for abilities
$STR = "Str";
$CON = "Con";
$DEX = "Dex";
$INT = "Int";
$WIS = "Wis";
$CHA = "Cha";

$ABILITY = 'ability';
$PENALTY = 'penalty';

// Define base skills
$skills = array();

$skills["Acrobatics"] =    array($ABILITY => $DEX, $PENALTY => true);
$skills["Arcana"] =        array($ABILITY => $INT, $PENALTY => false);
$skills["Athletics"] =     array($ABILITY => $STR, $PENALTY => true);
$skills["Bluff"] =         array($ABILITY => $CHA, $PENALTY => false);
$skills["Diplomacy"] =     array($ABILITY => $CHA, $PENALTY => false);
$skills["Dungeoneering"] = array($ABILITY => $WIS, $PENALTY => false);
$skills["Endurance"] =     array($ABILITY => $CON, $PENALTY => true);
$skills["Heal"] =          array($ABILITY => $WIS, $PENALTY => false);
$skills["History"] =       array($ABILITY => $INT, $PENALTY => false);
$skills["Insight"] =       array($ABILITY => $WIS, $PENALTY => false);
$skills["Intimidate"] =    array($ABILITY => $CHA, $PENALTY => false);
$skills["Nature"] =        array($ABILITY => $WIS, $PENALTY => false);
$skills["Perception"] =    array($ABILITY => $WIS, $PENALTY => false);
$skills["Religion"] =      array($ABILITY => $INT, $PENALTY => false);
$skills["Stealth"] =       array($ABILITY => $DEX, $PENALTY => true);
$skills["Streetwise"] =    array($ABILITY => $CHA, $PENALTY => false);
$skills["Thievery"] =      array($ABILITY => $DEX, $PENALTY => true);

?>
<script type="text/javascript">
var skillAbilities = [];
<?php foreach( $skills as $skillName => $skillAttributes) { ?>
skillAbilities['skill<?= $skillName ?>'] = '<?= $skillAttributes[$ABILITY] ?>';
<?php } ?>
</script>
