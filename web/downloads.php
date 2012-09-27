<?php
include_once("header.php");
print_header(get_tr("SMPlayer - Downloads"));
echo "<body>\n";
print_menu(3);
?>

<div class="container-fluid">

<?php
include_once("download_links.php");

echo "<h1>".get_tr("Downloads")."</h1>";
?>

<!-- WINDOWS -->
<h2>Windows</h2>
<table>
<tr>
<td><img src="iconos/kpackage.png" alt="*"></td>
<td>
<?php 
echo download_windows_full_link(get_tr("Click here to get the full package"));
?>
<br>
<?php
tr("This package contains smplayer, themes, translations, mplayer %1 and 
the YouTube browser (smtube).","<i>r35203</i>");
?>
</td>
</tr>

<tr>
<td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
tr("There are available other packages for advanced users, %1.", download_all_link(get_tr("here")));
echo "<br>";
tr("If you wish you can also try %1.", 
"<a href=\"http://sourceforge.net/projects/smplayer/files/Unstable/\"><b>". get_tr("the unstable version") ."</b></a>");
?>
</td></tr>
</table>
<div class="alert alert-block">
<strong>
<?php
tr("<b>Notice:</b> on the first playback, a font cache will be 
created (necessary for OSD and subtitles). This can take up to 10 
or 20 seconds. This is only done once.");
?>
</strong>
</div>

<!-- LINUX -->
<h2>Linux</h2>
<table>
<tr>
<td><img src="iconos/ubuntu.png" alt="*"></td>
<td>
<?php
echo "<b>"; tr("Packages for Ubuntu:"); echo "</b><br>";
tr("To install smplayer, just run these commands in a terminal:");
?>
<pre>
sudo add-apt-repository ppa:rvm/smplayer
sudo apt-get update
sudo apt-get install smplayer smtube smplayer-themes
</pre>
</td>
</tr>

<tr><td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
echo "<a href=\"https://sourceforge.net/apps/mediawiki/smplayer/index.php?title=Contributed_Packages\">" .
     "<b>". get_tr("Contributed packages for other distros") . "</b></a>";
echo "<br>";
tr("List of packages contributed by other people.");
?>
</td>
</tr>
</table>

<!-- SOURCES -->
<h2><?php tr("Sources"); ?></h2>
<table>
<tr>
<td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
//echo "<b>"; tr("Sources:"); echo "</b><br>";
echo download_src_link();
echo "<br>";
echo download_smtube_link();
echo "<br>";
echo download_themes_src_link();
?>
</td>
</tr>
</table>

</div> <!-- container>

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
