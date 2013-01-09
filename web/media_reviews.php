<?php include_once("reviews_func.php");

function print_media_reviews($one_column=false) {
	if ($one_column) $span = 12; else $span = 3;

	echo "<div class=\"row-fluid\">\n";
	print_quote("SMPlayer - a Fantastic Multimedia Player for Windows and Linux",
				"http://voices.yahoo.com/smplayer-fanastic-multimedia-player-windows-1972216.html",
				"Eric Fleming",
				"voices.yahoo.com", $span);

	if ($one_column) echo "</div>\n<div class=\"row-fluid\">\n";

	print_quote("SMPlayer: Heavy concentration of brilliant features for media playback",
				"http://www.filecluster.com/reviews/092011/smplayer-heavy-concentration-of-brilliant-features-for-media-playback/",
				"Lizzy Nolan",
				"filecluster.com", $span);

	if ($one_column) echo "</div>\n<div class=\"row-fluid\">\n";

	print_quote("The Best Video Player for Linux",
				"http://lifehacker.com/5866656/the-best-video-player-for-linux",
				"Whitson Gordon",
				"lifehacker.com", $span);

	if (0) {
	if ($one_column) echo "</div>\n<div class=\"row-fluid\">\n";

	print_quote("SMPlayer – Probably the best media player in the world!",
				"http://reinep.wordpress.com/2010/12/07/probably-the-best-media-player-in-the-world/",
				"Ray",
				"reinep.wordpress.com", $span);
	}

	echo "</div>\n";
}
?>

