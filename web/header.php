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

function print_language_link($file, $name, $cod, $query, $last=false) {
	echo "<li><a href=\"".$file."?tr_lang=".$cod.$query."\">".$name."</a>";
	if (!$last) echo " |&nbsp";
	echo "</li>";
}

function header_set_section($s, $rel_path="") {
	global $tr_lang;
	
	$file = basename($_SERVER['SCRIPT_NAME']);
	$query =  $_SERVER['QUERY_STRING'];

	$query = preg_replace("/&tr_lang=\S\S/", "", $query);
	$query = preg_replace("/tr_lang=\S\S/", "", $query);
	$query = preg_replace("/^&/", "", $query);
	if ($query!="") $query = "&".$query;
	//echo "query: $query";
?>
	<div id="languages">
	<div id="languages_links">
	<ul>
<?php
	//print_language_link($file, "Nederlands", "nl", $query);
	print_language_link($file, "English", "en", $query);
	//print_language_link($file, "Français", "fr", $query);
	print_language_link($file, "Español", "es", $query);
	print_language_link($file, "日本語", "ja", $query);
	print_language_link($file, "Polski", "pl", $query);
	print_language_link($file, "Română", "ro", $query);
	print_language_link($file, "Українська", "uk", $query, true);
?>
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
