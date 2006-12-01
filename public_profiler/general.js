function ToggleDisplay( id )
{
  var obj = GetObject(id).style;
  var state = obj.display == "none" ? "block" : "none";
  obj.display = state;

}

function GetObject( id ) {
  var obj;
  if (document.all) { //IS IE 4 or 5 (or 6 beta)
    obj = eval( "document.all." + id );
  }
  if (document.layers) { //IS NETSCAPE 4 or below
    obj = document.layers[id];
  }
  if (document.getElementById && !document.all) {
    obj = document.getElementById(id);
  }
  return obj;
}

