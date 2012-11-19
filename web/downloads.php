<?php
include_once("header.php");
print_header(get_tr("SMPlayer - Downloads"));
echo "<body>\n";
print_menu(3);
?>

<div id="installer" class="modal hide fade in" style="display: none;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php tr("Information about the Windows installer"); ?></h3>
	</div>
	<div class="modal-body">
		<p>
		<?php
		tr("For an easy installation on Windows we provide a package with installer.");
		if (0) {
		echo "<div class=\"alert alert-error\">\n";
		tr("The installer may contain a promotional screen with an offer to install a 3rd party application.");
		echo " ";
		tr("If you aren't interested in the offer, just uncheck the option(s) and the installation of smplayer will proceed as usual.");
		echo " ";
		tr("This screen allows us to further improve smplayer and keep distributing it for free. We ask for your understanding.");
		echo "</div>\n";
		}
		echo "<h4>". get_tr("Optional components") ."</h4>\n";
		tr("The installer allows to select the components to install:");
		echo "<ul>\n";
		echo "<li><b>". get_tr("Languages") ."</b><br>". 
			get_tr("Translations for more than 30 languages are provided.") ." ".
			get_tr("If you uncheck this option, only English will be available.") ."</li>\n";
		echo "<li><b>". get_tr("Icon themes") ."</b><br>". 
			get_tr("Some icon themes are provided, which allow to change the look of the application.") ."</li>\n";
		echo "<li><b>". get_tr("Binary codecs"). "</b><br>". 
			get_tr("If you check this option, some extra codecs will be downloaded and installed in the smplayer folder.") ." ".
			get_tr("These codecs are only necessary for some uncommon formats.") ."</li>\n";
		echo "</ul>\n";
		echo "<h4>". get_tr("Uninstallation") ."</h4>\n";
		echo "<p>\n";
		/* Before translating the string "uninstall smplayer" be sure */
		/* it really shows translated under the Start menu, */
		/* otherwise leave it in English */
		tr("You can uninstall smplayer easily from the control panel or using the <i>uninstall smplayer</i> option in the smplayer menu within the Windows <i>Start</i> menu.");
		?>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php tr("Close"); ?></a>
	</div>
</div>


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
echo "<br>";
tr("This package contains smplayer, themes, translations, mplayer %1 and 
the YouTube browser (smtube).","<i>r35203</i>");
echo "<br>";
echo "<a data-toggle=\"modal\" href=\"#installer\" class=\"btn btn-mini\">". get_tr("More info") ."</a>\n";
?>
</td>
</tr>

<tr>
<td><img src="iconos/kpackage.png" alt="*"></td>
<td>
<?php
echo "<a href=\"http://sourceforge.net/projects/smplayer/files/Unstable/beta/smplayer-0.8.1.4724-x86.exe/download\"><b>smplayer-0.8.1.4724-x86.exe</b></a>";
echo "<br>";
tr("Test a beta of the upcoming version 0.8.2. Features: new skinnable UI and a new mplayer build with a lot of fixes.");
echo "<br>";
tr("In case you find any problem, please report it in %1.", "<a href=\"http://smplayer.sourceforge.net/forum/\">". get_tr("our forum") ."</a>");
?>
</td>
</tr>


<tr>
<td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
tr("There are available other packages (like a portable version), %1.", download_all_link(get_tr("here")));
echo "<br>";
tr("If you wish you can also try the %1.", 
"<a href=\"http://sourceforge.net/projects/smplayer/files/Unstable/\"><b>". get_tr("development version") ."</b></a>");
?>
</td></tr>
</table>

<?php
if (0) {
echo "<div class=\"alert alert-block\">";
echo "<strong>";
tr("<b>Notice:</b> on the first playback, a font cache will be 
created (necessary for OSD and subtitles). This can take up to 10 
or 20 seconds. This is only done once.");
echo "</strong>";
echo "</div>";
}
?>

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
