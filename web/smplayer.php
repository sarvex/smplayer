<?php
include_once("header.php");
include_once("download_links.php");
print_header(get_tr("SMPlayer - Opensource Media Player"));
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">

<!-- Main hero unit for a primary marketing message or call to action -->
<span class="hidden-phone">
<div class="hero-unit">
	<div class="row">
		<div class="span2">
			<img src="images/smplayer_logo_big.png">
		</div>
		<div class="span6">
			<h1>SMPlayer</h1>
			<?php
			echo "<p>". get_tr("Free Opensource Media Player") ."<br>\n";
			echo "<p>\n";
			echo "<img src=\"images/check.png\"> Plays every format: avi, mp4, mkv, divx, h.264, mpeg, mov...<br>";
			echo "<img src=\"images/check.png\"> Built-in codecs<br>";
			echo "<img src=\"images/check.png\"> Plays and download Youtube&trade; videos<br>";
			echo "<img src=\"images/check.png\"> Automatically search and download subtitles<br>";
			echo "<img src=\"images/check.png\"> Resumes playback<br>";
			echo "<img src=\"images/check.png\"> Skin support<br>";
			echo "<img src=\"images/check.png\"> Many audio and video filters included<br>";
			echo "<img src=\"images/check.png\"> Simple and intuitive interface<br>";
			echo "</p>";
			echo "<p>". download_windows_full_link(get_tr("Click here to download SMPlayer for Windows"), true) ."</p>\n";
			?>
		</div>
		<div class="span3">
		<img src="images/twisted.png">
		</div>
	</div>
</div>
</span>

<div class="row-fluid">
<div class="span8">

<h1>Main Features</h1>
<p>
<?php
tr("SMPlayer is a complete media player. It uses
the award-winning %1 as playback engine which is capable of
playing most video and audio formats.
It <b>uses its own codecs</b>, so you don't need to install any codec packs.", 
"MPlayer");
echo "<p>";
tr("One of the most interesting features of SMPlayer: <b>it remembers the 
settings of all files you play</b>. So you start to watch a movie but you 
have to leave... don't worry, when you open that movie again it will 
resume at the same point you left it, and with the same settings: audio 
track, subtitles, volume..."); 
?>

<h4><?php tr("Other interesting features:"); ?></h4>
<ul>
<li><?php
tr("A Youtube browser is included, which allows to easily download Youtube videos."); ?></li>
<li><?php tr("Complete preferences dialog, where you can change the key shortcuts,
colors and fonts of the subtitles, and many more."); ?></li>
<li><?php tr("Support for skins and icon themes."); ?></li>
<li><?php tr("Possibility to search and download subtitles from %1.", 
"<a href=\"http://www.opensubtitles.org\">opensubtitles.org</a>"); ?></li>
<li><?php tr("Filters. Many video and audio filters are available: deinterlace, 
postprocessing, denoise... and even a karaoke filter (voice removal)."); ?></li>
<li><?php tr("Seeking by mouse wheel. You can use your mouse wheel to go forward 
or backward in the video."); echo " "; tr("The mouse buttons can also be customized."); ?></li>
<li><?php tr("Video equalizer, allows you to adjust the brightness, contrast, hue,
saturation and gamma of the video image."); ?></li>
<li><?php tr("Multiple speed playback. You can play at 2X, 4X... and even in 
slow motion."); ?></li>
<li><?php tr("Audio and subtitles delay adjustment. Allows you to sync audio and
subtitles."); ?></li> 
<li><?php tr("Advanced options, such as selecting a demuxer or video & 
audio codecs."); ?></li>
<li><?php tr("On your own language: currently SMPlayer is translated into more than 30 
languages, including Spanish, German, French, Italian, Russian, Chinese,
Japanese...."); ?></li>
<li><?php tr("Free and opensource. SMPlayer is under the <b>GPL</b> license."); ?></li>
<li><?php tr("Compatible with Windows NT/2000/XP/2003/Vista/Server 2008/7/8."); ?></li>
</ul>

</div> <!-- span -->

<div class="span4">
<h3>Supported formats:</h3>
<p>
(S)VCD, DVD, MPEG-1/2, AVI, ASF/WMV/WMA, QT/MOV/MP4, RealAudio/RealVideo,
Ogg/OGM, Matroska, NUT, NSV, VIVO, FLI, NuppelVideo, yuv4mpeg, FILM (.cpk),
RoQ, PVA, streaming via HTTP/FTP, RTP/RTSP, MMS/MMST, MPST, SDP.
<hr>

<h3>Video codecs:</h3>
<p>
MPEG-1 (VCD), MPEG-2 (SVCD/DVD/DVB), MPEG-4 ASP, DivX, OpenDivX, DivX 5, Xvid,
H.264, Windows Media Video 7/8 (WMV1/2), Windows Media Video 9 (WMV3),
RealVideo 1.0, 2.0, RealVideo 3.0 (RP8), 4.0 (RP9),
Sorenson v1/v3 (SVQ1/SVQ3), Cinepak, RPZA, QuickTime,
DV, 3ivx, Intel Indeo3 (3.1, 3.2), 
Intel Indeo 4.1 and 5.0, VIVO 1.0, 2.0, I263, H.263, 
MJPEG, AVID, VCR2, ASV2, FLI/FLC, HuffYUV.
<hr>

<h3>Audio codecs:</h3>
<p>
MPEG layer 1, 2, and 3 (MP3), 
AC3/A52, E-AC3, DTS, AAC, WMA, WMA 9, 
RealAudio, QuickTime, Ogg Vorbis, VIVO, 
alaw/ulaw, (ms)gsm, pcm, *adpcm.
</div> <!-- span ->

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
<p>
<?php
echo "<center>". download_windows_full_link(get_tr("Download SMPlayer for Windows"), true) ."</center>\n";
?>

<h1>Screenshots</h1>
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
echo "<p><a href=\"reviews.php?tr_lang=$tr_lang\" class=\"btn btn-success btn-large\">".
get_tr("Click here to read more reviews") . "</a></p>\n";
?>

</div>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
