<!-- Main hero unit for a primary marketing message or call to action -->
<span class="hidden-phone">
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span2">
			<img src="images/smplayer_logo_big.png" alt="Graphical User Interface (GUI) for MPlayer">
		</div>
		<div class="span6">
			<h1>SMPlayer</h1>
			<?php
			echo "<p>";
			tr("Graphical User Interface (GUI) for MPlayer");
			echo "<p class=\"second\">\n";
			echo "<img src=\"images/check2.png\"> ". get_tr("Plays every format: avi, mp4, mkv, divx, h.264, mpeg, mov...") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Built-in codecs. No codec packs needed") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Plays and downloads Youtube&trade; videos") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Automatically search and download subtitles") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Resumes playback") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Skin support") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Many audio and video filters included") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Simple and intuitive interface") ."<br>";
			echo "<img src=\"images/check2.png\"> ". get_tr("Multi-platform. Available for Windows and Linux") ."<br>";
			echo "</p>";
			echo "<p>" . auto_download_button() ."</p>\n";
			?>
		</div>
		<div class="span4">
		<?php echo '<a href="screenshots.php?tr_lang='. $tr_lang .'"><img src="images/twisted2.png"></a>'; ?>
		</div>
	</div>
</div>
</span>

<div class="row-fluid">
	<div class="span9">
		<h3><?php tr("About SMPlayer"); ?></h3>
<?php 
echo "<p>";
tr("SMPlayer is a graphical user interface (GUI) for the award-winning %1, 
which is capable of playing almost all known video and audio formats (%2).", "MPlayer",
"<a data-toggle=\"modal\" href=\"#formats\">" .get_tr("see list") ."</a>");
echo " ";
tr("Apart from providing access for the most common and useful options in MPlayer, 
SMPlayer adds other features, like the possibility to search and download 
Youtube&trade; videos.");
echo "<p>";
include("features.php");

if (1) {
echo "<center>";
echo '<embed src="http://video.findmysoft.com/jwplayer/player.swf?file=http://video.findmysoft.com/2012/11/14/smplayer.mp4&image=http://video.findmysoft.com/2012/11/14/smplayer.jpg&skin=http://video.findmysoft.com/jwplayer/skin/slim.zip" width="512" height="301" allowfullscreen="true" /><br><span style="font-size:12px"><a href="http://smplayer.findmysoft.com/">SMPlayer</a> Quick Look Video by FindMySoft.com</span>';
echo "</center>";
}
?>
	</div>

	<div class="span3">
		<?php 
		include_once("media_reviews.php");
		print_media_reviews(true);
		echo "<p><a href=\"reviews.php?tr_lang=$tr_lang\" class=\"btn btn-success btn-large\">".
			get_tr("Click here to read more reviews") .
			"</a></p>\n";
		?>
	</div> <!-- span3 -->
</div>

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
