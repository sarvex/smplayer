<?php
function header_set_section($s) {
	global $tr_lang;

	echo "<div id=\"languages\">\n";
	echo "<div id=\"languages_links\">\n";
	echo "<ul>\n";
	echo "<li><a href=\"index.php?tr_lang=nl\">Dutch</a> |&nbsp</li>\n";
	echo "<li><a href=\"index.php\">English</a> |&nbsp</li>\n";
	echo "<li><a href=\"index.php?tr_lang=fr\">French</a> |&nbsp</li>\n";
	echo "<li><a href=\"index.php?tr_lang=es\">Spanish</a></li>\n";
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

	$act_tab = " id=\"active_tab\"";
	$act_color = " id=\"text_black\">":

	echo "<li"; if ($s=="main") echo $act_tab;
	echo "><a href=\"index.php?tr_lang=".$tr_lang."\"><span";
	if ($s=="main") echo $act_color; else echo ">";
	tr("Main");
	echo "</a></span></li>\n";

	echo "<li"; if ($s=="screenshots") echo $act_tab;
	echo "><a href=\"screenshots.php?tr_lang=".$tr_lang."\"><span";
	if ($s=="screenshots") echo $act_color; else echo ">";
	tr("Screenshots");
	echo "</span></a></li>\n";

	echo "<li"; if ($s=="downloads") echo $act_tab;
	echo "><a href=\"downloads.php?tr_lang=".$tr_lang."\"><span";
	if ($s=="downloads") echo $act_color; else echo ">";
	tr("Downloads");
	echo "</span></a></li>\n";

	echo "<li"; if ($s=="forums") echo $act_tab;
	echo "><a href=\"forums/index.php\"><span";
	if ($s=="forums") echo $act_color; else echo ">";
	tr("Forums");
	echo "</span></a></li>\n";

	echo "<li"; if ($s=="bugs") echo $act_tab;
	echo "><a href=\"http://sourceforge.net/tracker/?group_id=185512&atid=913573\"><span";
	if ($s=="bugs") echo $act_color; else echo ">";
	tr("Bug Tracking");
	echo "</span></a></li>\n";

	echo "<li"; if ($s=="features") echo $act_tab;
	echo "><a href=\"http://sourceforge.net/tracker/?group_id=185512&atid=913576\"><span";
	if ($s=="features") echo $act_color; else echo ">";
	tr("Feature Requests");
	echo "</span></a></li>\n";

	echo "<li"; if ($s=="documentation") echo $act_tab;
	echo "><a href=\"documentation.php?tr_lang=".$tr_lang."\"><span";
	if ($s=="documentation") echo $act_color; else echo ">";
	tr("Documentation");
	echo "</span></a></li>\n";

	echo "</ul>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";

	echo "</div>\n";
}
?>
