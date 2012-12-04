<?php
function print_quote($text, $link, $author, $source, $span=4) {
	echo "<div class=\"span". $span ."\">\n";
	echo "<div class=\"well\">\n";
	echo "<blockquote>\n";
	//echo "<p>\n";
	if ($link != "") {
		echo "<a target=\"_blank\" href=\"$link\">";
	}
	echo "&laquo;";
	echo "<i>$text</i>";
	echo "&raquo;";
	if ($link != "") {
		echo "</a>\n";
	}

	$link = "";
	if ($source == "usc") $source = "Ubuntu Software Center";
	else
	if ($source == "sf") { $source = "Sourceforge"; $link = "http://sourceforge.net/projects/smplayer/"; }
	else
	if ($source == "softpedia") { $source = "Softpedia"; $link = "http://www.softpedia.com/get/Multimedia/Video/Video-Players/SMPlayer.shtml"; }
	else
	if ($source == "softonic") { $source = "Softonic"; $link = "http://smplayer.en.softonic.com"; }
	else
	if ($source == "snapfiles") { $source = "Snapfiles"; $link = "http://www.snapfiles.com/get/smplayer.html"; }

	echo "<small>$author - <cite>";
	if ($link != "") echo "<a href=\"$link\">$source</a>"; else echo "$source";
	echo "</cite></small>\n";
	echo "</blockquote>\n";
	echo "</div>\n";
	echo "</div>\n";
}
?>
