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
    sheet().ACDex,
    sheet().ACSize,
    sheet().ACNat,
    sheet().ACDeflect,
    sheet().ACMisc);

  sheet().AC.value = Clean(Add(
    10,
    sheet().ACArmor.value,
    sheet().ACShield.value,
    sheet().ACDex.value,
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

  sheet().ACArmor.value = GetNum(sheet().ArmorBonus);

  debug.trace("Copied armor ac bonus to the ac block.");

  ACCalc();
}

// void ACChangeShield(void)
// Copies the data from the sheild table to the ac block and recalculates
// the ac.
function ACChangeShield()
{
  if (disable_autocalc())
    return;

  sheet().ACShield.value = GetNum(sheet().ShieldBonus);

  debug.trace("Copied shield ac bonus to the ac block.");

  ACCalc();
}
