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
include("i18nHTML/i18nhtml.php");
include("login.php");
if (!$connection) {
  echo "Database is down. Cannot edit translations.";
  die();
}
if ($lang == $i18nHTMLsrcLang) {
  W("Translating to ${i18nHTMLsrcLang} is not allowed.\n");
  die();
}
if (strstr($lang, "@")) {
  W("Invalid language.\n");
  die();
}
$text            = urldecode($_REQUEST['text']);
$text_sql        = mysql_real_escape_string($text);
$translation     = fix($_REQUEST['translation']);
$translation_sql = mysql_real_escape_string(to_unicode($translation));

$back            = $_REQUEST['back'];
// check for identical translation
$query = "SELECT translation FROM ${i18nHTMLsqlPrefix}map WHERE name=\"$text_sql\" AND lang=\"$lang\"";

$result = mysql_query($query, $connection);
$num = 0;
if ($result)
  $num = mysql_numrows($result);
$exists = 0;
for ($ii=0;$ii<$num;$ii++) {
  $row = mysql_fetch_array($result);
  if ($row["translation"] == $translation_sql)
    $exists = 1;
 }

if ($exists == 1) {
  echo "<html><head>";
  TITLE("Translation exists.");
  echo "</head><body>";
  W("Translation '%s' of sentence '%s' exists.",
    ARRAY(fix($translation), $text));
  extlink($back, "Back...");
  generateFooter();
  echo "</body></html>";
} else {
  $txtCnt = count_chars($text, 1);
  $tCnt   = count_chars($translation, 1);
  if ($txtCnt[ord('%')] != $tCnt[ord('%')]) {
      echo "<html><head>";
      TITLE("Commit failed.");
      echo "</head><body>";
      W("Commit failed ('%s' and '%s').", ARRAY($text, $translation));
      W("The number of percent signs in source text and translation does not match.");
      W("Note that you must preserve all %%s expressions unchanged.");
      W("Also, a single displayed %% sign must be translated into two (%%%%) such signs.");
      generateFooter();
      echo "</body></html>";
  } else {
    $query = "INSERT INTO ${i18nHTMLsqlPrefix}map (name,lang,translation,IP,uid) VALUES(\"$text_sql\", \"$lang\", " .
             "\"$translation_sql\", \"" . $_SERVER['REMOTE_ADDR'] . "\", $uid);";
    $result = mysql_query($query, $connection);
    if ($result) {
      $query = "DELETE FROM ${i18nHTMLsqlPrefix}pending WHERE lang=\"$lang\" AND c=\"$text_sql\"";
      mysql_query($query, $connection);
      header("Location: " . $back); /* Redirect browser */
    } else {
      echo "<html><head>";
      TITLE("Commit failed.");
      echo "</head><body>";
      W("Commit ('%s') failed: ", $query);
      echo mysql_error();
      generateFooter();
      echo "</body></html>";
    }
  }
}
?>
