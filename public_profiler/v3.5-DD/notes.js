// notes.js

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

// Functions pertaining to the notes area.

function ShowNotes()
{
  var w = window.open();
  child_windows.push(w);

  doc = w.document;
  doc.open();
  doc.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><link type="text/css" rel="stylesheet" href="v3/main.css" /></head><body><table id="notes"><tr class="header"><td>Other Notes</td></tr><tr><td><div>');
  doc.write(sheet().Notes.value.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, "<br />\n"));
  doc.write('</div></td></tr></table></body></html>');
  doc.close();
}
