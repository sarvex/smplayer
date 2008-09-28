<?php
include_once("myfunctions.php");

function download_src_link() {
	return create_link("smplayer-0.6.3.tar.bz2", 1157827 );
}

function download_rpm_link() {
	return create_link("smplayer-0.6.2-rvm.i586.rpm", 1598452 );
}

function download_deb_link() {
	return create_link("smplayer_0.6.3_i386.deb", 2353424 );
}

function download_amd64deb_link() {
	return create_link("smplayer_0.6.3_amd64.deb", 2369010 );
}

/*
function download_windows_full_link() {
	return create_link("smplayer_0.6.0rc2_full.exe", 18489602 );
}
*/

function download_windows_lite_link() {
	return create_link("smplayer_0.6.3.1_setup.exe", 12708384 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.6.3.1_without_mplayer.7z", 7102050 );
}

function download_windows_portable_link() {
	return create_link("smplayer-portable_0.6.3.1.7z", 11668743 );
}


function download_themes_src_link() {
	return create_link("smplayer-themes-0.1.17.tar.bz2", 1894960 );
}

function download_themes_rpm_link() {
	return create_link("smplayer-themes-0.1.17-rvm.noarch.rpm", 1946845 );
}

function download_themes_deb_link() {
	return create_link("smplayer-themes_0.1.17_all.deb", 1909388 );
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
