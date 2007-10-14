<?php
/*
     (C) 2007 Christian Grothoff

     This code is free software; you can redistribute it and/or modify
     it under the terms of the GNU General Public License as published
     by the Free Software Foundation; either version 2, or (at your
     option) any later version.

     The code is distributed in the hope that it will be useful, but
     WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
     General Public License for more details.

     You should have received a copy of the GNU General Public License
     along with the code; see the file COPYING.  If not, write to the
     Free Software Foundation, Inc., 59 Temple Place - Suite 330,
     Boston, MA 02111-1307, USA.
*/
include_once("i18nHTML/i18nhtml.php");
include("login.php");
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("i18nHTML: setup languages");
echo "</head><body>";
generateLanguageBar();
H2("Add language");
?>
<div align=center>
<form name="lang_form" method="post" action="add_language.php">
<table cellspacing="1">
<tr>
<td width="25%" align="right"><?php W("New language: ");?></td>
<td width="75%" align="left"><input type="text" name="newlang" size="16" maxlength="32" /></td>
</tr>
<tr>
<td width="25%" align="right"><?php W("Default translations apply: ");?></td>
<td width="75%" align="left"><input type="checkbox" name="def" value="1" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" class="button" value="<?php TRANSLATE("Submit");?>"/></td>
</tr>
</table>
</form>
</div>
<?php
generateFooter();
?>
</body>
</html>
