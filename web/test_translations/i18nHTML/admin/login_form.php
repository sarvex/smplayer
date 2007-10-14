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
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("i18nHTML: signup");
echo "</head><body>";
setTranslateLinkMarker("");
generateLanguageBar();
H2("i18nHTML login");
BP();
if (isset($error_message))
  echo $error_message;
W("Note that your account is tied to a particular language.");
BR();
W("The currently selected language is `%s'.",
  $lang);
EP();
echo "<div align=center>\n";
echo "<form name=\"login_form\" method=\"post\" action=\"index.php?xlang=$lang\">\n";
?>
<table cellspacing="1">
<tr>
<td width="25%"><?php W("Login");?></td>
<td width="75%"><input type="text" name="username" size="32" maxlength="32" /></td>
</tr>
<tr>
<td><?php W("Password");?></td>
<td><input type="password" name="password" size="32" maxlength="128" /></td>
</tr>
<tr>
<td colspan=2><input type="submit" class="button" value="<?php TRANSLATE("Login");?>" /></td>
</tr>
</table>
</form>
</div>
<?php
BP();
W("Signup for accounts %s.",
  extlink_("signup_form.php", "here"));
EP();
HR();
generateFooter();
?>
</body>
</html>
