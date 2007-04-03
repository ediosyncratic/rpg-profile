// ac.js

// Implements functions used for maintining the AC table.

// Dependencies:
//    debug.js
//    general.js

// void ACCalc(void)
// Recalculates the ac table.
function ACCalc()
{
  if (disable_autocalc())
    return;

  ZeroFill(
    sheet().ACArmor,
    sheet().ACShield,
    sheet().ACOther,
    sheet().ACDex,
    sheet().ACSize,
    sheet().ACNat,
    sheet().ACDeflect,
    sheet().ACMisc);

  ACCheckMaxDex();

  sheet().AC.value = Clean(Add(
    10,
    sheet().ACArmor.value,
    sheet().ACShield.value,
    sheet().ACDex.value,
    sheet().ACOther.value,
    sheet().ACSize.value,
    sheet().ACNat.value,
    sheet().ACDeflect.value,
    sheet().ACMisc.value));

  sheet().TouchAC.value = Clean(Add(
    10,
    sheet().ACOther.value,
    sheet().ACDex.value,
    sheet().ACSize.value,
    sheet().ACDeflect.value,
    sheet().ACMisc.value));

  // Flat-footed AC.
  sheet().FFAC.value = Clean(Add(
    10,
    sheet().ACArmor.value,
    sheet().ACShield.value,
    sheet().ACOther.value,
    sheet().ACSize.value,
    sheet().ACNat.value,
    sheet().ACDeflect.value,
    sheet().ACMisc.value));

  debug.trace("Calculated AC.");
}

// void ACChangeArmor(void)
// Copies the data from the armor table to the ac block and recalculates
// the ac.
function ACChangeArmor()
{
  if (disable_autocalc())
    return;

  sheet().ACArmor.value  = 0;
  if ( sheet().Armor1Worn.checked )
  {
      sheet().Armor1Carried.checked = true;
      sheet().ACArmor.value = Clean(Add(sheet().ACArmor.value, GetNum(sheet().Armor1Bonus)));
  }

  if ( sheet().Armor3Worn.checked )
  {
      sheet().Armor3Carried.checked = true;
      sheet().ACArmor.value = Clean(Add(sheet().ACArmor.value, GetNum(sheet().Armor3Bonus)));
  }

  if ( sheet().Armor4Worn.checked )
  {
      sheet().Armor4Carried.checked = true;
          sheet().ACArmor.value = Clean(Add(sheet().ACArmor.value, GetNum(sheet().Armor4Bonus)));
  }

  sheet().ACShield.value  = 0;
  if ( sheet().Armor2Worn.checked )
  {
      sheet().Armor2Carried.checked = true;
     sheet().ACShield.value = GetNum(sheet().Armor2Bonus);
  }

  debug.trace("Copied armor ac bonus to the ac block.");

  ACCalc();

  // We need to call this because we may have changed the 'carried' flag
  CalcWeight();  
}

// void ACChangeCarried(void)
// Turns of the "worn" check for any armor not carried.
// the ac.
function ACChangeCarried()
{
  if (disable_autocalc())
    return;

  if ( !sheet().Armor1Carried.checked )
      sheet().Armor1Worn.checked = false;

  if ( !sheet().Armor2Carried.checked )
      sheet().Armor2Worn.checked = false;

  if ( !sheet().Armor3Carried.checked )
      sheet().Armor3Worn.checked = false;

  if ( !sheet().Armor4Carried.checked )
      sheet().Armor4Worn.checked = false;

  ACChangeArmor();
}

function ACCheckMaxDex() {

  var dexBonus = parseInt(sheet().DexMod.value);
  var dexTempBonus = parseInt(sheet().DexTempMod.value);
  if( ! isNaN(dexTempBonus) ) {
    dexBonus = dexTempBonus;
  }

  var rawBonus = dexBonus;

  for( var i = 1; i <= 4; i++ ) {
    if( ! isNaN( sheet()["Armor" + i + "Dex"].value) ) {
      var armorMaxStr = sheet()["Armor" + i + "Dex"].value;
      if( Trim(armorMaxStr) != "" ) {
        var armorMax = parseInt(armorMaxStr);
        if( armorMax < dexBonus ) {
          dexBonus = armorMax;
        }
      }
    }
  }

  if ( Clean( sheet().TotalWeight.value ) > Clean( sheet().MediumLoad.value ) ) {
    if( dexBonus > 1 ) {
      dexBonus = 1;
    } 
  } else if( Clean( sheet().TotalWeight.value ) > Clean( sheet().LightLoad.value ) ) {
    if( dexBonus > 3 ) {
      dexBonus = 3;
    }
  }

  sheet().ACDex.value = dexBonus;

  if( dexBonus < rawBonus ) {
    sheet().ACDex.title = "Dexterity bonus reduced by Armor and/or Encumberance.";
    sheet().ACDex.style.color           = "white";
    sheet().ACDex.style.backgroundColor = "red";
  } else {
    sheet().ACDex.title = "";
    sheet().ACDex.style.color           = "black";
    sheet().ACDex.style.backgroundColor = "white";
  }
}
