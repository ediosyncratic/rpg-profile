// pic.js

// Implements event handlers for changing the character picture.

// Dependencies:
//     general.js

function SetPic()
{
  if (READONLY) {
    return;
  }
  // Get the current path.
  var path = sheet().PicURL.value;

  if (path.length == 0)
    path = "http://";
  else if (path == "v4/blank.png")
    path = "none";

  // Get a uri from the user.
  var uri = prompt("Enter a URI for your character's portrait, or type 'none' to leave the portrait slot blank.\n\nThe image should be 215 pixels wide by 215 pixels high, or a similar aspect ratio.", path);

  if (uri == "none") {
    sheet().PicURL.value = "";
    document.getElementById("pic").src = "v4/blank.png";
    document.getElementById("charPic").style.display = "none";
    document.getElementById("noCharPic").style.display = "block";
  } else if (uri && (uri != "http://")) {
    sheet().PicURL.value = uri;
    document.getElementById("pic").src = uri;
    document.getElementById("charPic").style.display = "block";
    document.getElementById("noCharPic").style.display = "none";
  }
}

function RefreshPic()
{
  if (sheet().PicURL.value.length) {
    document.getElementById("pic").src = sheet().PicURL.value;
    document.getElementById("charPic").style.display = "block";
    document.getElementById("noCharPic").style.display = "none";
  }
}
