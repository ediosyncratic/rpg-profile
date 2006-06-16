// ac.js

// 3EProfiler (tm) character sheet source file.
// Copyright (C) 2003  Michael J. Eggertson.
// 
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

// **

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
