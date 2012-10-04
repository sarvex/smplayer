<?php
include_once("header.php");
print_header("SMPlayer - SMTube");
echo "<body>\n";
print_menu(1);
?>

<div class="container-fluid">

<h1>SMTube</h1>
<div class="row-fluid">
<div class="span9">
<p>
SMPlayer now includes a Youtube browser which I called <i>SMTube</i>.
The code was taken from <a target="_blank" href="http://www.umplayer.com/">UMPlayer</a> 
(developed by Ori Rejwan).
This browser allows to search for Youtube videos but it can also download them.

<p>
<center><img src="images/screenshots/thumbs/th_smtube.png"></center>

<p>
Several improvements have been done:
<ul>
<li>It's now a stand-alone application and you can select the video player to use 
(smplayer, mplayer, vlc, dragon player, totem or gnome-mplayer).</li>
<li>It's possible to translate the application to other languages.</li>
<li>A configuration dialog has been added.</li>
<li>A few fixes.</li>
</ul>

<p>
SMTube is already included in the Windows packages but on Linux it's on an independent package.

</div> <!-- span -->

<div class="span3">
<div class="well">

<h3><?php tr("Latest changes"); ?></h3>
<p>
<b>Version 1.2.</b>
<ul>
<li>Update for Youtube changes.</li>
<li>Usability improvements.</li>
</ul>

<p>
<b>Version 1.1.</b>
<ul>
<li>(Linux) Possibility to select the player to use: smplayer, mplayer, vlc, dragon player and totem.</li>
<li>Fix a possible crash that may happen on Ubuntu if using the ambiance or radiance themes.</li>
<li>New translations: Basque and Portuguese.</li>
<li>(Windows) Possibility to build a portable version.</li>
</ul>

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
