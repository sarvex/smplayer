<?php
include_once("myfunctions.php");

function download_src_link() {
	return create_link("smplayer-0.6.5.1.tar.bz2", 1290836 );
}

function download_rpm_link() {
	return create_link("smplayer-0.6.2-rvm.i586.rpm", 1598452 );
}

function download_deb_link() {
	return create_link("smplayer_0.6.5_i386.deb", 2564190 );
}

function download_amd64deb_link() {
	return create_link("smplayer_0.6.5_amd64.deb", 2582376 );
}

/*
function download_windows_full_link() {
	return create_link("smplayer_0.6.0rc2_full.exe", 18489602 );
}
*/

function download_windows_lite_link() {
	return create_link("smplayer_0.6.4-2_setup.exe", 12760250 );
}

function download_windows_7z_link() {
	return create_link("smplayer-0.6.4_without_mplayer.7z", 7141652 );
}

function download_windows_portable_link() {
	return create_link("smplayer-portable-0.6.4-2.7z", 12255491 );
}


function download_themes_src_link() {
	return create_link("smplayer-themes-0.1.18.tar.bz2", 1895016 );
}

function download_themes_rpm_link() {
	return create_link("smplayer-themes-0.1.18-rvm.noarch.rpm", 1951299 );
}

function download_themes_deb_link() {
	return create_link("smplayer-themes_0.1.18_all.deb", 1913954 );
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
