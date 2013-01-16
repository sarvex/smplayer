<?php
include_once("header.php");
print_header(get_tr("Downloads"), get_tr("Download SMPlayer"));
echo "<body>\n";
print_menu(3);

include_once("download_links.php");
?>

<div class="container-fluid">
<?php echo "<h1><i class=\"icon-download-alt\"></i> ".get_tr("Downloads")."</h1>"; ?>

<div class="row-fluid">
<div class="span9">

<!-- WINDOWS -->
<div class="well">
<div class="row-fluid">

<span class="hidden-phone">
<div class="span2">
<img src="images/win-icon.png">
</div> <!-- span2 -->
</span>

<div class="span10">
<div class="media">
	<a class="pull-left" >
		<img class="media-object" src="images/installer-icon.png">
	</a>
	<div class="media-body">
		<h4 class="media-heading">
		<?php 
		echo download_windows_full_link(get_tr("Click here to download SMPlayer %1", "0.8.3"));
		?>
		</h4>
		<?php
		tr("This package contains smplayer, themes, translations, mplayer %1 and the Youtube&trade; browser.","<i>r35425</i>");
		//echo "<br>";
		echo " ";
		echo "<a data-toggle=\"modal\" href=\"#installer\" class=\"btn btn-mini\">". get_tr("More info") ."</a>\n";
		?>
	</div>
	<br>
	<a class="pull-left" >
		<img class="media-object" src="images/package-icon.png">
	</a>
	<div class="media-body">
		<h4 class="media-heading"><?php tr("Alternative packages"); ?></h4>
		<?php
		tr("There are available other packages (like a portable version), %1.", download_all_link(get_tr("here")));
		echo "<br>";
		tr("If you wish you can also try the %1.", 
		"<a href=\"http://sourceforge.net/projects/smplayer/files/Unstable/\"><b>". get_tr("development version") ."</b></a>");
		?>
	</div>
</div>
</div> <!-- span10 -->
</div> <!-- row -->
</div> <!-- well -->

<!-- LINUX -->
<div class="well">
<div class="row-fluid">

<span class="hidden-phone">
<div class="span2">
<img src="images/tux-icon.png">
</div> <!-- span2 -->
</span>

<div class="span10">

<div class="media">
	<a class="pull-left" >
		<img class="media-object" src="images/ubuntu-icon.png">
	</a>
	<div class="media-body">
		<h4 class="media-heading"><?php tr("Packages for Ubuntu"); ?></h4>
		<?php tr("To install smplayer, just run these commands in a terminal:"); ?>
<pre>
sudo add-apt-repository ppa:rvm/smplayer
sudo apt-get update
sudo apt-get install smplayer smtube smplayer-themes smplayer-skins
</pre>
	</div>
	<br>
	<a class="pull-left" >
		<img class="media-object" src="images/package-icon.png">
	</a>
	<div class="media-body">
		<h4 class="media-heading">
			<a href="https://sourceforge.net/apps/mediawiki/smplayer/index.php?title=Contributed_Packages">
			<?php tr("Contributed packages for other distros"); ?></a>
		</h4>
		<?php tr("List of packages contributed by other people."); ?>
	</div>
</div>
</div> <!-- span10 -->
</div> <!-- row -->
</div> <!-- well -->

<!-- SOURCES -->
<div class="well">
<div class="row-fluid">

<span class="hidden-phone">
<div class="span2">
<img src="images/source-icon.png">
</div> <!-- span2 -->
</span>

<div class="span10">

<div class="media">
	<a class="pull-left" >
		<img class="media-object" src="images/package-icon.png">
	</a>
	<div class="media-body">
		<h4 class="media-heading"><?php tr("Sources"); ?></h4>
		<?php
		echo download_src_link();
		echo "<br>";
		echo download_smtube_link();
		echo "<br>";
		echo download_themes_src_link();
		echo "<br>";
		echo download_skins_src_link();
		?>
	</div>
	<br>
	<a class="pull-left" >
		<img class="media-object" src="images/download-icon.png">
	</a>
	<div class="media-body">
		<h4 class="media-heading"><?php tr("Development"); ?></h4>
		<?php tr("You can get the latest source from svn with this command:"); ?>
<pre>
svn co https://smplayer.svn.sourceforge.net/svnroot/smplayer/smplayer/trunk/ smplayer-svn
</pre>
		<i class="icon-folder-open"></i> 
		<a href="http://smplayer.svn.sourceforge.net/viewvc/smplayer/">
		<b><?php tr("Browse the svn repository"); ?></b></a>
	</div>
</div>
</div> <!-- span10 -->
</div> <!-- row -->
</div> <!-- well -->

</div> <!-- span9 -->

<div class="span3">
		<?php
		if (0) {
			echo '<div class="well">';
			echo "<b>Notice:</b><br>";
			echo "As of 2012.12.19 smplayer 0.8.2 can't play
				youtube videos due to changes in the youtube site. A new release
			will be coming soon. Meanwhile you can use the unstable version
			(the problem is already fixed there).";
			echo "</div>";
		}
		?>
		<center>
		<?php include("awards.php"); ?>
		</center>
		<br>
</div>

</div> <!-- row  -->
</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

<!-- popup -->
<div id="installer" class="modal hide fade in" style="display: none;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php tr("Information about the Windows installer"); ?></h3>
	</div>
	<div class="modal-body">
		<p>
		<?php
		tr("For an easy installation on Windows we provide a package with installer.");
		if (1) {
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

</body>
</html>
