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
H2("Sign up for a new i18nHTML account");
?>
<div align=center>
<form name="login_form" method="post" action="signup.php">
<table cellspacing="1">
<tr>
<td width="25%"><?php W("Desired login");?></td>
<td width="75%"><input type="text" name="username" size="32" maxlength="32" /></td>
</tr>
<tr>
<td width="25%"><?php W("Real name");?></td>
<td width="75%"><input type="text" name="realname" size="32" maxlength="32" /></td>
</tr>
<tr>
<td><?php W("Email");?></td>
<td><input type="email" name="email" size="32" maxlength="128" /></td>
</tr>
<tr>
<td><?php W("Language");?></td>
<td>
<table border=0>
<?php
    $query = "SELECT lang FROM ${i18nHTMLsqlPrefix}languages ORDER BY lang";
    $result = mysql_query($query, $connection);
    $num = 0;
    if ($result)
      $num = mysql_numrows($result);
    while ($num-- > 0) {
      $row = mysql_fetch_array($result);
      $dblang = $row['lang'];
      echo "<tr><td><input type=\"radio\" name=\"language\" value=\"$dblang\">$dblang</input></td></tr>";
    }
?>
</table>
</td>
</tr>
<tr>
<td colspan="2"><input type="submit" class="button" value="<?php TRANSLATE("Signup");?>"/></td>
</tr>
</table>
</form>
</div>
<?php
W("Note that each account is only authorized for translations into the selected language.");
W("You will only be able to login for that particular language.");
W("If you want to translate to multiple languages, you will need to register multiple accounts.");
W("The system does not store your e-mail address in the database.");
W("As a result, there is no way to recover your password if you loose it!");
HR();
generateFooter();
?>
</body>
</html>
