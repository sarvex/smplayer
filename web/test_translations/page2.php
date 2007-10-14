<?php
include_once("l10n.php");
init_translation();
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
tr("<a href=\"%1\">Go back</a>", "index.php?lang=".$lang);
?>

</body>
</html>
