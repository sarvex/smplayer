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
TITLE("i18nHTML language addition");
echo "</head><body>";
if ($uid != 1) {
  W("Only the administrator can add new languages.");
  die();
 }
session_start();
if (! isset($_POST['newlang'])) {
  W("No language specified!");
  die();
 }
$newlang = mysql_real_escape_string($_POST['newlang']);

$query = "SELECT lang FROM ${i18nHTMLsqlPrefix}languages WHERE lang=\"$newlang\";";
$result = mysql_query($query, $connection);     
$num = 0;
if ($result)
  $num = mysql_numrows($result);
if ($num != 0) {
  W("This language already exists.");
  die();
 }
$doesdef = $_POST['def'];
if ($doesdef != "1")
  $doesdef = "0";
$query = "INSERT INTO ${i18nHTMLsqlPrefix}languages VALUES (\"$newlang\", $doesdef)";
mysql_query($query, $connection);     

W("Language %s added.",
  $newlang);
BP();
intlink("languages.php", "Add another language");
EP();
generateFooter();
echo "</body></html>\n";
?>