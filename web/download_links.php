<?php
include_once("myfunctions.php");

function download_all_link($text) {
	$u ="https://sourceforge.net/projects/smplayer/files/SMPlayer/0.8.3/";
	return "<a href=\"$u\"><b>$text</b></a>";
}

function download_src_link() {
	return create_link("smplayer-0.8.3.tar.bz2", 3201389 );
}

function download_smtube_link() {
	return create_link("smtube-1.5.tar.bz2", 311592 );
}

function download_windows_full_link($text, $button=false) {
	global $site;
	$filename = "smplayer-0.8.3-ps-win32.exe";
	$size = 16878472;

	if (!isset($text)) {
		return create_link($filename, $size );
	} else {
		if ($button) 
			return create_button_link($filename, $text);
		else
			return create_simple_link($filename, $text);
	}
}

function auto_download_button($text = "") {
	global $tr_lang;
	if ($text=="") $text = get_tr("Click here to download SMPlayer for free");

	if (is_win()) {
		$u = download_windows_full_link($text, true);
	} else {
		$u ="<a href=\"downloads.php?tr_lang=$tr_lang\" class=\"btn btn-success btn-large\">".
            "<i class=\"icon-download-alt icon-large\"></i> ".
			 get_tr($text) .
			 "</a>";
	}
	return $u;
}

function download_themes_src_link() {
	return create_link("smplayer-themes-20120919.tar.bz2", 2096375 );
}

function download_skins_src_link() {
	return create_link("smplayer-skins-20121029.tar.bz2", 373066 );
}

function download_codecs_link() {
	return "<a href=\"http://www.mediafire.com/?jzlj6iw0wls\"><b>smplayer_codecs_20071007.exe</b></a>";
}
?>
