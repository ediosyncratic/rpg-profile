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
// Copies the data from the armor table to the AC block and
// recalculates the AC.
function ACChangeArmor()
{
  if (disable_autocalc())
    return;

  sheet().ACArmor.value  = 0;
  sheet().ACShield.value  = 0;

  for (var i = 1; i <= 8; i++) {
      if (sheet()['Armor' + i + 'Worn'].checked) {
          sheet()['Armor' + i + 'Carried'].checked = true;
          if (i % 4 == 2)
              sheet().ACShield.value = Clean(Add(sheet().ACShield.value,
                                                 GetNum(sheet()['Armor' + i + 'Bonus'])));
          else
              sheet().ACArmor.value = Clean(Add(sheet().ACArmor.value,
                                                GetNum(sheet()['Armor' + i + 'Bonus'])));
      }
  }

  debug.trace('Copied armor AC bonus to the AC block.');

  ACCalc();

  // We need to call this because we may have changed the 'carried' flag
  CalcWeight();
}

// void ACChangeCarried(void)
// Turns off the "worn" check for any armor not carried and
// recalculates the AC.
function ACChangeCarried()
{
  if (disable_autocalc())
    return;

  for (var i = 1; i <= 8; i++) {
      if (!sheet()['Armor' + i + 'Carried'].checked)
          sheet()['Armor' + i + 'Worn'].checked = false;
  }

  ACChangeArmor();
}

function ACCheckMaxDex() {

  var dexBonus = parseInt(sheet().DexMod.value);
  var dexTempBonus = parseInt(sheet().DexTempMod.value);
  if( ! isNaN(dexTempBonus) ) {
    dexBonus = dexTempBonus;
  }

  var rawBonus = dexBonus;

  for (var i = 1; i <= 8; i++) {
    var armorMaxStr = sheet()['Armor' + i + 'Dex'].value;
    if (!isNaN(armorMaxStr) && Trim(armorMaxStr) != '') {
      var armorMax = parseInt(armorMaxStr);
      if (armorMax < dexBonus)
        dexBonus = armorMax;
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
