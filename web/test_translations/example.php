<?php
include_once("i18nHTML/i18nhtml.php");
DOCTYPE("HTML");
echo "<html><head>";
TITLE("Example page");
echo "</head><body>";
H1("Some document title");
W("A sentence to translate.");
W("A sentence with an argument '%s' that cannot be translated.",
  "foo");
W("A sentence with two arguments '%s' and '%s' that cannot be translated.",
  ARRAY("foo", "bar"));
P(); // <p>
W("A sentence with a %s that CAN be translated.",
  extlink_("http://gnunet.org/i18nHTML/", "link text"));
W("A %s to another translatable page.",
  intlink_("http://gnunet.org/i18nHTML/index.php", "link")); 
BR(); // <br>
echo W_("A function returning the translation.");
W("For more functions, look into i18nhtml.inc.");

HR();
W("And finally put the language selection bar somewhere:");
generateLanguageBar(); // allow user to select other languages
P();
W("Oh, and put the footer to allow the editor mode:");
generateFooter();
echo "</body></html>";
?>