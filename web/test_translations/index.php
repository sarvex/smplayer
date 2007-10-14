<?php 
include_once("l10n.php"); 
init_translation();
?>
<html>
<head>
<title><?php tr("Test"); ?></title>
</head>

<body>

<h1><?php tr("Test Page"); ?></h1>

<?php
echo "<p>";
tr("Hi. This is a test page.");

echo "<p>";
tr("This is a <a href=\"download/smplayer_0.5.61.tar.gz\">link</a>.");

echo "<p>";
tr("This is another <a href=\"%1\">link</a>.", "download/smplayer_0.5.61.tar.gz");

echo "<p>";
tr("The latest version is %1. You can get it <a href=\"%2\">here</a>.", "0.5.61", "download/smplayer_0.5.61.tar.gz");

echo "<p>";
tr("Testing parameters: %1, %2, %1 again, %3 and finally %4. Let's repeat %4.", "par1", "par2", "par3", "par4");

echo "<p>";
tr("Please, visit <a href=\"%1\">page 2</a>.", "page2.php?lang=".$lang);

echo "<center>";
echo tr("Choose language: <a href=\"%1\">[English]</a> <a href=\"%2\">[Spanish]</a>", "index.php", "index.php?lang=es");
echo "</center>";
?>

</body>
</html>
