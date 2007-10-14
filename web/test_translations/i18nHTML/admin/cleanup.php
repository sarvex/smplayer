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
include_once("login.php");
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("WWW translation: automatic cleanup");
echo "</head><body>";
generateLanguageBar();

// delete empty translations
$query = "DELETE FROM ${i18nHTMLsqlPrefix}map WHERE translation=\"\"";
mysql_query($query, $connection);

// delete empty source text entries
$query = "DELETE FROM ${i18nHTMLsqlPrefix}map WHERE text=\"\"";
mysql_query($query, $connection);

// delete translations containing only a space
$query = "DELETE FROM ${i18nHTMLsqlPrefix}map WHERE translation=\" \"";
mysql_query($query, $connection);





$query = "SELECT uid FROM ${i18nHTMLsqlPrefix}accounts WHERE level=0";
$result = mysql_query($query, $connection);     
$num = 0;
if ($result)
  $num = mysql_numrows($result);
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  $cid = $row['uid'];
  $query2 = "SELECT count(*) FROM ${i18nHTMLsqlPrefix}map WHERE uid=$cid";
  $result2 = mysql_query($query2, $connection);     
  $num2 = 0;
  if ($result2) {
    $row2 = mysql_fetch_array($result2);
    $num2 = $row2[0];
  }
  if ($num2 == 0) {
    $query3 = "UPDATE ${i18nHTMLsqlPrefix}accounts SET level=-1 WHERE uid=$cid";
    mysql_query($query3, $connection);     
  }
 }
BP();
H2("Automatic translation cleanup done.");
EP();
HR();
generateFooter();
echo "</body></html>";
?>