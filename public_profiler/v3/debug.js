// debug.js

// Defines the debug object, whose behavior depends on the debug status
// of the document. This object is primarily used to print trace messages
// from within functions to help track down what's happening.

// Dependencies: none

// void Debug(bool)
// Constructor for a debug object. Pass a true/false value to set the
// global debug mode.
function Debug(mode)
{
  ////////////////////////////////////////////////////////////////////////
  // Public methods.

  // void debug.close(void)
  // Either closes the debug window or does nothing depending on the debug
  // context.
  this.close = mode ? __close : function () {};

  // void debug.trace(string)
  // Either print to the debug window, or do nothing depending on the
  // debug context.
  this.trace = mode ? __trace : function () {};

  // void debug.traceErr(string)
  // Acts as the trace funtion, but the printed message is wrapped in an
  // error span.
  this.traceErr = __traceErr;

  // bool debut.trapErr(string, string, number)
  // An error handler, meant to be a replacement for a window's onerror
  // event handler. In debug mode, the function kills the error and
  // traces a message to the debug window, otherwise, it passes the error
  // onto the window.
  this.trapErr = mode ? __trapErr : function () {return false;};

  ////////////////////////////////////////////////////////////////////////
  // Private members.

  // The output window is either null or a valid window object, depending
  // on the debug context.
  var output = mode ? open("./v3/debug.html", "_blank", "height=300,left=25,width=400,top=25,toolbar=no,status=no,menubar=no,scrollbars=yes") : null;
  // Restore the focus to the main window.
  window.focus();

  ////////////////////////////////////////////////////////////////////////
  // Member implementations.
  
  // void __close(void)
  // Attempts to close the debug window. Error trapping is done in case
  // the function is called before the window finishes loading or if the
  // function is called after the window is closed.
  function __close()
  {
    if (!output.closed)
      output.close();
  }

  // void __trace(string)
  // The trace implementation that is used if the object is in a debug 
  // ontext.
  function __trace(msg)
  {
    // Attempt to pass the message to the debug window. This will
    // initially fail until the debug document loads, so we must wrap
    // the attempt in a try block. Failure will also happen if the
    // user closes the debug window. Since we expect initial erros, just
    // trap them.
    try {output.trace(msg);}
    catch (e){}
  }

  // void __traceErr(string)
  // Prints a message using trace, but encompasses it in an error span.
  function __traceErr(msg)
  {
    // Don't use the this reference, since this function may be called
    // from the global scope from onerror handler.
    __trace("<span class=\"err\">" + msg + "</span>");
  }

  // bool __trapErr(string, string, number)
  // Trap or pass on an error.
  function __trapErr(msg, url, line)
  {
    // Display a message to the debug window, but avoid using the this
    // reference since this may be called from the global scope of an
    // onerror event.
    __traceErr("Scripting error at line " + line + " of file "
      + __stripPath(url, 3) + ":<br />"  + msg
    );

    // Kill the error
    return true;
  }

  // string __stripPath(string, [number = 1])
  // Returns the path string, only the specified number of rightmost
  // components returned.
  function __stripPath(path, depth)
  {
    if (arguments.length < 2)
      depth = 1;

    pathComponents = path.split("/").reverse();
    var retval = new String();
    for (var i = 0; (i < pathComponents.length) && (depth > 0); i++, depth--)
    {
      if (i)
        retval = "/" + retval;
      retval = pathComponents[i] + retval;
    }

    return retval;
  }
}

// Declare the one and only global debug object.
var debug = new Debug(false);
//window.onerror = debug.trapErr;