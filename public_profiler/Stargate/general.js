// general.js

// General functions that are used across several objects.

// Dependencies: none

// A global array of child windows. These are maintained so the application
// automatically closes the windows when the page exits.
var child_windows = new Array();

// string Add(...)
// Accepts any number of arguments. Each argument is parsed for integers
// and the function returns the sum. A zero value is assumed for an
// argument if parsing fails. The return value is a string with a leading
// "+" if the sum is greater than or equal to zero.
function Add()
{
  // Initialize a return value.
  var retval = 0;

  // Sum each of the arguments after parsing for a value.
  for (var i = 0; i < arguments.length; i++)
  {
    var val = parseInt(arguments[i]);
    if (isNaN(val))
      val = 0;
    retval += val;
  }

  // Append a leading "+" if non-negative.
  //if (retval >= 0)
  //  retval = "+" + retval;

  // Return the sum.
  return retval;
}

// number Clean(num)
// Return a "clean" number, one that has been stripped of any leading "+"
// sign, or a zero value if num can't be evaluated to an integer.
function Clean(num)
{
  var retval = parseInt(num);
  if (isNaN(retval))
    retval = 0;
  return retval;
}

// string FormatNumber(num)
// Returns a number with a leading zero if the number is less than ten.
function FormatNumber(num)
{
  if (num < 10)
    return ("0" + num);
  return num;
}

// number GetNum(node)
// Returns an integer that is extracted from the supplied node's value.
// If parsing fails, zero is returned.
function GetNum(node)
{
  var num = parseInt(node.value);
  return isNaN(num) ? 0 : num;
}

// string GetText(node)
// Returns a text string, altered to all lowercase that represents the
// value of the given node. The node is parsed, with any data after the
// first non-alphanumeric or space character removed, and then the leading
// and trailing whitespace is removed.
function GetText(node)
{
  var str = node.value;

  // Converting to lower case allows easier lookup in hash tables.
  str = str.toLowerCase();

  // Strip off any characters after the first char that is not [0-9a-z ],
  // this allows say, the string "Knowledge: Nature" to be matched against
  // a has that only has the string "knowledge".
  var index = str.search(/[^0-9a-z ]/);
  if (index != -1)
    str = str.substr(0, index);

  // Trim any leading and trailing white space.
  str = str.replace(/^\s+/, ''); // leading whitespace
  str = str.replace(/\s+$/, ''); // trailing whitespace

  // Return the parsed string.
  return str;
}

// node sheet(void)
// Returns a reference to the character sheet form.
function sheet()
{
  return document.forms[0];
}

// Shows or hides a node (by id or ref).
function Show(node, show)
{
  if (typeof node == "string")
    // Retrieve a reference to the node.
    node = document.getElementById(node);

  if (!node)
    return;

  node.style.visibility = show ? 'visible' : 'hidden';
}

// void ZeroFill(...)
// Supply any number of nodes to this function. If parsing the node's
// value for an integer fails, a zero will be entered.
function ZeroFill()
{
  for (var i = 0; i < arguments.length; i++) {
    if (isNaN(parseInt(arguments[i].value))) {
      arguments[i].value = 0;
    }
  }
}

function TwentyFill()
{
  for (var i = 0; i < arguments.length; i++) {
    if (isNaN(parseInt(arguments[i].value))) {
      arguments[i].value = 20;
    }
  }
}

function OneFill()
{
  for (var i = 0; i < arguments.length; i++) {
    if (isNaN(parseInt(arguments[i].value))) {
      arguments[i].value = 1;
    }
  }
}

// string Trim( str )
// Uses replace() to perform the equivalent of trim()
function Trim( str )
{
  return str.replace(/^\s*|\s*$/g,"");
}

function ToggleDisplay( id, tick ) 
{
  var obj = GetObject(id);
  
  if( obj != null ) {
      var state = tick.checked ? "block" : "none";
      obj.style.display = state;
  }

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
