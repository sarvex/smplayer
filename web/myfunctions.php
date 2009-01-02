<?php

include_once("site.php");

function get_link($url, $bytes, $disabled = false) {
	$u = parse_url($url);
	$filename = basename($u['path']);

	if ($bytes > (1024*1024)) {
		$s = round(($bytes / (1024*1024)),2) . " MB";
	} else
	if ($bytes > 1024) {
		$s = round(($bytes / 1024), 0) . " KB";
	} else {
		$s = $bytes . " bytes";
	}

	if ($disabled)
		return "<b>$filename</b> ($s)";
	else
		return "<a href=\"$url\"><b>$filename</b></a> ($s)";
}

function print_link($url, $bytes, $disabled = false) {
	echo get_link($url, $bytes, $disable);
}

function create_link($filename, $bytes) {
	global $site;

//	if ($site == "berlios")
//		return get_link("http://prdownload.berlios.de/smplayer/$filename", $bytes);
//	else
		return get_link("http://downloads.sourceforge.net/smplayer/$filename", $bytes);
}

?>
