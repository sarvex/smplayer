<?php
include_once("header.php");
print_header(get_tr("Screenshots"), get_tr("Screenshots of SMPlayer"));
echo "<body>\n";
print_menu(2);
?>

<div class="container-fluid">

<?php 
include("gallery.php");

echo "<h1>". get_tr("Screenshots") ."</h1>";

function show_thumb($filename, $desc) {
	echo "<li class=\"span3\">\n";
	echo "<a title=\"$desc\" rel=\"gallery\" href=\"images/screenshots/$filename\" class=\"thumbnail\">\n";
	echo "<img src=\"images/screenshots/thumbs/th_$filename\" alt=\"\">\n";
	//echo "<img src=\"images/screenshots/$filename\" alt=\"\">\n";
	echo "</a>\n";
	echo "<div class=\"caption\">$desc</div>\n";
	echo "</li>\n";
}

function show_video($link, $desc) {
	echo "<li class=\"span4\">\n";
	echo $link;
	echo "<div class=\"caption\">$desc</div>\n";
	echo "</li>\n";
}

echo "<p>";
tr("Here you can see some screenshots from SMPlayer:");
echo "\n";

echo "<div id=\"gallery\" data-toggle=\"modal-gallery\" data-target=\"#modal-gallery\">\n";

echo "<div class=\"row\">\n";
echo "<div class=\"span12\">\n";
echo "<ul class=\"thumbnails\">\n";
show_thumb("mainwindow.png", get_tr("This is the main window") );
show_thumb("mainwindow_vista.png", get_tr("The Windows version") );
show_thumb("preferences2.png", get_tr("The preferences dialog") );
show_thumb("smtube.png", get_tr("The YouTube browser") );
echo "</ul>";
echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"span12\">\n";
echo "<ul class=\"thumbnails\">";
show_thumb("video_preview.png", get_tr("Video preview") );
show_thumb("subtitles2.jpg", get_tr("Matroska embedded subtitles") );
show_thumb("languages2.png", get_tr("More than 30 translations available") );
show_thumb("mini_gui2.png", get_tr("The mini GUI") );
echo "</ul>";
echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"span12\">\n";
echo "<ul class=\"thumbnails\">";
show_thumb("find_subtitles.png", get_tr("Possibility to search for subtitles") );
show_thumb("smplayer_skin_vista.png", get_tr("The skin Vista") );
show_thumb("smplayer_skin_mac.png", get_tr("The skin Mac") );
show_thumb("smplayer_skin_modern.png", get_tr("The skin Modern") );
echo "</ul>";
echo "</div>";
echo "</div>";

echo "</div> <!-- gallery -->\n";
?>

<?php echo "<h1>". get_tr("Videos") ."</h1>"; ?>
<div class="row">
<div class="span12">
<ul class="thumbnails">
<?php 
show_video('<iframe width="384" height="288" src="http://www.youtube.com/embed/xAcvBXrhjpk" frameborder="0" allowfullscreen></iframe>',
		   get_tr("Skin support"));
show_video('<iframe width="384" height="288" src="http://www.youtube.com/embed/9CZNk8XRPCM" frameborder="0" allowfullscreen></iframe>',
		   get_tr("Youtube browser"));
show_video('<iframe width="384" height="288" src="http://www.youtube.com/embed/F5OcZBVPwOA" frameborder="0" allowfullscreen></iframe>',
		   get_tr("Toolbar editor"));
?>
</ul>
</div>
</div>

</div> <!-- container ->

<!-- begin footer -->
<?php
include("footer.php");
include_once("scripts_gal.php"); 
?>
<!-- end footer -->

</body>
</html>
