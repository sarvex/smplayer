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

function header_set_section($s) {
	global $tr_lang;

	echo "<div id=\"languages\">\n";
	echo "<div id=\"languages_links\">\n";
	echo "<ul>\n";
	echo "<li><a href=\"index.php?tr_lang=nl\">Nederlands</a> |&nbsp</li>\n";
	echo "<li><a href=\"index.php\">English</a> |&nbsp</li>\n";
	echo "<li><a href=\"index.php?tr_lang=fr\">Français</a> |&nbsp</li>\n";
	echo "<li><a href=\"index.php?tr_lang=es\">Español</a></li>\n";
	echo "<li><a href=\"index.php?tr_lang=ja\">日本語</a></li>\n";
	echo "</ul>\n";
	echo "</div>\n";
	echo "</div>\n";

	echo "<div id=\"header\">\n";
	echo "<br><br>\n";
	echo "<span style=\"font-size: 26px\">\n";

	echo "<a href=\"index.php?tr_lang=".$tr_lang."\">";
	tr("The SMPlayer Project");
	echo "</a></span>";

	echo "<div id=\"navigation\">\n";
	echo "<div id=\"navigation_box\">\n";
	echo "<div id=\"header_links\">\n";
	echo "<ul>\n";

	header_print_section(get_tr("Main"), "index.php?tr_lang=".$tr_lang, ($s=="main"));

	header_print_section(get_tr("Screenshots"), "screenshots.php?tr_lang=".$tr_lang, ($s=="screenshots"));

	header_print_section(get_tr("Downloads"), "downloads.php?tr_lang=".$tr_lang, ($s=="downloads"));

	header_print_section(get_tr("Forum"), "forums/index.php", ($s=="forums"));

	header_print_section(get_tr("Bug Tracking"), "http://sourceforge.net/tracker/?group_id=185512&atid=913573", ($s=="bugs"));

	header_print_section(get_tr("Feature Requests"), "http://sourceforge.net/tracker/?group_id=185512&atid=913576", ($s=="features"));

	header_print_section(get_tr("Documentation"), "documentation.php?tr_lang=".$tr_lang, ($s=="documentation"));

	echo "</ul>\n";

	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";

	echo "</div>\n";
}
?>
