<?php
echo "<p>";
tr("SMPlayer is a complete media player for Windows and Linux. It uses
the award-winning %1 as playback engine which is capable of
playing most video and audio formats (avi, mkv, wmv, mp4, mpeg... %2). 
It <b>uses its own codecs</b>, so you don't need to install any codec packs.", 
"MPlayer",
"<a data-toggle=\"modal\" href=\"#formats\">" .get_tr("see list") ."</a>");
echo "<p>";
tr("One of the most interesting features of SMPlayer: <b>it remembers the 
settings of all files you play</b>. So you start to watch a movie but you 
have to leave... don't worry, when you open that movie again it will 
resume at the same point you left it, and with the same settings: audio 
track, subtitles, volume..."); 
?>

<p>
<?php tr("Some other interesting features:"); ?>
<ul>
<li><?php
tr("It can play and download Youtube videos.");
echo " ";
tr("A Youtube browser is included, which allows to easily download Youtube videos too."); ?></li>
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

<?php
if (0) {
echo "<b>";
tr("Download <a href=%1>here</a> the latest version of SMPlayer", 
"\"downloads.php?tr_lang=".$tr_lang."\""); 
echo "</b>";
}
?>

<?php
if (1) {
echo "<center>";
echo '<embed src="http://video.findmysoft.com/jwplayer/player.swf?file=http://video.findmysoft.com/2012/11/14/smplayer.mp4&image=http://video.findmysoft.com/2012/11/14/smplayer.jpg&skin=http://video.findmysoft.com/jwplayer/skin/slim.zip" width="512" height="301" allowfullscreen="true" /><br><span style="font-size:12px"><a href="http://smplayer.findmysoft.com/">SMPlayer</a> Quick Look Video by FindMySoft.com</span>';
echo "</center>";
}
?>

<div id="formats" class="modal hide fade in" style="display: none;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php tr("Formats and Codecs"); ?></h3>
	</div>
	<div class="modal-body">
		<?php include("formats_text.php"); ?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php tr("Close"); ?></a>
	</div>
</div>
<?php /* <p><a data-toggle="modal" href="#formats" class="btn btn-primary btn-large">Launch demo modal</a></p> */ ?>
