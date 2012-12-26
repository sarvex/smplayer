<?php
include_once("header.php");
include_once("download_links.php");
print_header();
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">

<!-- Main hero unit for a primary marketing message or call to action -->
<span class="hidden-phone">
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span2">
			<img src="images/smplayer_logo_big.png">
		</div>
		<div class="span5">
			<h1>SMPlayer</h1>
			<?php
			echo "<p>". get_tr("Free Media Player with Youtube&trade; support") ."<br>\n";
			echo "<p class=\"second\">\n";
			echo "<img src=\"images/check2.png\"> ". get_tr("Plays every format: avi, mp4, mkv, divx, h.264, mpeg, mov...") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Built-in codecs. No codec packs needed") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Plays and downloads Youtube&trade; videos") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Automatically search and download subtitles") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Resumes playback") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Skin support") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Many audio and video filters included") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Simple and intuitive interface") ."<br>";
			echo "</p>";
			echo "<p>". download_windows_full_link(get_tr("Click here to download SMPlayer for free"), true) ."</p>\n";
			?>
		</div>
		<div class="span5">
		<img src="images/twisted2.png">
		</div>
	</div>
</div>
</span>

<div class="row-fluid">
<div class="span8">

<h2><?php tr("Main Features"); ?></h2>
<p>
<?php
tr("SMPlayer is a free open source media player, with built-in codecs, that
can play virtually all video and audio formats. It doesn't need any external codecs.");
echo " ";
tr("SMPlayer can also play, search and download Youtube&trade; videos.");
echo " ";
tr("It uses
the award-winning %1 as playback engine which is capable of
playing almost all known video and audio formats.", "MPlayer");
echo "<p>";
include("features.php");

echo download_windows_full_link("<img src=\"images/arrow-down.png\"> ". get_tr("Download SMPlayer for free"), true);
?>

</div> <!-- span -->

<div class="span4">
<div class="well">
<h3><?php tr("Supported formats:"); ?></h3>
<p>
(S)VCD, DVD, MPEG-1/2, AVI, ASF/WMV/WMA, QT/MOV/MP4, RealAudio/RealVideo,
Ogg/OGM, Matroska, NUT, NSV, VIVO, FLI, NuppelVideo, yuv4mpeg, FILM (.cpk),
RoQ, PVA, streaming via HTTP/FTP, RTP/RTSP, MMS/MMST, MPST, SDP.
<hr>

<h3><?php tr("Video codecs:"); ?></h3>
<p>
MPEG-1 (VCD), MPEG-2 (SVCD/DVD/DVB), MPEG-4 ASP, DivX, OpenDivX, DivX 5, Xvid,
H.264, Windows Media Video 7/8 (WMV1/2), Windows Media Video 9 (WMV3),
RealVideo 1.0, 2.0, RealVideo 3.0 (RP8), 4.0 (RP9),
Sorenson v1/v3 (SVQ1/SVQ3), Cinepak, RPZA, QuickTime,
DV, 3ivx, Intel Indeo3 (3.1, 3.2), 
Intel Indeo 4.1 and 5.0, VIVO 1.0, 2.0, I263, H.263, 
MJPEG, AVID, VCR2, ASV2, FLI/FLC, HuffYUV.
<hr>

<h3><?php tr("Audio codecs:"); ?></h3>
<p>
MPEG layer 1, 2, and 3 (MP3), 
AC3/A52, E-AC3, DTS, AAC, WMA, WMA 9, 
RealAudio, QuickTime, Ogg Vorbis, VIVO, 
alaw/ulaw, (ms)gsm, pcm, *adpcm.
</div> <!-- well -->
</div> <!-- span -->

</div> <!-- row -->

<?php 
include_once("scripts.php");
include("gallery.php");

function show_thumb($filename, $desc) {
	echo "<li class=\"span3\">\n";
	echo "<a title=\"$desc\" rel=\"gallery\" href=\"images/screenshots/$filename\" class=\"thumbnail\">\n";
	echo "<img src=\"images/screenshots/thumbs/th_$filename\" alt=\"\">\n";
	echo "</a>\n";
//	echo "<div class=\"caption\">$desc</div>\n";
	echo "</li>\n";
}
?>

<div class="row-fluid">
<div class="span12">

<h3><?php tr("Screenshots"); ?></h3>
<p>
<?php
echo "<div id=\"gallery\" data-toggle=\"modal-gallery\" data-target=\"#modal-gallery\">\n";
echo "<div class=\"span12\">";
echo "<ul class=\"thumbnails\">\n";
show_thumb("prom_skin_mac.png", get_tr("Main Window") );
show_thumb("prom_pref3.png", get_tr("The Preferences Dialog") );
show_thumb("prom_smtube.png", get_tr("The YouTube Browser") );
show_thumb("prom_subtitles.png", get_tr("Find Subtitles") );
echo "</ul>";
echo "</div>";
echo "</div> <!-- gallery -->";
?>

<p>
<?php
include("media_reviews.php");
print_media_reviews(false);
echo "<p><a href=\"reviews.php?tr_lang=$tr_lang\" class=\"btn btn-success btn-large\">".
get_tr("Click here to read more reviews") . "</a></p>\n";
?>

</div>
</div>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
