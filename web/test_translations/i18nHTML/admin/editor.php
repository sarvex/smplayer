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
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("WWW translation");
echo "</head><body>";
generateLanguageBar();
if ( (! $lang) || ($lang == $i18nHTMLsrcLang) ) {
  echo "Cannot translate to " . $i18nHTMLsrcLang . ".";
  die();
 }
$start = $_REQUEST['start'];
if (! $start)
  $start = 0;
H2("Mass translation to %s", $lang);
W("This page is for translating lots of sentences at once.");
W("The sentences are ordered by the frequency that they are requested by users.");
$max = 10; /* apache limits! */
$end = $start + $max;
W("The page lists the top %s requested, untranslated sentences in the selected language.",
  $max);
W("Do not copy the quotes (&quot;) from the original messages into the translations.");
W("Leave translations that you cannot do blank.");

$query = "SELECT c FROM ${i18nHTMLsqlPrefix}pending WHERE lang=\"$lang\" ORDER BY count DESC";
$result = mysql_query($query, $connection);
$num = 0;
if ($result)
  $num = mysql_numrows($result);
if ($end > $num) 
  $end = $num;

if ($num == 0) {
  P();
  W("No missing translations for the selected target language were found.");
} else {
  P();
  W("%s translations to %s have been requested and were not available.",
    ARRAY($num,
	  W_($lang)));
  W("Displaying entries %s to %s (ordered by request frequency).",
    ARRAY($start, $end));
  P();

  echo "<form method=\"POST\" action=\"${i18nHTMLbase}commitMassTranslation.php?xlang=${lang}\">";
  echo "<input type=hidden name=\"start\" value=\"$start\">";

  echo "<table border=5>";
  echo "<tr>";
  TH("Original");
  TH("Translation");
  echo "</tr>";
  for ($ii=0;$ii<$end;$ii++) {
    $row = mysql_fetch_array($result);
    if ($ii < $start)
      continue;
    $cx_plain = fix($row["c"]);
    $cx_sql = mysql_real_escape_string($cx_plain);

    $query = "SELECT tid FROM ${i18nHTMLsqlPrefix}map WHERE name=\"$cx_sql\" AND lang=\"$lang\"";
    $result2 = mysql_query($query, $connection);
    $num2 = 0;
    if ($result2)
      $num2 = mysql_numrows($result2);
    echo "<tr><td width=\"45%\">";
    echo "&quot;" . htmlentities($cx_plain) . "&quot;";
    echo "</td>\n\t<td width=\"50%\">";
    if ($num2 > 0) {
      $query = "DELETE FROM ${i18nHTMLsqlPrefix}pending WHERE lang=\"$lang\" AND c=\"$cx_sql\"";
      mysql_query($query, $connection);
      W("Skipped (already translated).");
    } else {
      echo "<input size=\"49%\" maxlength=\"65535\" name=\"" . bin2hex(md5($cx_plain)) . "\"></td></tr>\n";
    }
  }
  echo "</tr></table>";
  echo "<input type=submit value=\"" .
       TRANSLATE_("I hereby give all these translations into the Public Domain (commit)") .
       "\">";
  echo "</form>";
}
if ($end < $num) {
  P();
  echo "<a href=\"${i18nHTMLbase}editor.php?xlang=${lang}&start=${end}\">";
  $t = TRANSLATE("Skip these sentences, continue with next set.");
  echo "</a>";
  if ($t == 1)
    translateLink($b);
} else {
  W("Statistics about translation progress can be found %s.\n",
    intlink_("${i18nHTMLbase}status.php", "here"));
}
P();
H2("Remarks");
H3("The percent sign");
W("The %% sign is a special character.");
W("You must use %%%% in the text to print a single percent sign.");
W("The sequence %%s is used as a placeholder for links.");
W("Currently, the translation can only access the links in the same order as the original text.");
P();

H3("Language specific special characters");
W("Various languages use special characters.");
W("The code has not been tested with certain character sets, such as Chinese.");
W("If you are trying to translate the page to such a language, please contact the developerws if you encounter any problems.");
P();

H3("Copyright");
W("The original english text is released under the GNU Free Documentation License (FDL).");
W("Translations submitted to the webpage must be released to the public domain to ensure that we will not have any legal trouble.");
W("If you have concerns or remarks regarding this policy, feel free to bring them to our attention.");

HR();
generateFooter();
echo "</body></html>\n";
?>
