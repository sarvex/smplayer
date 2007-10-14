<?php
/*
     (C) 2003, 2004, 2005, 2007 Christian Grothoff

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
if (!$connection) {
  echo "Database is down. Cannot edit translations.";
  die();
}
if ($lang == $i18nHTMLsrcLang) {
  W("Translating to ${i18nHTMLsrcLang} currently not allowed.\n");
  die();
}
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("WWW translation: commit");
echo "</head><body>";
BP();
W("Processing translations...");
P();
$start = $_POST["start"];
$skip = 0;
foreach($_POST as $dec=>$val) {
  if ($dec == "start")
    continue;
  if ($val == "") {
    $skip++;
    continue;
  }
  $val = fix($val);
  $query = "SELECT c FROM ${i18nHTMLsqlPrefix}pending WHERE lang=\"$lang\"";
  $result = mysql_query($query, $connection);
  $num = 0;
  if ($result)
    $num = mysql_numrows($result);
  while ($num > 0) {
    $num--;
    $row = mysql_fetch_array($result);
    $cx_plain = fix($row["c"]);
    $cx_sql = mysql_real_escape_string($cx_plain);
    if ($dec == bin2hex(md5($cx_plain))) {
      $enc_sql = $cx_sql;
      break;
    }
  }
  if ($num == 0) {
    W("Did not find &quot;%s&quot; in pending translations, skipping.",
      $dec);
    P();
    $skip++;
    continue;
  }
  $query = "DELETE FROM ${i18nHTMLsqlPrefix}pending WHERE lang=\"$lang\" AND c=\"$enc_sql\"";
  mysql_query($query, $connection);
  $val_sql = mysql_real_escape_string(to_unicode($val));
  $query = "SELECT tid FROM ${i18nHTMLsqlPrefix}map WHERE name=\"$enc_sql\" AND lang=\"$lang\" AND translation=\"$val_sql\"";
  $result = mysql_query($query, $connection);
  $num = 0;
  if ($result)
    $num = mysql_numrows($result);
  if ($num == 0) {
    $txtCnt = count_chars(stripslashes($enc_sql), 1);
    $tCnt = count_chars(stripslashes($val_sql), 1);
    if ($txtCnt[ord('%')] != $tCnt[ord('%')]) {
      W("Commit '%s->%s' failed.", stripslashes($enc_sql), stripslashes($val_sql));
      W("The number of percent signs in source text and translation do not match.");
      W("Note that you must preserve all %%s expressions unchanged.");
      W("Also, a single displayed %% sign must be translated into two (%%%%) such signs.");
      P();
    } else {
      $query = "INSERT INTO ${i18nHTMLsqlPrefix}map (name,lang,translation,IP,uid) VALUES(\"$enc_sql\", \"$lang\", " .
               "\"$val_sql\", \"" . $_SERVER['REMOTE_ADDR'] . "\", $uid);";
      mysql_query($query, $connection);
      W("Storing translation for &quot;%s&quot = &quot;%s&quot;.",
        ARRAY(stripslashes($enc_sql),
	      stripslashes($val_sql)));
      BR();
    }
  }
}
P();
echo "<a href=\"${i18nHTMLbase}editor.php?xlang=${lang}&start=" . ($start + $skip) . "\">";
$t = TRANSLATE("Continue mass-editing...");
echo "</a>";
if ($t == 1)
  translateLink($b);
EP();
generateFooter();
echo "</body></html>";
?>
