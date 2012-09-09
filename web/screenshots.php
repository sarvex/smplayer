<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title><?php tr("SMPlayer - Screenshots"); ?></title>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">
<link href="base.css" rel="stylesheet" title="base style" type="text/css">
<link rel="icon" type="image/png" href="images/icons/smplayer_icon16.png">
<?php include_once("analytics.php"); ?>
</head>
<body>

<div id="sm_container">

<!-- header -->
<?php
include("header.php");
print_header();
?>
<!-- end header -->

<!-- begin content -->

<div id="sm_content">
<?php 
function show_thumb($filename, $desc) {
	echo "<td align=\"center\">\n";
	echo "<a href=\"images/screenshots/$filename\">\n";
	echo "<img src=\"images/screenshots/thumbs/th_$filename\">\n";
	echo "</a>\n";
	echo "<br>\n";
	echo $desc;
	echo "</td>\n";
}

tr("Here you can see some screenshots from SMPlayer:"); 

echo "<center>";
echo "<table>";
echo "<tr>";

show_thumb("mainwindow.png", get_tr("This is the main window") );

show_thumb("mainwindow_vista.png",
	get_tr("The Windows version") );

show_thumb("preferences2.png", get_tr("The preferences dialog") );

echo "</tr>";
echo "<tr>";

//show_thumb("vista4.png", get_tr("SMPlayer running on Windows Vista") );
show_thumb("youtube1.png", get_tr("The YouTube browser") );
show_thumb("video_preview.png", get_tr("Video preview") );
show_thumb("subtitles2.jpg", get_tr("Matroska embedded subtitles") );

echo "</tr>";
echo "<tr>";

show_thumb("languages2.png", get_tr("More than 30 translations available") );
show_thumb("mini_gui2.png", get_tr("The mini GUI") );
show_thumb("find_subtitles.png", get_tr("Possibility to search for subtitles") );

echo "</tr>";

echo "</table>";
echo "</center>";
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
