{*
  error_nobody.tpl

  3EProfiler (tm) template file.
  Copyright (C) 2003 Michael J. Eggertson.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  **

  Internal error page used by the Template class. This page is displayed
  if a template is used but no content has been set. Ideally, this template
  is never used in release versions.
*}
<h1>Crap! (Internal Template Error)</h1>
<p>
  Oh no! No valid template has been set for the body of this page. Bad programmer! Bad!
  Don't forget to make a call to Template::SetBodyTemplate() before sending off
  the results of your script.
</p>
