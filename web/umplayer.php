<?php
include_once("header.php");
print_header("UMPlayer");
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">

<h1>UMPlayer</h1>
<div class="row-fluid">
<div class="span9">
<p>
<?php
tr("%1 is a fork of SMPlayer created by %2. Since this project seems dead now, 
the SMPlayer team has released a new version which fixes Youtube playback.",
"<a target=\"_blank\" href=\"http://www.umplayer.com/\">UMPlayer</a>",
"Ori Rejwan");
?>
<p>
<?php
tr("Notice that UMPlayer is based on an old version of SMPlayer, so the new
features of SMPlayer are not available on UMPlayer.");
?>
<p>
<center>
<a data-toggle="modal" href="#screenshot"><img class="img-polaroid" src="images/screenshots/thumbs/th_umplayer.png"></a>
</center>

<p>
<div class="alert alert-block">
<strong>
<?php
echo "<b>". get_tr("Notice:") ."</b><br>\n";
tr("As of 2012.12.19 umplayer can't play youtube videos anymore.
Please use smplayer instead.");
?>
</strong>
</div>

<?php
echo "<h1>". get_tr("Downloads") ."</h1>";
?>

<!-- WINDOWS -->
<h2>Windows</h2>
<table>
<tr>
<td><img src="iconos/kpackage.png" alt="*"></td>
<td>
<?php
echo "<a href=\"http://sourceforge.net/projects/smplayer/files/UMPlayer/0.98.1/umplayer-0.98.1-x86.exe/download\">";
echo "<b>". get_tr("Click here to get UMPlayer 0.98.1") ."</b></a>";
echo "<br>";
tr("This package contains umplayer, themes, translations and mplayer.");
?>
</td>
</tr>
</table>

<!-- LINUX -->
<h2>Linux</h2>
<table>
<tr>
<td><img src="iconos/ubuntu.png" alt="*"></td>
<td>
<?php
echo "<b>"; tr("Packages for Ubuntu:"); echo "</b><br>";
tr("To install umplayer, just run these commands in a terminal:");
?>
<pre>
sudo add-apt-repository ppa:rvm/smplayer
sudo apt-get update
sudo apt-get install umplayer
</pre>
</td>
</tr>
</table>

<!-- SOURCES -->
<h2><?php tr("Sources"); ?></h2>
<table>
<tr>
<td><img src="iconos/package.png" alt="*"></td>
<td>
<a href="http://sourceforge.net/projects/smplayer/files/UMPlayer/0.98.1/umplayer_0.98.1.orig.tar.gz/download"><b><?php tr("UMPlayer sources"); ?></b></a>
</td>
</tr>
</table>

</div> <!-- span -->

<div class="span3">
<div class="well">
<h3><?php tr("Latest changes"); ?></h3>
<p>
<?php
$release_notes_file = "translations/umplayer_release_notes_". $tr_lang .".html";
if (file_exists($release_notes_file)) {
	include($release_notes_file);
} else {
	include("translations/umplayer_release_notes_en.html");
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

<div id="screenshot" class="modal hide fade in" style="display: none;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php tr("UMPlayer Screenshot"); ?></h3>
	</div>
	<div class="modal-body">
		<center><img src="images/screenshots/umplayer.png"></center>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php tr("Close"); ?></a>
	</div>
</div>

</body>
</html>
