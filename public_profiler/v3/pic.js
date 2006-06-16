// pic.js

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

// Implements event handlers for changing the character picture.

// Dependencies:
//     general.js

function SetPic()
{
  if (READONLY)
    return;

  // Get the current path.
  var path = sheet().PicURL.value;

  if (path.length == 0)
    path = "http://";
  else if (path == "v3/blank.png")
    path = "none";

  // Get a uri from the user.
  var uri = prompt("Enter a URI for your character's portrait, or type 'none' to leave the portrait slot blank.\n\nThe image should be 125 pixels wide by 193 pixels high, or a similar aspect ratio.", path);

  if (uri == "none")
  {
    sheet().PicURL.value = "v3/blank.png";
    document.getElementById("pic").src = "v3/blank.png";
  }
  else if (uri && (uri != "http://"))
  {
    sheet().PicURL.value = uri;
    document.getElementById("pic").src = uri;
  }
}

function RefreshPic()
{
  if (sheet().PicURL.value.length)
    document.getElementById("pic").src = sheet().PicURL.value;
}
