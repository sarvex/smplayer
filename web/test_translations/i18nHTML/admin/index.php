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
include_once("login.php");
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("WWW translation: Administration");
echo "</head><body>";
generateLanguageBar();
BP();
W("This is the %s administrative interface.",
  extlink_("http://gnunet.org/i18nHTML/","i18nHTML"));
EP();
H2("Translation");

echo "<ul>\n";
LILI("editor.php", "Go to mass translation");
if ($level > 0) {
  LILI("dig.php?mode=wwcd&xlang=$lang&f=", 
       "Search for suspicious translations using weighted word-count distance");
  LILI("dig.php?mode=wccd&xlang=$lang&f=", 
       "Search for suspicious translations using weighted character-count distance");
  LILI("dig.php?mode=wlmc&xlang=$lang&f=", 
       "Search for suspicious translations using weighted word-length distance");
  LILI("dig.php?mode=psmc&xlang=$lang&f=", 
       "Search for suspicious translations using percent sign mismatch counts");
  LILI("dig.php?mode=punc&xlang=$lang&f=",
       "Search for suspicious translations using punctuation mismatch counts");
  LILI("dig.php?mode=totc&xlang=$lang&f=",
       "Search for suspicious translations using number of contributed translations");
  LILI("dig.php?mode=alpha&xlang=$lang&f=",
       "Search for suspicious translations using alphabetical ordering");
 }
echo "</ul>\n";

H2("Account management");
echo "<ul>\n";

LILI("logout.php", "Logout");

// allow admins to delete accounts (& all translations)
// of lower-level or to grant administrative priviledges
if ($level > 0)
  LILI("accounts.php", "Manage acconts");

// have a table with legal languages (for signing up)
if ($uid == 1) 
  LILI("languages.php", "Setup languages");

echo "</ul>\n";


H2("Site administration");
echo "<ul>\n";
LILI("status.php", "Display statistics");
if ($uid == 1) {
  LILI("tables.php", "Initialize tables");
  LILI("cleanup.php", "Automatic cleanup (trivial translation errors)");
}
echo "</ul>\n";

generateFooter();
echo "</body></html>";
?>