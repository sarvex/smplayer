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
if (! isset($_REQUEST['cid'])) {
  W("Invalid invocation.");
  die();
 }  
$cid = $_REQUEST['cid'];
if (! isset($_REQUEST['action'])) {
  W("Invalid invocation.");
  die();
 }  
$action = $_REQUEST['action'];

$query = "SELECT level FROM ${i18nHTMLsqlPrefix}accounts WHERE level < $level AND uid=$cid";
if ($uid != 1)
  $query = $query + " AND allowed=$xlang";  
$result = mysql_query($query, $connection);     
$num = 0;
if ($result)
  $num = mysql_numrows($result);
if ($num == 0) {
  W("You did not select an account that you are authorized to administer at this time.");
 } else if ($action == "delete") {
  $query = "UPDATE ${i18nHTMLsqlPrefix}accounts SET level=-1 WHERE uid=$cid";
  mysql_query($query, $connection);
  W("Account deleted.");
 } else if ($action == "kill") {
  $query = "DELETE FROM ${i18nHTMLsqlPrefix}map WHERE uid=$cid";
  mysql_query($query, $connection);
  W("All translations added by this account deleted.");
  $query = "DELETE FROM ${i18nHTMLsqlPrefix}accounts WHERE uid=$cid";
  mysql_query($query, $connection);
  W("Account deleted.");
 } else {
  $row = mysql_fetch_array($result);
  $nlevel = $row['level'];
  if ($action == "promote") 
    $nlevel++;
  else if ($action == "demote")
    $nlevel--;
  if ($nlevel != $row['level']) {
    $query = "UPDATE ${i18nHTMLsqlPrefix}accounts SET level=$nlevel WHERE uid=$cid;";
    mysql_query($query, $connection);
    W("Account ${action}d to level $nlevel.");  
  } else {
    W("Specified action '%s' unknown.",
      $action);
  }
 }
BP();
intlink("accounts.php", "Continue account management");
EP();
generateFooter();
echo "</body></html>\n";
?>