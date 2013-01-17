<?php
function add_quote($text, $link, $author, $source, $active=false) {
	if ($active) echo "<div class=\"active item\">\n"; else echo "<div class=\"item\">\n";
	echo "<blockquote>\n";
	//echo '<i class="icon-quote-left icon-2x pull-left icon-muted"></i>';
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

	echo "<br><br>";
	//echo "&mdash; ";
	echo "<small>$author - <cite>";
	if ($link != "") echo "<a href=\"$link\">$source</a>"; else echo "$source";
	echo "</cite></small>\n";
	echo "</blockquote>\n";
	echo "</div> <!-- item -->\n";
}

function enable_carousel($interval=4000){
	echo "<script>$('.carousel').carousel({ interval: $interval })</script>\n";
}
?>

<div id="myCarousel" class="carousel slide">
	<!-- Carousel items -->
	<div class="carousel-inner">
	<?php

	add_quote("SMPlayer - a Fantastic Multimedia Player for Windows and Linux",
				"http://voices.yahoo.com/smplayer-fanastic-multimedia-player-windows-1972216.html",
				"Eric Fleming", "voices.yahoo.com", true);
	add_quote("SMPlayer: Heavy concentration of brilliant features for media playback",
				"http://www.filecluster.com/reviews/092011/smplayer-heavy-concentration-of-brilliant-features-for-media-playback/",
				"Lizzy Nolan", "filecluster.com");
	add_quote("The Best Video Player for Linux",
				"http://lifehacker.com/5866656/the-best-video-player-for-linux",
				"Whitson Gordon", "lifehacker.com");
	add_quote("SMPlayer – Probably the best media player in the world!",
				"http://reinep.wordpress.com/2010/12/07/probably-the-best-media-player-in-the-world/",
				"Ray", "reinep.wordpress.com");

	add_quote("SMPlayer is the universal media player solution for Windows and Linux.<br><br> ".
				"While many applications strive to meet the needs of a universal audience; ".
				"to be a platform independent software solution, SMPlayer rather ".
				"defines the very notion of cross-platform software.<br><br> ".
				"The GUI is exceptionally maintained-- familiar user controls are ".
				"further supported by several, realistic icon themes-- whether launched ".
				"in Win or Lin. The user-friendly front-end only complements what's under ".
				"the hood: the ultimate performance and reliability of mplayer makes ".
				"SMPlayer a truly versatile choice for all multi-media enjoyment.", "",
				"MojoRyssen", "sf");

	add_quote("Best Player ever used.<br><br> Hi, Recently i have started using SMPlayer ".
				"and looking out the features and they way it load quickly for playing ".
				"videos doesn't need any Codecs/patches for playing it, Hats off to the ".
				"Developers...<br><br> Excellent Product for Free of Cost.", "",
				"Alberto Jack", "softonic");

	add_quote("It's really worth to download and start using SMPlayer. ".
				"It's very intuitive and easy to use. After starting use this ".
				"apps in a Linux (Ubuntu 12.04) environment I no more have messages ".
				"about missing codecs...<br><br> I saw in a great quality of image and sound ".
				"all format videos. And if we want to have subtitles we just asked ".
				"in the menu to find it online and it’s easy and fast to get ".
				"(only a few seconds, depending on the web connection) and starts ".
				"immediately synchronized with the movie/video. AMAZING!!!<br><br> ".
				"Today, I start using it on Windows and I highly recommend it to ".
				"all people, like me, are beginners! Enjoy!", "",
				"celeste.duque.7", "softonic");

	add_quote("SMPlayer is the one that just plays everything on my PC, ".
				"including the oldest legacy formats and the newest codecs.<br><br> ".
				"It's easy to use, has a nice GUI, it just works, and has many ".
				"options and settings to configure, though not too many. ;)<br><br> ".
				"I prefer it to VLC, which is of course very good too, ".
				"but which has many expert settings that I don't understand, ".
				"and which is buggy in version 2.0.0.<br><br> Keep up the excellent work!", "",
				"malungu", "sf");

	add_quote("In my opinion by miles the best Videoplayer available to those using linux.<br><br> ".
				"By using MPlayer as the backend you don't have to mess around with additional codecs ".
				"and what not and you can enjoy full hardware acceleration if you have a NVIDIA videocard.<br><br> ".
				"SMPlayer makes all the powerful options MPlayer offers actually usuable and ".
				"is one of few programs that allows you to do something useful with the mouse thumb buttons.<br><br> ".
				"The preferred audio/subtitles function made me use it under windows as well ".
				"instead of WMC, as its lack for it greatly annoyed me.<br><br> ".
				"Big thanks to its developer(s?)!", "",
				"Axeia", "sf");

	add_quote("This is THE best player for linux. Do not waste your time with VLC, ".
				"SMPlayer is faster, has many more little interesting options if you poke it ".
				"and is reliable for anything you will ever need to play.<br><br> ".
				"It NEVER crashes. It NEVER says 'can't play this blah blah blah'.<br><br> ".
				"Simply amazing. Many thanks to the developers. ", "",
				"Tukos", "usc");

	add_quote("Move over VLC, there's a new kid in town. I was a big supporter of VLC since it had ".
				"so many more features than Windows Media Player. However there have been several ".
				"bugs in it recently that made me (and many others) look for something else.<br><br> ".
				"SMPlayer not only fit the bill, it surpassed VLC in every way. It can sync ".
				"audio - a vital feature of VLC. It loads and plays faster. It can instantly ".
				"play in full screen, which many media players including VLC have problems with in Win 7.<br><br> ".
				"I do recommend choosing to custom install and checking off the additional codecs ".
				"- can never have enough of those. And I personally turned off several logs and ".
				"playlists to save drive space - but you may want the custom ini files that can save ".
				"playback settings per video - another powerful feature if needed!<br><br> It works better than ".
				"any other video player I've tried, I prefer the interface and find it's controls ".
				"and menus very easy to use, it is faster, and so far it plays everything with ".
				"ease.<br><br> What more could you want?", "",
				"Klatuu", "snapfiles");

	add_quote("I love it. It's faster than VLC and MPC (HD videos are not choppy).", "",
				"Andreyyshore", "sf");

	add_quote("SMPlayer is such a great player, if I could award it ten stars, I would.", "",
				"Artoo-Detoo", "softpedia");

	?>
	</div>
<!-- Carousel nav -->
<?php
/*
<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
*/
?>
<div class="pull-right">
<a href="#myCarousel" data-slide="prev"><i class="icon-chevron-left"></i></a>
<a href="#myCarousel" data-slide="next"><i class="icon-chevron-right"></i></a>
</div>
</div> <!-- carousel -->
