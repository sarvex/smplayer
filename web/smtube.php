<?php
include_once("header.php");
print_header("SMTube", get_tr("SMTube, a Youtube browser for SMPlayer"));
echo "<body>\n";
print_menu(0);
?>

<div id="screenshot" class="modal hide fade in" style="display: none;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php tr("SMTube Screenshot"); ?></h3>
	</div>
	<div class="modal-body">
		<center><img src="images/screenshots/smtube.png"></center>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php tr("Close"); ?></a>
	</div>
</div>

<div class="container-fluid">

<h1>SMTube</h1>
<div class="row-fluid">
<div class="span9">
<p>
<?php
tr("SMPlayer now includes a Youtube browser which we called <i>SMTube</i>. 
The code was taken from %1 (developed by %2). 
This browser allows to search Youtube videos but it's also capable of downloading them.",
"<a target=\"_blank\" href=\"http://www.umplayer.com/\">UMPlayer</a>",
"Ori Rejwan");
?>
<p>
<center>
<a data-toggle="modal" href="#screenshot"><img class="img-polaroid" src="images/screenshots/thumbs/th_smtube.png"></a>
</center>

<p>
<?php tr("Several improvements have been done:"); ?>
<ul>
<li><?php tr("It's now a stand-alone application and you can select the video player to use 
(smplayer, mplayer, vlc, dragon player, totem or gnome-mplayer)."); ?></li>
<li><?php tr("It's possible to translate the application to other languages."); ?></li>
<li><?php tr("A configuration dialog has been added."); ?></li>
<li><?php tr("A few fixes."); ?></li>
</ul>

<p>
<?php tr("SMTube is already included in the Windows packages but on Linux it's an independent package."); ?>

</div> <!-- span -->

<div class="span3">
<div class="well">

<h3><?php tr("Latest changes"); ?></h3>
<p>
<?php
$release_notes_file = "translations/smtube_release_notes_". $tr_lang .".html";
if (file_exists($release_notes_file)) {
	include($release_notes_file);
} else {
	include("translations/smtube_release_notes_en.html");
}
?>

</div> <!-- well -->
</div> <!-- span -->

</div> <!-- row -->
</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
