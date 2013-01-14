<?php
include_once("l10n.php");
include_once("site.php");

function print_header($title, $desc="") {
	global $tr_lang, $site;
?>
<!DOCTYPE html>
<?php echo "<html lang=\"$tr_lang\"\n";?>
<head>
<?php
if (1) {
	$main_title = get_tr("Media Player for Windows and Linux with built-in codecs and Youtube&trade; support");
	$description = get_tr("Free media player for Windows and Linux with built-in codecs that can play and download Youtube&trade; videos");
	$desc2 = get_tr("a free media player for Windows and Linux with built-in codecs that can play and download Youtube&trade; videos");
} else {
	$main_title = get_tr("Graphical User Interface (GUI) for MPlayer");
	$description = "Graphical user interface (GUI) for MPlayer, for Windows and Linux, with many ".
                   "additional features like the possibility to search and download Youtube videos.";
	$desc2 = "a graphical user interface (GUI) for MPlayer, for Windows and Linux, with many ".
             "additional features like the possibility to search and download Youtube videos.";
}
$main_title = "SMPlayer - ". $main_title;
if ($title != "") $main_title = $main_title ." - ". $title;
if ($desc != "") $description = $desc .", ". $desc2;
echo "<title>$main_title</title>\n";
echo "<meta name=\"Description\" content=\"$description\">\n";
echo "<link rel=\"canonical\" href=\"". basename( $_SERVER['PHP_SELF'] ) ."\" />\n"; 
?>
<meta charset="utf-8">
<meta name="Keywords" content="video player,media player,multimedia player,best free player,bestfreeplayer,smplayer,mplayer,mplayer2,umplayer,multimedia,player,youtube,player download,audio player,video,DVD,Windows,Linux,free,open source,free software,mkv,mp4,matroska,xvid,divx,mpeg,mpeg2,mpeg4,h264,x264">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-image-gallery.min.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="mystyle.css" rel="stylesheet">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<link rel="icon" type="image/png" href="images/icons/smplayer_icon16.png">
<?php include_once("analytics.php"); ?>
</head>
<?php
}

function header_print_link($name, $link, $active, $external=false, $last=false) {
	global $tr_lang;
	echo "<li";
	if ($active) echo " class=\"active\"";
	echo ">";
	echo "<a href=\"".$link;
	if (!$external) echo "?tr_lang=$tr_lang";
	echo "\">";
	echo $name;
	echo "</a>";
	echo "</li>";
	echo "\n";
}

function print_language_link($file, $name, $cod, $query, $last=false) {
	echo "<li><a href=\"".$file."?tr_lang=".$cod.$query."\">".$name."</a></li>\n";
}

function print_languages() {
	global $tr_lang, $site;

	$file = basename($_SERVER['SCRIPT_NAME']);
	$query =  $_SERVER['QUERY_STRING'];

	$query = preg_replace("/&tr_lang=\S\S/", "", $query);
	$query = preg_replace("/tr_lang=\S\S/", "", $query);
	$query = preg_replace("/^&/", "", $query);
	if ($query!="") $query = "&".$query;
	//echo "query: $query";

	print_language_link($file, "English", "en", $query);
	print_language_link($file, "Español", "es", $query);
	print_language_link($file, "日本語", "ja", $query);
	print_language_link($file, "中文", "zh", $query);
	print_language_link($file, "Português", "pt", $query);
	print_language_link($file, "Lietuvių", "lt",  $query);
	print_language_link($file, "Euskara", "eu",  $query);
	print_language_link($file, "Русский", "ru", $query);
	print_language_link($file, "Galego", "gl",  $query);

	//print_language_link($file, "Nederlands", "nl", $query);
	//print_language_link($file, "Italiano", "it", $query);
	//print_language_link($file, "Français", "fr", $query);
	//print_language_link($file, "Deutsch", "de", $query);
	//print_language_link($file, "Polski", "pl", $query);
	//print_language_link($file, "Română", "ro", $query);
	//print_language_link($file, "Українська", "uk", $query);
	//print_language_link($file, "Magyar", "hu", $query);
	//print_language_link($file, "Suomi", "fi", $query);
}

function print_menu($current=1) {
?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner"> 
		<div class="container"> 
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
			</a>
			<p class="brand">SMPlayer</p>
			<div class="nav-collapse collapse">
				<ul class="nav">
				<?php
				header_print_link(get_tr("Main"), "index.php", ($current==1));
				header_print_link(get_tr("Screenshots"), "screenshots.php", ($current==2));
				/* header_print_link(get_tr("Reviews"), "reviews.php", ($current==4)); */
				header_print_link(get_tr("FAQ"), "faq.php", ($current==5));
				header_print_link(get_tr("Downloads"), "downloads.php", ($current==3));
				?>
				</ul>

				<ul class="nav pull-right"> 
				<li class="dropdown"> 
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Select your language<b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
						<?php print_languages(); ?>
					</ul>
				</li>
				</ul>

			</div> <!-- nav-collapse -->
		</div> <!-- container -->
	</div> <!-- navbar-inner -->
</div> <!-- navbar -->
<?php
}
?>
