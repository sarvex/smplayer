<?php
include_once("myfunctions.php");

function download_src_link() {
	return create_link("smplayer-0.6.9.tar.bz2", 1723032 );
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

function download_windows_full_link() {
	return create_link("smplayer-0.6.9-win32.exe", 14838814 );
}

function download_windows_lite_link() {
	return create_link("smplayer-0.6.9-win32-webdl.exe", 9108627 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.6.9_without_mplayer.7z", 8367880 );
}

function download_windows_portable_link() {
	return create_link("smplayer-portable-0.6.9.7z", 13970870 );
}


function download_themes_src_link() {
	return create_link("smplayer-themes-0.1.20.tar.bz2", 2203931 );
}

function download_themes_rpm_link() {
	return create_link("smplayer-themes-0.1.20-rvm.noarch.rpm", 2182975 );
}

function download_themes_deb_link() {
	return create_link("smplayer-themes_0.1.20_all.deb", 2240068 );
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
