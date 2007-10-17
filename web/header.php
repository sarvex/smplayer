<?php

function header_print_section($name, $link, $is_active) {
	$act_tab = " id=\"active_tab\"";
	$act_color = " id=\"text_black\">";

	echo "<li"; if ($is_active) echo $act_tab;
	echo "><a href=\"".$link."\"><span";
	if ($is_active) echo $act_color; else echo ">";
	echo $name;
	echo "</a></span></li>\n";
}

function header_set_section($s, $rel_path="") {
	global $tr_lang;
?>
	<div id="languages">
	<div id="languages_links">
	<ul>
	<li><a href="index.php?tr_lang=nl\">Nederlands</a> |&nbsp</li>
	<li><a href="index.php">English</a> |&nbsp</li>
	<li><a href="index.php?tr_lang=fr">Français</a> |&nbsp</li>
	<li><a href="index.php?tr_lang=es">Español</a></li>
	<li><a href="index.php?tr_lang=ja">日本語</a></li>
	</ul>
	</div>
	</div>

	<div id="header">
	<br><br>
	<span style="font-size: 26px">
<?php
	echo "<a href=\"index.php?tr_lang=".$tr_lang."\">";
	tr("The SMPlayer Project");
?>
	</a></span>

	<div id="navigation">
	<div id="navigation_box">
	<div id="header_links">
	<ul>

<?php
	header_print_section(get_tr("Main"), $rel_path."index.php?tr_lang=".$tr_lang, ($s=="main"));

	header_print_section(get_tr("Screenshots"), $rel_path."screenshots.php?tr_lang=".$tr_lang, ($s=="screenshots"));

	header_print_section(get_tr("Downloads"), $rel_path."downloads.php?tr_lang=".$tr_lang, ($s=="downloads"));

	header_print_section(get_tr("Forum"), $rel_path."forums/index.php?tr_lang=".$tr_lang, ($s=="forums"));

	header_print_section(get_tr("Bug Tracking"), "http://sourceforge.net/tracker/?group_id=185512&atid=913573", ($s=="bugs"));

	header_print_section(get_tr("Feature Requests"), "http://sourceforge.net/tracker/?group_id=185512&atid=913576", ($s=="features"));

	header_print_section(get_tr("Wiki"), "http://smplayer.wiki.sourceforge.net/", ($s=="wiki"));
?>
	</ul>

	</div>
	</div>
	</div>

	</div>
<?php
}
?>
