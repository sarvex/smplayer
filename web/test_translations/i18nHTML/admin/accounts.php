<?php
/*
     (C) 2006, 2007 Christian Grothoff

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
TITLE("i18nHTML account administration");
echo "</head><body>";
generateLanguageBar();
H2("i18nHTML account administration");

if ( ($uid <= 0) || ($level <= 0) ) {
  W("Only authorized users can administer accounts.");
  die();
 }

$query = "SELECT username,realname,level,uid,allowed FROM ${i18nHTMLsqlPrefix}accounts WHERE level < $level AND level >= 0";
if ($uid != 1)
  $query = $query + " AND allowed=$xlang";  
$result = mysql_query($query, $connection);     
$num = 0;
if ($result)
  $num = mysql_numrows($result);
if ($num == 0) {
  W("There are no accounts that you are authorized to administer at this time.");
  die();
 }
echo "<table border=2>";
echo "<tr><th>Login</th><th>Real name</th><th>Language</th><th>Level</th><th>Translations</th><th>Actions</th></tr>\n";
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  $log = $row['username'];
  $rn  = $row['realname'];
  $lev = $row['level'];
  $allowed = $row['allowed'];
  $cid = $row['uid'];

  $query2 = "SELECT count(*) FROM ${i18nHTMLsqlPrefix}map WHERE uid=$cid";
  $result2 = mysql_query($query2, $connection);     
  $num2 = 0;
  if ($result2) {
    $row2 = mysql_fetch_array($result2);
    $num2 = $row2[0];
  }
  echo "<tr><td><a href=\"by_user.php?xlang=${lang}&truid=${tuid}\">$log</a></td><td>$rn</td><td>$allowed</td><td>$lev</td><td>$num2</td>\n";
  echo "<td>";
  if ($log != "legacy") {
    echo "<a href=\"manage_account.php?cid=$cid&action=delete\">delete</a>,";
    echo "<a href=\"manage_account.php?cid=$cid&action=promote\">promote</a>,";
    echo "<a href=\"manage_account.php?cid=$cid&action=demote\">demote</a>";
  } else {
    W("No actions apply");
  }
  echo "</td></tr>\n";
 }
echo "</table>";
BP();
W("Delete will delete the account.");
BR();
W("Promote will grant the user the ability to administer accounts of lower level, increasing his level by one.");
BR();
W("Demote will reduce the user's ability to administer accounts of lower level, decreasing his level by one.");
EP();
HR();
generateFooter();
echo "</body></html>\n";
?>