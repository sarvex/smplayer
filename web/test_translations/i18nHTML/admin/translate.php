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
include("i18nHTML/i18nhtml.php");
include("login.php");
if (!$connection) {
  echo "Database is down. Cannot edit translations.";
  die();
}
$text     = fix($_REQUEST['text']);
$text_sql = quote_smart($text);
$text_url = urlencode($text);
$back = $_REQUEST['back'];
DOCTYPE("HTML", "Transitional");
echo "<html><head>\n";
TITLE("WWW translation");
echo "<meta name=\"description\" content=\"";
TRANSLATE("Help translating this webpage.");
echo "\">";
echo "</head><body>";
if ($lang == $i18nHTMLsrcLang) {
  echo "Cannot translate to ${i18nHTMLsrcLang}.";
  generateFooter();
  echo "</body></html>";
  die();
 }
H2("Original Text");
echo htmlentities($text);
H2("Translation");
W("Destination language: ");
W($lang);
P();
echo "<form method=\"POST\" action=\"${i18nHTMLbase}commitTranslation.php\">\n";
echo "<input type=hidden name=\"text\" value=\"$text_url\">\n";
echo "<input type=hidden name=\"xlang\" value=\"$xlang\">\n";
echo "<input type=hidden name=\"back\" value=\"$back\">\n";
W("Translated text:");
echo "<input size=\"80%\" maxlength=\"65535\" name=\"translation\">\n";
echo "<input type=submit value=\"" .
     TRANSLATE_("I hereby give this translation into the Public Domain (commit)") .
     "\">\n";
echo "</form>\n";
P();

H2("All available translations");
echo "<table border=5 width=95%>\n";
echo "<tr><th>" . W_("Language") . "</th><th>" . W_("Translation") . "</th></tr>\n";
$query = "SELECT translation,lang FROM ${i18nHTMLsqlPrefix}map WHERE name=\"$text_sql\"";
$result = mysql_query($query, $connection);
$num = 0;
if ($result)
  $num = mysql_num_rows($result);
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  $translation = $row["translation"];
  printf("<tr><td>%s</td><td>%s</td></tr>\n",
         W_($row["lang"]),
         fix($translation));
}
echo "</table>";
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
W("If you are trying to translate the page to such a language, please contact the developers if you encounter any problems.");
P();
H3("Copyright");
W("The original english text is released under the GNU Free Documentation License (FDL).");
W("Translations submitted to the webpage must be released to the public domain to ensure that we will not have any legal trouble.");
W("If you have concerns or remarks regarding this policy, feel free to bring them to our attention.");
generateFooter();
echo "</body></html>";
?>
