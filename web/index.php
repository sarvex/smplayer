<?php
include_once("header.php");
print_header(get_tr("SMPlayer - General Info"), 1);
echo "<body>\n";
print_menu(1);
?>

<div class="container-fluid">

<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
	<div class="row">
		<div class="span2">
			<img src="images/smplayer_logo_big.png">
		</div>
		<div class="span6">
			<h1>SMPlayer</h1>
			<p><?php tr("Graphical Interface for MPlayer");?></p>
			<p><a href="downloads.php" class="btn btn-success btn-large"><?php tr("Click here to download the latest version");?></a></p>
		</div>
		<div class="span3">
		<img src="images/twisted.png">
		</div>
	</div>
</div>

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
