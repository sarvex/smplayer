<?php
include_once("myfunctions.php");

function download_src_link() {
	return create_link("smplayer-0.6.0final.tar.bz2", 1016544 );
}

function download_rpm_link() {
	return create_link("smplayer-0.6.0final-rvm.i586.rpm", 1424919 );
}

function download_deb_link() {
	return create_link("smplayer_0.6.0final_i386.deb", 1946210 );
}

function download_amd64deb_link() {
	return create_link("smplayer_0.6.0final_amd64.deb", 1961454 );
}

function download_windows_full_link() {
	return create_link("smplayer_0.6.0rc2_full.exe", 18489602 );
}

function download_windows_lite_link() {
	return create_link("smplayer_0.6.0final_setup.exe", 11617921 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.6.0_without_mplayer.7z", 5997125 );
}


function download_themes_src_link() {
	return create_link("smplayer-themes-0.1.15.tar.bz2", 1749140 );
}

function download_themes_rpm_link() {
	return create_link("smplayer-themes-0.1.15-rvm.noarch.rpm", 1789561 );
}

function download_themes_deb_link() {
	return create_link("smplayer-themes_0.1.15_all.deb", 1762904 );
}

function download_themes_nonfree_src_link() {
	return create_link("smplayer-themes-nonfree-0.1.0.tar.bz2", 412295 );
}

function download_themes_nonfree_rpm_link() {
	return create_link("smplayer-themes-nonfree-0.1.0-rvm.noarch.rpm", 419370 );
}

function download_themes_nonfree_deb_link() {
	return create_link("smplayer-themes-nonfree_0.1.0_all.deb", 419272 );
}

function download_codecs_link() {
	return "<a href=\"http://www.mediafire.com/?jzlj6iw0wls\"><b>smplayer_codecs_20071007.exe</b></a>";
}

?>
