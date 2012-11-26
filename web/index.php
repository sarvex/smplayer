<?php
include_once("header.php");
print_header(get_tr("SMPlayer - Opensource Media Player"), 1);
echo "<body>\n";
print_menu(1);
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
			echo "<ul>\n";
			echo "<li>". get_tr("Supports most formats and codecs: AVI, MKV, MP4, MPEG, H.264...") ."</li>\n";
			echo "<li>". get_tr("Codecs included") ."</li>\n";
			echo "<li>". get_tr("Can play and download Youtube&trade; videos"). "</li>\n";
			echo "<li>". get_tr("Automatically search and download subtitles"). "</li>\n";
			echo "<li>". get_tr("Skins"). "</li>\n";
			echo "</ul>";
			echo "</p>";
			echo "<p><a href=\"downloads.php?tr_lang=$tr_lang\" class=\"btn btn-success btn-large\">".
                  get_tr("Click here to download the latest version") .
                  "</a></p>\n";
			?>
		</div>
		<div class="span3">
		<img src="images/twisted.png">
		</div>
	</div>
</div>
</span>

<div class="row-fluid">
	<div class="span9">
		<h3><?php tr("About SMPlayer"); ?></h3>
		<?php include("info.php"); ?>
	</div>

	<div class="span3">
		<div class="well">
			<h3><?php tr("Latest changes"); ?></h3>
			<?php
			$release_notes_file = "translations/release_notes_". $tr_lang .".html";
			if (file_exists($release_notes_file)) {
				include($release_notes_file);
			} else {
				include("translations/release_notes_en.html");
			}
			?>
			<!--
			<p>
			<a href="downloads.php" class="btn btn-primary btn-large"><?php tr("Downloads"); ?></a>
			</p>
			-->
		</div> <!-- well -->
	</div> <!-- span3 -->
</div>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
