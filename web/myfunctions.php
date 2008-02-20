<?php
function print_link($url, $bytes, $disabled = false) {
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
		echo "<b>$filename</b> ($s)";
	else
		echo "<a href=\"$url\"><b>$filename</b></a> ($s)";
}
?>
