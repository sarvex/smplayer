<?php
include_once("myfunctions.php");

function download_src_link() {
	return create_link("smplayer-0.6.0rc3.tar.bz2", 1011857 );
}

function download_rpm_link() {
	return create_link("smplayer-0.6.0rc3-suse10.2.i586.rpm", 1369394 );
}

function download_deb_link() {
	return create_link("smplayer_0.6.0rc3_i386.deb", 1871970 );
}

function download_windows_full_link() {
	return create_link("smplayer_0.6.0rc2_full.exe", 18489602 );
}

function download_windows_lite_link() {
	return create_link("smplayer_0.6.0rc2_lite.exe", 11621015 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.6.0rc2_without_mplayer.7z", 5813561 );
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

function download_codecs_link() {
	return "<a href=\"http://www.mediafire.com/?jzlj6iw0wls\"><b>smplayer_codecs_20071007.exe</b></a>";
}

?>
