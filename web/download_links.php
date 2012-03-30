<?php
include_once("myfunctions.php");

function download_src_link() {
	return create_link("smplayer-0.7.1.tar.bz2", 2788634 );
}

function download_smtube_link() {
	return create_link("smtube-1.1.tar.bz2", 296345 );
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
	return create_link("smplayer-0.7.1-win32.exe", 15868152 );
}

function download_windows_lite_link() {
	return create_link("smplayer-0.7.1-webdl.exe", 9597935 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.7.1_without_mplayer.7z", 8376602 );
}

function download_windows_portable_link() {
	return create_link("smplayer-portable-0.7.1.7z", 14303132 );
}


function download_themes_src_link() {
	return create_link("smplayer-themes-20120131.tar.gz", 2014369 );
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
