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
include("i18nHTML/i18nhtml.php");
// ensure the mapping and pending tables exist, creating them if not
$query="CREATE TABLE IF NOT EXISTS ${i18nHTMLsqlPrefix}map" .
       " (name BLOB, lang TINYBLOB, translation BLOB, ip TINYTEXT, uid INT, tid BIGINT NOT NULL AUTO_INCREMENT, " .
       "INDEX(name(10)), INDEX(lang(4)), INDEX(translation(10)), PRIMARY KEY(tid))";
$result = mysql_query($query, $connection);
if (!$result) {
  die('Unable to initialize map table.  Invalid query: ' . mysql_error());
}

$query="CREATE TABLE IF NOT EXISTS ${i18nHTMLsqlPrefix}pending" .
       " (c BLOB, lang TINYBLOB, count INT, " .
       "INDEX(c(10)), INDEX(lang(4)), INDEX(count))";
$result = mysql_query($query, $connection);
if (!$result) {
  die('Unable to initialize pending table.  Invalid query: ' . mysql_error());
}

$query="CREATE TABLE IF NOT EXISTS ${i18nHTMLsqlPrefix}accounts" .
       " (username TINYBLOB, password BLOB, realname BLOB, allowed BLOB, level INT, uid BIGINT NOT NULL AUTO_INCREMENT, " .
       "INDEX(username(10)), PRIMARY KEY(uid))";
$result = mysql_query($query, $connection);
if (!$result) {
  die('Unable to initialize accounts table.  Invalid query: ' . mysql_error());
}

// setup root account
$query="INSERT INTO ${i18nHTMLsqlPrefix}accounts VALUES (\"root\", \"" . mysql_real_escape_string(crypt($i18nHTMLsqlAdminPass, "salty")) . "\", \"Administrator\", \"$i18nHTMLsrcLang\", 9999, 1)";
       "INDEX(c(10)), INDEX(lang(4)), INDEX(count))";
mysql_query($query, $connection);

// setup legacy account
$query="INSERT INTO ${i18nHTMLsqlPrefix}accounts VALUES (\"legacy\", \"nologin\", \"Legacy\", \"$i18nHTMLsrcLang\", 0, 2)";
       "INDEX(c(10)), INDEX(lang(4)), INDEX(count))";
mysql_query($query, $connection);


$query="CREATE TABLE IF NOT EXISTS ${i18nHTMLsqlPrefix}languages" .
  " (lang VARCHAR(64) PRIMARY KEY, dodef INT, INDEX(lang(10)))";
$result = mysql_query($query, $connection);
if (!$result) {
  die('Unable to initialize languages table.  Invalid query: ' . mysql_error());
}

// add existing languages to language table
$query="SELECT DISTINCT lang FROM ${i18nHTMLsqlPrefix}map;";
$result = mysql_query($query, $connection);
$num = 0;
if ($result)
  $num = mysql_numrows($result);
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  $lx = $row['lang'];
  $query="INSERT INTO ${i18nHTMLsqlPrefix}languages VALUES (\"$lx\", 0)";
  mysql_query($query, $connection);
 }

W("Tables created.");
generateFooter();
echo "</body></html>";
?>