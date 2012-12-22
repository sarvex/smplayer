<?php
include_once("header.php");
print_header(get_tr("SMPlayer - Latest Changes"));
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">
<h1><?php tr("Latest changes"); ?></h1>
<p><?php tr("Here you can find a list with the latest changes in SMPlayer:"); ?></p>

<?php
$release_notes_file = "translations/release_notes_". $tr_lang .".html";
if (file_exists($release_notes_file)) {
	include($release_notes_file);
} else {
	include("translations/release_notes_en.html");
}
echo "<p>";
echo "<a href=\"downloads.php?tr_lang=$tr_lang\" class=\"btn btn-success btn-large\">". 
     get_tr("Click here to download the latest version") ."</a>";
?>
</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
