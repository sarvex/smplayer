<?php
include_once("myfunctions.php");

function download_src_link() {
	return create_link("smplayer-0.6.8.tar.bz2", 1670580 );
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
	return create_link("smplayer_0.6.7_setup.exe", 13694588 );
}

function download_windows_lite_link() {
	return create_link("smplayer-0.6.8-win32-webdl.exe", 8874999 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.6.8_without_mplayer.7z", 7846038 );
}

function download_windows_portable_link() {
	return create_link("smplayer-portable-0.6.7.7z", 12627891 );
}


function download_themes_src_link() {
	return create_link("smplayer-themes-0.1.19.tar.bz2", 1896314 );
}

function download_themes_rpm_link() {
	return create_link("smplayer-themes-0.1.18-rvm.noarch.rpm", 1951299 );
}

function download_themes_deb_link() {
	return create_link("smplayer-themes_0.1.19_all.deb", 1914972 );
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
