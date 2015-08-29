// spells.js

// Defines scripts used to maintain the spell list table.

var SPELL_COUNT = 300;

function SpellSort(sortfunc)
{
 
  // Copy the data from each of the items in the rows.
  debug.trace("Copying spell data...");
  var data = new Array();
  for (var i = 1; i <= SPELL_COUNT; i++)
  {
    var num = FormatNumber(i);
    var thisdata = new Object();
    thisdata.spell = sheet()["Spell" + num].value;
    thisdata.mem = sheet()["Spell" + num + "Cast"].value;
    thisdata.level = sheet()["Spell" + num + "Level"].value;
    data.push(thisdata);
  }

  // Now sort the data according to the given sortfunc.
  debug.trace("Sorting spell data...");
  data.sort(sortfunc);

  // Finally, re-copy all the data.
  debug.trace("Copying sorted spell data...");
  for (var i = 1; i <= SPELL_COUNT; i++)
  {
    var thisdata = data.shift();
    var num = FormatNumber(i);
    sheet()["Spell" + num].value = thisdata.spell;
    sheet()["Spell" + num + "Cast"].value = thisdata.mem;
    sheet()["Spell" + num + "Level"].value = thisdata.level;
  }

  debug.trace("Sorting complete.");
}

SpellSort.ByName = function(a, b)
{
  if ((a.spell.length == 0) && (b.spell.length == 0))
    return 0;
  else if (a.spell.length == 0)
    return 1;
  else if (b.spell.length == 0)
    return -1;
  return a.spell.localeCompare(b.spell);
}

SpellSort.ByLevel = function(a, b)
{
  if ((a.level.length == 0) && (b.level.length == 0))
    return SpellSort.ByName(a, b);
  else if (a.level.length == 0)
    return 1;
  else if (b.level.length == 0)
    return -1;
  var comp = a.level.localeCompare(b.level);
  if (comp)
    return comp;
  else
    return SpellSort.ByName(a, b);
}

SpellSort.ByMem = function(a, b)
{
  if ((a.mem.length == 0) && (b.mem.length == 0))
    return SpellSort.ByName(a, b);
  else if (a.mem.length == 0)
    return 1;
  else if (b.mem.length == 0)
    return -1;
  var comp = a.mem.localeCompare(b.mem);
  if (comp)
    return comp;
  else
    return SpellSort.ByName(a, b);
}

// Pops up a new window displaying help for a skill.  'node' is the name of the
// input element that contains the name of the skill.
function ShowSpellHelp(node)
{
  var spellName = document.getElementsByName(node)[0].value;
  var URL;

  spellName = Trim(spellName.toLowerCase()).replace(/^(lesser|greater|mass lesser|mass greater|mass) (.*)$/, "$2, $1");
  URL = _RetrieveMatchingURL( spellName, spellsHelpURL )

  // Check to see if a matching skill was found.
  if ( URL == "" )
    return;

  window.open( URL );
  return;
}

/*

    Checks to see if a skill has a help URL associated with it.  If it does
    then the "help" link will be set to a '?'.  If there is no URL, then the
    link is set to a null string, basically hiding it.

    'node' is the name of the input field containing the skill text.

*/
function CheckForSpellHelp(node)
{
  var spellName = document.getElementsByName(node)[0].value;
  var link      = document.getElementsByName(node + "Link")[ 0 ];

  spellName = Trim(spellName.toLowerCase()).replace(/^(lesser|greater|mass lesser|mass greater|mass) (.*)$/, "$2, $1");
  if ( _RetrieveMatchingURL( spellName, spellsHelpURL ) != "" )
  {
    link.innerHTML = "?";
  }
  else
  {
    link.innerHTML = "";
  }

  return;
}

var spellListHelp =
{
    'bard'   : [ /* 0 */ "http://www.d20srd.org/srd/spellLists/bardSpells.htm#zeroLevelBardSpells",
                 /* 1 */ "http://www.d20srd.org/srd/spellLists/bardSpells.htm#firstLevelBardSpells",
                 /* 2 */ "http://www.d20srd.org/srd/spellLists/bardSpells.htm#secondLevelBardSpells",
                 /* 3 */ "http://www.d20srd.org/srd/spellLists/bardSpells.htm#thirdLevelBardSpells",
                 /* 4 */ "http://www.d20srd.org/srd/spellLists/bardSpells.htm#fourthLevelBardSpells",
                 /* 5 */ "http://www.d20srd.org/srd/spellLists/bardSpells.htm#fifthLevelBardSpells",
                 /* 6 */ "http://www.d20srd.org/srd/spellLists/bardSpells.htm#sixthLevelBardSpells",
                 /* 7 */ "",
                 /* 8 */ "",
                 /* 9 */ ""],
    'cleric' : [ /* 0 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#zeroLevelClericSpells",
                 /* 1 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#firstLevelClericSpells",
                 /* 2 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#secondLevelClericSpells",
                 /* 3 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#thirdLevelClericSpells",
                 /* 4 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#fourthLevelClericSpells",
                 /* 5 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#fifthLevelClericSpells",
                 /* 6 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#sixthLevelClericSpells",
                 /* 7 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#seventhLevelClericSpells",
                 /* 8 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#eighthLevelClericSpells",
                 /* 9 */ "http://www.d20srd.org/srd/spellLists/clericSpells.htm#ninthLevelClericSpells" ],
    'druid'  : [ /* 0 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#zeroLevelDruidSpells",
                 /* 1 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#firstLevelDruidSpells",
                 /* 2 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#secondLevelDruidSpells",
                 /* 3 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#thirdLevelDruidSpells",
                 /* 4 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#fourthLevelDruidSpells",
                 /* 5 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#fifthLevelDruidSpells",
                 /* 6 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#sixthLevelDruidSpells",
                 /* 7 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#seventhLevelDruidSpells",
                 /* 8 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#eighthLevelDruidSpells",
                 /* 9 */ "http://www.d20srd.org/srd/spellLists/druidSpells.htm#ninthLevelDruidSpells" ],
    'paladin': [ /* 0 */ "",
                 /* 1 */ "http://www.d20srd.org/srd/spellLists/paladinSpells.htm#firstLevelPaladinSpells",
                 /* 2 */ "http://www.d20srd.org/srd/spellLists/paladinSpells.htm#secondLevelPaladinSpells",
                 /* 3 */ "http://www.d20srd.org/srd/spellLists/paladinSpells.htm#thirdLevelPaladinSpells",
                 /* 4 */ "http://www.d20srd.org/srd/spellLists/paladinSpells.htm#fourthLevelPaladinSpells",
                 /* 5 */ "",
                 /* 6 */ "",
                 /* 7 */ "",
                 /* 8 */ "",
                 /* 9 */ ""],
    'ranger' : [ /* 0 */ "",
                 /* 1 */ "http://www.d20srd.org/srd/spellLists/rangerSpells.htm#firstLevelRangerSpells",
                 /* 2 */ "http://www.d20srd.org/srd/spellLists/rangerSpells.htm#secondLevelRangerSpells",
                 /* 3 */ "http://www.d20srd.org/srd/spellLists/rangerSpells.htm#thirdLevelRangerSpells",
                 /* 4 */ "http://www.d20srd.org/srd/spellLists/rangerSpells.htm#fourthLevelRangerSpells",
                 /* 5 */ "",
                 /* 6 */ "",
                 /* 7 */ "",
                 /* 8 */ "",
                 /* 9 */ ""],
    'wizard' : [ /* 0 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#zeroLevelSorcererWizardSpells",
                 /* 1 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#firstLevelSorcererWizardSpells",
                 /* 2 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#secondLevelSorcererWizardSpells",
                 /* 3 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#thirdLevelSorcererWizardSpells",
                 /* 4 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#fourthLevelSorcererWizardSpells",
                 /* 5 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#fifthLevelSorcererWizardSpells",
                 /* 6 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#sixthLevelSorcererWizardSpells",
                 /* 7 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#seventhLevelSorcererWizardSpells",
                 /* 8 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#eighthLevelSorcererWizardSpells",
                 /* 9 */ "http://www.d20srd.org/srd/spellLists/sorcererWizardSpells.htm#ninthLevelSorcererWizardSpells"]
};

// This table has the index into spellListHelp for each class.  This table is used
// because some classes have duplicate spell lists and because we must take into
// account the short names.
var spellClasses =
{
    'bard':     'bard',
    'brd':      'bard',
    'cleric':   'cleric',
    'clr':      'cleric',
    'druid':        'druid',
    'drd':      'druid',
    'paladin':  'paladin',
    'pal':      'paladin',
    'ranger':   'ranger',
    'rgr':      'ranger',
    'sorcerer': 'wizard',
    'sor':      'wizard',
    'wizard':   'wizard',
    'wiz':      'wizard'
};

// Default spells list page if no class/level page was found.
var spellsListPage = "http://www.d20srd.org/indexes/spellLists.htm";

/*
    Display the list of spells for the class/level
*/
function ShowSpellListHelp( level )
{
  var link = "";  // Default to no link found.

  // First find the class name that matches a class from spellClasses.
  var className = sheet().Class.value.toLowerCase();
  for ( cl in spellClasses )
  {
    if ( className.indexOf( cl ) == 0 )
     {
       link = spellListHelp[ spellClasses[ cl ] ][ level ];
       break;
     }
  }

  if ( link == "" )
    link = spellsListPage;

  window.open( link );

}

function updateCast() {
    var i;
    for( i = 0; i <= 9; i++ ) {
        sheet()["SpellCast" + i].value = 0;
    }

    for( i = 1; i <= SPELL_COUNT; i++ ) {
        var num = "" + i;
        if( num.length == 1 ) {
            num = "0" + num;
        }
        var spellLevel = "Spell" + num + "Level";
        var spellCast = "Spell" + num + "Cast";
        
        if( isNaN(sheet()[spellLevel].value) ) {
            continue;
        }
      
        var castCount = "SpellCast" + sheet()[spellLevel].value;

        var currentCount = parseInt("0");
        var newCount = parseInt("0");

        if( sheet()[castCount] ) {        
            currentCount = parseInt(sheet()[castCount].value);
            
            if( isNaN(currentCount) ) {
                parseInt("0");
            }
        }

        if( parseInt(sheet()[spellCast].value) ) {
            newCount = parseInt(sheet()[spellCast].value);
            if( isNaN(newCount) ) {
                newCount = parseInt("0");
            }
        }

        if( sheet()[castCount] ) {
            sheet()[castCount].value = currentCount + newCount;
        }
    }
}

var currentPage = 0;
var minPage = 0;
var maxPage = 7;
var columnWidth = 163;

function nextSpellPage() {
    if( currentPage >= maxPage ) {
        return;
    }
    currentPage++;
    
    var targetOffset = -columnWidth * currentPage;
    
    $("spellScroller").morph("left:" + targetOffset + "px;");
    if( currentPage >= maxPage ) {
        $("nextSpellsArrow").addClassName("disabled");
    }
    if( currentPage > minPage ) {
        $("prevSpellsArrow").removeClassName("disabled");
    }
}

function prevSpellPage() {
    if( currentPage <= minPage ) {
        return;
    }
    currentPage--;
    
    var targetOffset = -columnWidth * currentPage;
    
    $("spellScroller").morph("left:" + targetOffset + "px;");
    if( currentPage <= minPage ) {
        $("prevSpellsArrow").addClassName("disabled");
    }
    if( currentPage < maxPage ) {
        $("nextSpellsArrow").removeClassName("disabled");
    }
}

