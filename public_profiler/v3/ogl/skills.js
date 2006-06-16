// ogl/skills.js

// 3EProfiler (tm) source file.
// Copyright (C) 2003 Michael J. Eggertson.

// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

// **

// Skill information used by 3EProfiler that was released by WotC under
// the Open Gaming License (OGL). This file however, is not released under
// the OGL (see above).

var abilityKeys = [
  , // zero index undefined.
  'Str',
  'Dex',
  'Con',
  'Int',
  'Wis',
  'Cha'
];

// Defines the key abilities for each set of core skills.
var skillKeys = {
  'appraise': 4,
  'balance': 2,
  'bluff': 6,
  'climb': 1,
  'concentration': 3,
  'craft': 4,
  'decipher script': 4,
  'diplomacy': 6,
  'disable device': 4,
  'disguise': 6,
  'escape artist': 2,
  'forgery': 4,
  'gather information': 6,
  'handle animal': 6,
  'heal': 5,
  'hide': 2,
  'intimidate': 6,
  'jump': 1,
  'knowledge': 4,
  'listen': 5,
  'move silently': 2,
  'open lock': 2,
  'perform': 6,
  'profession': 5,
  'ride': 2,
  'search': 4,
  'sense motive': 5,
  'sleight of hand': 2,
  'spellcraft': 4,
  'spot': 5,
  'survival': 5,
  'swim': 1,
  'tumble': 2,
  'use magic device': 6,
  'use rope': 2
};

// Defines which skills are class skills for each core class.
var classSkills = {
                           // Bbn Brd Clr Drd Ftr Mnk Pal Rgr Rog Sor Wiz
  'Appraise':                 [0,  1,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Balance':                  [0,  1,  0,  0,  0,  1,  0,  0,  1,  0,  0],
  'Bluff':                    [0,  1,  0,  0,  0,  0,  0,  0,  1,  1,  0],
  'Climb':                    [1,  1,  0,  0,  1,  1,  0,  1,  1,  0,  0],
  'Concentration':            [0,  1,  1,  1,  0,  1,  1,  1,  0,  1,  1],
  'Craft':                    [1,  1,  1,  1,  1,  1,  1,  1,  1,  1,  1],
  'Decipher Script':          [0,  1,  0,  0,  0,  0,  0,  0,  1,  0,  1],
  'Diplomacy':                [0,  1,  1,  1,  0,  1,  1,  0,  1,  0,  0],
  'Disable Device':           [0,  0,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Disguise':                 [0,  1,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Escape Artist':            [0,  1,  0,  0,  0,  1,  0,  0,  1,  0,  0],
  'Forgery':                  [0,  0,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Gather Information':       [0,  1,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Handle Animal':            [1,  0,  0,  1,  1,  0,  1,  1,  0,  0,  0],
  'Heal':                     [0,  0,  1,  1,  0,  0,  1,  1,  0,  0,  0],
  'Hide':                     [0,  1,  0,  0,  0,  1,  0,  1,  1,  0,  0],
  'Intimidate':               [1,  0,  0,  0,  1,  0,  0,  0,  1,  0,  0],
  'Jump':                     [1,  1,  0,  0,  1,  1,  0,  1,  1,  0,  0],
  'Knowledge: Arcana':        [0,  1,  1,  0,  0,  1,  0,  0,  0,  1,  1],
  'Knowledge: Architecture':  [0,  1,  0,  0,  0,  0,  0,  0,  0,  0,  1],
  'Knowledge: Dungeoneering': [0,  1,  0,  0,  0,  0,  0,  1,  0,  0,  1],
  'Knowledge: Geography':     [0,  1,  0,  0,  0,  0,  0,  1,  0,  0,  1],
  'Knowledge: History':       [0,  1,  1,  0,  0,  0,  0,  0,  0,  0,  1],
  'Knowledge: Local':         [0,  1,  0,  0,  0,  0,  0,  0,  1,  0,  1],
  'Knowledge: Nature':        [0,  1,  0,  1,  0,  0,  0,  1,  0,  0,  1],
  'Knowledge: Nobility':      [0,  1,  0,  0,  0,  0,  1,  0,  0,  0,  1],
  'Knowledge: Religion':      [0,  1,  1,  0,  0,  1,  1,  0,  0,  0,  1],
  'Knowledge: The Planes':    [0,  1,  1,  0,  0,  0,  0,  0,  0,  0,  1],
  'Listen':                   [1,  1,  0,  1,  0,  1,  0,  1,  1,  0,  0],
  'Move Silently':            [0,  1,  0,  0,  0,  1,  0,  1,  1,  0,  0],
  'Open Lock':                [0,  0,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Perform':                  [0,  1,  0,  0,  0,  1,  0,  0,  1,  0,  0],
  'Profession':               [0,  1,  1,  1,  0,  1,  1,  1,  1,  1,  1],
  'Ride':                     [1,  0,  0,  1,  1,  0,  1,  1,  0,  0,  0],
  'Search':                   [0,  0,  0,  0,  0,  0,  0,  1,  1,  0,  0],
  'Sense Motive':             [0,  1,  0,  0,  0,  1,  1,  0,  1,  0,  0],
  'Sleight of Hand':          [0,  1,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Speak Language':           [0,  1,  0,  0,  0,  0,  0,  0,  0,  0,  0],
  'Spellcraft':               [0,  1,  1,  1,  0,  0,  0,  0,  0,  1,  1],
  'Spot':                     [0,  0,  0,  1,  0,  1,  0,  1,  1,  0,  0],
  'Survival':                 [1,  0,  0,  1,  0,  0,  0,  1,  0,  0,  0],
  'Swim':                     [1,  1,  0,  1,  1,  1,  0,  1,  1,  0,  0],
  'Tumble':                   [0,  1,  0,  0,  0,  1,  0,  0,  1,  0,  0],
  'Use Magic Device':         [0,  1,  0,  0,  0,  0,  0,  0,  1,  0,  0],
  'Use Rope':                 [0,  0,  0,  0,  0,  0,  0,  1,  1,  0,  0]
};

// Now transform the classSkill object to contain a bitset rather than an array.
for (var skill in classSkills)
{
  var cc_code = 0;
  for (var i = 0; i < classSkills[skill].length; i++)
    cc_code = (cc_code << 1) | classSkills[skill][i];
  classSkills[skill] = cc_code;
}
