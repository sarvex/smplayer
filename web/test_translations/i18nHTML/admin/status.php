<?php
/*
     (C) 2003, 2004, 2005, 2006, 2007 Christian Grothoff

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
  // This file can be used to obtain some statistics
  // about the progress of the translation.
  // It has no other purpose.

include("i18nHTML/i18nhtml.php");
if (!$connection) {
  echo "Database is down.";
  die();
 }
$mode = $_REQUEST['mode'];
DOCTYPE("HTML", "Transitional");
echo "<html><head>\n";
TITLE("Translation: status");
echo "</head><body>";
H1("i18nHTML statistics");
BP();
W("Language setting is %s.",
  $lang);
P();
$query = "SELECT count FROM ${i18nHTMLsqlPrefix}pending WHERE lang=\"${i18nHTMLsrcLang}\"";
$result = mysql_query($query, $connection);
$num = 0;
if ($result)
  $num = mysql_numrows($result);
W("Sentences in the original ${i18nHTMLsrcLang} text: %s",
  $num);
P();

$stats = ARRAY();
$query = "SELECT lang FROM ${i18nHTMLsqlPrefix}languages ORDER BY lang";
$result = mysql_query($query, $connection);
$total = 0;
$num = 0;
if ($result)
  $num = mysql_numrows($result);
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  if (! $row)
    continue;
  $clang = $row["lang"];
  $query2 = "SELECT tid FROM ${i18nHTMLsqlPrefix}map WHERE lang=\"${clang}\"";
  $result2 = mysql_query($query2, $connection);
  $num2 = 0;
  if ($result)
    $num2 = mysql_numrows($result2);
  if ($clang != $i18nHTMLsrcLang) {
    $stats[$clang] = $num2;
    $total += $num2;
  }
 }

W("%s translated sentences in database.", $total);
EP();
H2("Translations by language");
echo "<center><table border=5>\n";
echo "<tr>";
TH("Language");
TH("Translations");
echo "</tr>";
foreach ($stats as $a => $b) {
  printf("<tr><td>%s</td><td>%s</td></tr>\n", $a, $b);
}
echo "</table></center>\n";


H2("Translations by translator");
$query = "SELECT username,realname,uid,allowed FROM ${i18nHTMLsqlPrefix}accounts WHERE level >= 0";
$result = mysql_query($query, $connection);     
$num = 0;
if ($result)
  $num = mysql_numrows($result);
echo "<center><table border=2>\n";
echo "<tr><th>Login</th><th>Real name</th><th>Translations</th><th>Language</th>\n";
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  $log = $row['username'];
  $rn  = $row['realname'];
  $allowed  = $row['allowed'];
  $tuid = $row['uid'];

  $query2 = "SELECT tid FROM ${i18nHTMLsqlPrefix}map WHERE uid=$tuid";
  $result2 = mysql_query($query2, $connection);     
  $num2 = 0;
  if ($result2)
    $num2 = mysql_numrows($result2); 
  echo "<tr><td><a href=\"by_user.php?xlang=${lang}&truid=${tuid}\">$log</a></td><td>$rn</td><td align=\"right\">$num2</td><td>$allowed</td></tr>\n";
 }
echo "</table></center>\n";

/* -- far too expensive
H2("Translations by IP");
$query = "SELECT DISTINCT ip FROM ${i18nHTMLsqlPrefix}map ORDER BY ip";
$result = mysql_query($query, $connection);     
$num = 0;
if ($result)
  $num = mysql_numrows($result);
echo "<center><table border=2>\n";
echo "<tr><th>IP</th><th>Translations</th>\n";
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  $ip = $row['ip'];

  $query2 = "SELECT tid FROM ${i18nHTMLsqlPrefix}map WHERE ip=\"$ip\"";
  $result2 = mysql_query($query2, $connection);     
  $num2 = 0;
  if ($result2)
    $num2 = mysql_numrows($result2); 
  echo "<tr><td>$ip</td><td align=\"right\">$num2</td></tr>\n";
 }
echo "</table></center>\n";
*/

HR();
generateFooter();
echo "</body></html>";
?>
