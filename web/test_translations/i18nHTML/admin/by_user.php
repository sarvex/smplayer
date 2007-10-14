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
echo "<html><head>\n";
TITLE("i18nHTML administration: edit translations (by user)");
echo "</head><body>";
$truid = $_REQUEST['truid'];
if (! is_numeric($truid)) {
  W("Invalid access.");
  generateFooter();
  echo "</body></html>";
  die();
 }
$query2 = "SELECT level FROM ${i18nHTMLsqlPrefix}accounts WHERE uid=${truid}";
$result2 = mysql_query($query2, $connection);
$ok = 1;
if ($result2) {
  $num = mysql_numrows($result2);
  if ($num == 1) {
    $row = mysql_fetch_array($result2);
    $trlevel = $row["level"];
    if ( ($level <= $trlevel) &&
	 ($truid != $uid) )
      $ok = 0; // insufficient level!
  }
 }
if ($ok == 0) {
  W("This page requires higher-level access priviledges."); 
  generateFooter();
  echo "</body></html>";
  die();
 }

$data = ARRAY();
$query = "SELECT name,ip,translation,tid FROM ${i18nHTMLsqlPrefix}map WHERE uid=$truid ORDER BY ip";
$result = mysql_query($query, $connection);
$perfect = 0;
$num = 0;
$alpha = 1;
if ($result)
  $num = mysql_numrows($result);

H2("Translations by %s", "${truid}");
echo "<form name=\"dig_form\" method=\"post\" action=\"delete.php?xlang=${lang}\">\n";
echo "<table border='5'>\n";
echo "<tr>";
TH("Original and Translation");
TH("IP");
TH("Delete");
echo "</tr>\n";


while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  if (! $row) 
    continue; // oops!?
  $text = htmlentities(stripslashes($row["name"]));
  $translation = stripslashes($row["translation"]);
  $tid = $row["tid"];
  $ipaddr = $row["ip"];
  if (! is_numeric($tid))
    continue; // oops!?


  echo "<tr><td><table border=0><tr><td>&quot;$text&quot;</td></tr>\n" . 
       "<tr><td><input type=\"text\" name=\"eid${tid}\" value=\"$translation\" maxlength=4000 size=80 /></td></tr></table></td>\n" . 
       "<td>$ipaddr</td>\n" .
       "<td><input type=\"checkbox\" name=\"tid${tid}\" value=\"1\" /></td></tr>";
}
echo "</table>\n";
BR();
echo "<input type=\"submit\" class=\"button\" value=\"";
TRANSLATE("Update translations");
echo "\"/>";
echo "</form>\n";
HR();
generateFooter();
echo "</body></html>";
?>
