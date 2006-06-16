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
    sheet().ACOther,
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

