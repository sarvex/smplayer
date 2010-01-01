<?php
include_once("site.php");

function header_print_link($name, $link, $external=false, $last=false) {
	global $tr_lang;
	echo "<a href=\"".$link;
	if (!$external) echo "?tr_lang=$tr_lang";
	echo "\">";
	echo $name;
	echo "</a>";
	if (!$last) echo " &bull;";
	echo "\n";
}

function header_print_links($rel_path="") {
	header_print_link(get_tr("Main"), $rel_path."index.php");
	header_print_link(get_tr("Screenshots"), $rel_path."screenshots.php");
	header_print_link(get_tr("Downloads"), $rel_path."downloads.php");
	header_print_link(get_tr("Forum"), "http://smplayer.berlios.de/forums/", true);
	header_print_link(get_tr("Bug Tracking"), "http://sourceforge.net/tracker/?group_id=185512&amp;atid=913573", true);
	header_print_link(get_tr("Feature Requests"), "http://sourceforge.net/tracker/?group_id=185512&amp;atid=913576", true);
	header_print_link(get_tr("Wiki"), "http://smplayer.wiki.sourceforge.net/", true, true);
}

function print_host_logo() {
	global $site;

	if ($site == "sourceforge") 
		echo "<a href=\"http://sourceforge.net\"><img src=\"http://sflogo.sourceforge.net/sflogo.php?group_id=185512&amp;type=2\" width=\"125\" height=\"37\" border=\"0\" alt=\"SourceForge.net Logo\"></a>";
	else
		echo "<a href=\"http://developer.berlios.de\"><img src=\"http://developer.berlios.de/bslogo.php?group_id=9394\" width=\"124\" height=\"32\" border=\"0\" alt=\"BerliOS Logo\"></a>";
}

function print_header($rel_path="") {
?>
<div class="sm_headerbar">
	<div class="inner">

	<span class="sm_corners-top"><span></span></span>

	<div id="sm_site-description">
		<?php echo '<a href="'.$rel_path.'index.php" id="sm_logo"><img src="'.$rel_path.'images/smplayer_logo.png" width="90" height="90" alt="" title=""></a>'; ?>
		<h1><?php tr("The SMPlayer Project"); ?></h1>
		<p><?php tr("Play anything"); echo " &bull; "; tr("Forget about codecs"); ?></p>
	</div>

	<div id="sm_right-side">
	<?php print_host_logo(); ?>
	</div>

	<div id="sm_linkbar"><hr>
	<?php header_print_links($rel_path); ?>
	</div>

	<span class="sm_corners-bottom"><span></span></span>

	</div>
</div>
<?php
}
?>
