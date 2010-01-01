<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title><?php tr("SMPlayer - Screenshots"); ?></title>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">
<link href="base.css" rel="stylesheet" title="base style" type="text/css">
<link rel="icon" type="image/png" href="images/icons/smplayer_icon16.png">
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

show_thumb("mainwindow_xp.png", get_tr("This is the main window") );

show_thumb("playlist_embedded3.jpg", 
	get_tr("The playlist can be embedded in the main window") );

show_thumb("preferences1.png", get_tr("The preferences dialog") );

echo "</tr>";
echo "<tr>";

//show_thumb("vista4.png", get_tr("SMPlayer running on Windows Vista") );
show_thumb("smplayer_gnome.jpg", get_tr("SMPlayer running on Gnome") );
show_thumb("subtitles1.jpg", get_tr("A video displaying a srt subtitle") );
show_thumb("subtitles2.jpg", get_tr("Matroska embedded subtitles") );

echo "</tr>";
echo "<tr>";

show_thumb("languages.png", get_tr("SMPlayer is translated into more than 20 languages") );
show_thumb("mini_gui.png", get_tr("The mini GUI") );
show_thumb("kde4-3.jpg", get_tr("SMPlayer running on the new KDE 4") );

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
