<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title><?php tr("SMPlayer - Latest Version"); ?></title>
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
$release_notes_file = "translations/release_notes_". $tr_lang .".html";
if (file_exists($release_notes_file)) {
	include($release_notes_file);
} else {
	include("translations/release_notes_en.html");
}
echo "<p>";
echo "<a href=\"downloads.php?tr_lang=$tr_lang\">". 
     get_tr("Go to the download page") ."</a>";
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
