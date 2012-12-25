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

function download_rpm_link() {
	return create_link("smplayer-0.6.2-rvm.i586.rpm", 1598452 );
}

function download_deb_link() {
	return create_link("smplayer_0.6.7_i386.deb", 1476630 );
}

function download_amd64deb_link() {
	return create_link("smplayer_0.6.7_amd64.deb", 1495604 );
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
			 get_tr($text) .
			 "</a>";
	}
	return $u;
}

function download_windows_lite_link() {
	return create_link("smplayer-0.8.0-webdl.exe", 9771579 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.8.0_without_mplayer.7z", 8392446 );
}

function download_windows_portable_link() {
	return create_link("smplayer-portable-0.8.0.7z", 14739897 );
}


function download_themes_src_link() {
	return create_link("smplayer-themes-20120919.tar.bz2", 2096375 );
}

function download_skins_src_link() {
	return create_link("smplayer-skins-20121029.tar.bz2", 373066 );
}

function download_themes_rpm_link() {
	return create_link("smplayer-themes-0.1.20-rvm.noarch.rpm", 2182975 );
}

function download_themes_deb_link() {
	return create_link("smplayer-themes_20120131_all.deb", 2007502 );
}

function download_themes_nonfree_src_link() {
	return create_link("smplayer-themes-nonfree-0.1.1.tar.bz2", 413478 );
}

function download_themes_nonfree_rpm_link() {
	return create_link("smplayer-themes-nonfree-0.1.1-rvm.noarch.rpm", 420472 );
}

function download_themes_nonfree_deb_link() {
	return create_link("smplayer-themes-nonfree_0.1.1_all.deb", 420498 );
}

function download_codecs_link() {
	return "<a href=\"http://www.mediafire.com/?jzlj6iw0wls\"><b>smplayer_codecs_20071007.exe</b></a>";
}

?>
