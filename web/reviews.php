<?php
function print_quote($text, $link, $source) {
	echo "<div class=\"span4\">\n";
	echo "<div class=\"well\">\n";
	echo "<blockquote>\n";
	echo "<p>\n";
	echo "<a target=\"_blank\" href=\"$link\">";
	echo "&laquo;";
	echo $text;
	echo "&raquo;";
	echo "</a>\n";
	echo "<small class \"pull-right\">$source</small>\n";
	echo "</blockquote>\n";
	echo "</div>\n";
	echo "</div>\n";
}
?>

<h3><?php tr("Media Reviews"); ?></h3>

<div class="row-fluid">

	<?php 
	print_quote("SMPlayer - a Fantastic Multimedia Player for Windows and Linux",
				"http://voices.yahoo.com/smplayer-fanastic-multimedia-player-windows-1972216.html",
				"voices.yahoo.com");

	print_quote("SMPlayer: Heavy concentration of brilliant features for media playback",
				"http://www.filecluster.com/reviews/092011/smplayer-heavy-concentration-of-brilliant-features-for-media-playback/",
				"filecluster.com");

	print_quote("The Best Video Player for Linux",
				"http://lifehacker.com/5866656/the-best-video-player-for-linux",
				"lifehacker.com");
	?>

</div>

