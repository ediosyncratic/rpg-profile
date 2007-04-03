// pic.js

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
