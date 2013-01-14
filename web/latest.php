<?php
include_once("header.php");
include_once("download_links.php");
print_header(get_tr("Latest changes"), get_tr("Latest changes of SMPlayer"));
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">
<h1><i class="icon-exclamation-sign"></i> <?php tr("Latest changes"); ?></h1>
<p><?php tr("Here you can find a list with the latest changes in SMPlayer:"); ?></p>

<?php
$release_notes_file = "translations/release_notes_". $tr_lang .".html";
if (file_exists($release_notes_file)) {
	include($release_notes_file);
} else {
	include("translations/release_notes_en.html");
}
echo "<p>" .  auto_download_button(get_tr("Click here to download the latest version")) ."</p>\n";
?>
</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
