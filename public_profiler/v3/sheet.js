// sheet.js

// Initialization and cleanup functions for the character sheet.

// Dependencies:
//    (alot...)

// void init(void)
// Called to initialize the document as the body.onload handler.
function init()
{
  // Do total calculations for the skill and weight tables.
  SkillCalcRanks();
  CalcWeight();

  if (sheet().firstload.value == "true")
  {
    sheet().firstload.value = "false";
    _skillFill();
  }

  RefreshPic();
}

// void cleanup(void)
// Called to clean up from the body.onunload handler.
function cleanup()
{
  debug.close();

  for (var i in child_windows)
    child_windows[i].close();
}
