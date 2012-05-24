<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title><?php tr("SMPlayer - Donate"); ?></title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta name="Description" content="smplayer, multiplatform front-end for mplayer">
<meta name="Keywords" content="smplayer, mplayer, multimedia, player">
<link href="base.css" rel="stylesheet" title="base style" type="text/css">
<link rel="icon" type="image/png" href="images/icons/smplayer_icon16.png">
</head>
<body>

<div id="sm_container">

<!- header -->
<?php
include("header.php");
print_header();
?>
<!-- end header -->

<!-- begin content -->

<div id="sm_content">
<?php
echo "<p>\n";
tr("If you like SMPlayer, a really good way to support it is by sending a donation, even the smallest one is highly appreciated.");
echo "<p>\n";
tr("Click on the following button to send a donation:");
//echo "<center>\n";
include "donate_button.php";
//echo "</center>\n";
?>
</div>

<!-- end content -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->
</div>

</body>
</html>
