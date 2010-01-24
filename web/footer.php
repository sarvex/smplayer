<?php
include_once("l10n.php");

function print_language_link($file, $name, $cod, $query, $last=false) {
	echo "<a href=\"".$file."?tr_lang=".$cod.$query."\">".$name."</a>";
	if (!$last) echo " | ";
	echo "\n";
}

function print_languages() {
	global $tr_lang, $site;

	$file = basename($_SERVER['SCRIPT_NAME']);
	$query =  $_SERVER['QUERY_STRING'];

	$query = preg_replace("/&tr_lang=\S\S/", "", $query);
	$query = preg_replace("/tr_lang=\S\S/", "", $query);
	$query = preg_replace("/^&/", "", $query);
	if ($query!="") $query = "&".$query;
	//echo "query: $query";

	//print_language_link($file, "Nederlands", "nl", $query);
	print_language_link($file, "English", "en", $query);
	print_language_link($file, "Italiano", "it", $query);
	//print_language_link($file, "Français", "fr", $query);
	print_language_link($file, "Español", "es", $query);
	print_language_link($file, "Deutsch", "de", $query);
	print_language_link($file, "日本語", "ja", $query);
	print_language_link($file, "Polski", "pl", $query);
	print_language_link($file, "Română", "ro", $query);
	print_language_link($file, "Українська", "uk", $query);
	print_language_link($file, "Русский", "ru", $query);
	print_language_link($file, "中文", "zh", $query);
	print_language_link($file, "Magyar", "hu", $query);
	print_language_link($file, "Português", "pt", $query);
	print_language_link($file, "Suomi", "fi", $query, true);
}
?>

<div id="sm_footer">
<?php
tr("This page is available in the following languages:");
echo " ";
print_languages();
?>
<br><br>
&copy The SMPlayer Project
</div>
