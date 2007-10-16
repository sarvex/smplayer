<?php
include_once("l10n.php");
?>
<html>
<head>
<title><?php tr("Another Page"); ?></title>
</head>

<body>

<h1><?php tr("Page 2"); ?></h1>

<?php
echo "<p>";
tr("This is another test page.");

echo "<p>";
tr("<b>SMPlayer</b> intends to be a complete front-end for 
<a href=\"http://www.mplayerhq.hu/\">MPlayer</a>, from basic features like 
playing videos, DVDs, and VCDs to more advanced features like support 
for MPlayer filters and more.");

echo "<center>";
tr("<a href=\"%1\">Go back</a>", "index.php?tr_lang=".$tr_lang);
echo "</center>";
?>

</body>
</html>
