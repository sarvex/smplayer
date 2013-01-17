<!-- Main hero unit for a primary marketing message or call to action -->
<span class="hidden-phone">
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span2">
			<img src="images/smplayer_logo_big.png" alt="Free Media Player for Windows with built-in codecs and Youtube download">
		</div>
		<div class="span6">
			<h1>SMPlayer</h1>
			<?php
			echo "<p>";
			tr("Free Media Player with Youtube&trade; support");
			if (0) {
			echo "<br>";
			tr("Graphical Frontend for MPlayer");
			}
			echo "<p class=\"second\">\n";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Plays every format: avi, mp4, mkv, divx, h.264, mpeg, mov...") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Built-in codecs. No codec packs needed") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Plays and downloads Youtube&trade; videos") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Automatically search and download subtitles") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Resumes playback") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Skin support") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Many audio and video filters included") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Simple and intuitive interface") ."<br>";
			echo "<i class=\"icon-ok\"></i> ". get_tr("Multi-platform. Available for Windows and Linux") ."<br>";
			echo "</p>";
			echo "<p>" . auto_download_button() ."</p>\n";
			?>
		</div>
		<div class="span4">
		<?php echo '<a href="screenshots.php?tr_lang='. $tr_lang .'"><img src="images/twisted2.png" alt="'. get_tr("See some screenshots"). '"></a>'; ?>
		</div>
	</div>
</div>
</span>

<div class="row-fluid">
	<div class="span9">
		<h2><i class="icon-info-sign"></i> <?php tr("About SMPlayer"); ?></h2>
		<?php 


echo "<p>";
tr("SMPlayer is a free open source media player for Windows and Linux with built-in codecs that
can play virtually all video and audio formats. It doesn't need any external codecs.");
echo " ";
tr("SMPlayer can also play, search and download Youtube&trade; videos.");
echo " ";
tr("It uses the award-winning %1 as playback engine which is capable of
playing almost all known video and audio formats (%2).", "MPlayer",
"<a data-toggle=\"modal\" href=\"#formats\">" .get_tr("see list") ."</a>");
echo " ";
if (0) tr("Install SMPlayer and forget about codecs!");
if (0) tr("SMPlayer is multi-platform and runs on Windows and Linux.");
echo "<p>";
include("features.php");

if (1) {
echo "<center>";
echo '<embed src="http://video.findmysoft.com/jwplayer/player.swf?file=http://video.findmysoft.com/2012/11/14/smplayer.mp4&image=http://video.findmysoft.com/2012/11/14/smplayer.jpg&skin=http://video.findmysoft.com/jwplayer/skin/slim.zip" width="512" height="301" allowfullscreen="true" /><br><span style="font-size:12px"><a href="http://smplayer.findmysoft.com/">SMPlayer</a> Quick Look Video by FindMySoft.com</span>';
echo "</center>";

if (0) echo "<p>" . auto_download_button() ."</p>\n";
}
?>

	</div>

	<div class="span3">
		<?php 
		if (0) {
			include_once("media_reviews.php");
			print_media_reviews(true);

			echo "<div class=\"well\">\n";
			include("reviews_box.php");
			echo "</div>\n";

			if (1) {
			echo "<p><a href=\"reviews.php?tr_lang=$tr_lang\" class=\"btn btn-success btn-large\">".
				get_tr("Click here to read more reviews") .
				"</a></p>\n";
			}
		}
		else {
			echo "<div class=\"well\">\n";
			$release_notes_file = "translations/release_notes_". $tr_lang .".html";
			if (file_exists($release_notes_file)) {
				include($release_notes_file);
			} else {
				include("translations/release_notes_en.html");
			}
			echo "</div>\n";

			if ($print_user_reviews) {
				echo "<div class=\"well\">\n";
				include("reviews_box.php");
				echo "</div>\n";
			}
		}
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
