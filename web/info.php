<div id="info">
<div id="info_download">
<center>
<img src="images/screenshots/video_en.jpg">
</center>

<?php 
echo "<p>";
tr("Download <a href=%1>here</a> the latest version of the SMPlayer", 
"\"downloads.php?tr_lang=".$tr_lang."\""); 
?>
</div>

<div id="info_features">

<?php 
echo "<p>";
tr("SMPlayer intends to be a complete front-end for <a href=%1>MPlayer</a>,
from basic features like playing videos, DVDs, and VCDs to more advanced 
features like support for MPlayer filters and more.", 
"\"http://www.mplayerhq.hu/\"");
echo "<br><br>";
echo "<p>";
tr("One of the most interesting features of SMPlayer: <b>it remembers the 
settings of all files you play</b>. So you start to watch a movie but you 
have to leave... don't worry, when you open that movie again it will 
resume at the same point you left it, and with the same settings: audio 
track, subtitles, volume..."); 
echo "<br><br>";
?>

<p>
<?php tr("Other additional interesting features:"); ?>
<ul>
<li><?php tr("Configurable subtitles. You can choose font and size, and even 
colors for the subtitles."); ?></li>
<li><?php tr("Audio track switching. You can choose the audio track you want
to listen. Works with avi and mkv. And of course with DVDs."); ?></li>
<li><?php tr("Seeking by mouse wheel. You can use your mouse wheel to go forward 
or backward in the video."); ?></li>
<li><?php tr("Video equalizer, allows you to adjust the brightness, contrast, hue,
saturation and gamma of the video image."); ?></li>
<li><?php tr("Multiple speed playback. You can play at 2X, 4X... and even in 
slow motion."); ?>
</li>
<li><?php tr("Filters. Several filters are available: deinterlace, postprocessing,
denoise... and even a karaoke filter (voice removal)."); ?></li>
<li><?php tr("Audio and subtitles delay adjustment. Allows you to sync audio and
subtitles."); ?></li> 
<li><?php tr("Advanced options, such as selecting a demuxer or video & 
audio codecs."); ?>
</li>
<li><?php tr("Playlist. Allows you to enqueue several files to be played one after 
each other. Autorepeat and shuffle supported too."); ?></li>
<li><?php tr("Preferences dialog. You can easily configure every option of SMPlayer
by using a nice preferences dialog."); ?></li>
<li><?php tr("Translations: currently SMPlayer is translated into more than 20 
languages, including Spanish, German, French, Italian, Russian, Chinese,
Japanese...."); ?></li>
<li><?php tr("It's multiplatform. Binaries available for Windows and Linux."); ?></li>

<li><?php tr("SMPlayer is under the <b>GPL</b> license."); ?>
</li>
</ul>

</div>
</div>
