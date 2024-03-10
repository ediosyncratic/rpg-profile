// notes.js

// Functions pertaining to the notes area.

function ShowNotes()
{
  var w = window.open();
  child_windows.push(w);

  doc = w.document;
  doc.open();
  doc.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><link type="text/css" rel="stylesheet" href="v3/main.css" /></head><body><table class="notes"><tr class="header"><td>Other Notes</td></tr><tr><td><div>');
  doc.write(sheet().Notes.value.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, "<br />\n"));
  doc.write('</div></td></tr></table></body></html>');
  doc.close();
}
