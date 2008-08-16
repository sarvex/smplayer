<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title><?php tr("SMPlayer - Downloads"); ?></title>
  <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">
  <link href="base.css" rel="stylesheet" title="base style" type="text/css">
  <link rel="icon" type="image/png" href="images/icons/smplayer_icon16.png">
<?php 
$use_forum = 0;
if ($use_forum) {
	define('PUN_ROOT', 'forums/');
	require PUN_ROOT.'include/common.php';
	if (isset($_COOKIE['punbb_cookie']))
	list($cookie['user_id'], $cookie['password_hash']) = @unserialize($_COOKIE['punbb_cookie']);
}
?>
 </head>
 <body>

<div id="container">

<!----------------------header---------------------->
<?php
include("header.php");
header_set_section("downloads");
?>
<!----------------------end header---------------------->

<!----------------------begin content---------------------->

<div id="content">
<?php
include_once("download_links.php");

echo "<h1>".get_tr("Stable version")."</h1>";
echo "<h2>".get_tr("Windows")."</h2>";
?>
<!-- WINDOWS -->
<p>
<table>

<tr>
<td><img src="iconos/kpackage.png"></td>
<td>
<?php 
echo "<b>"; tr("Package with installer:"); echo "</b> ";
echo download_windows_lite_link(); 
?>
<br>
<?php
tr("This package contains everything needed to run smplayer: shared 
libraries, translation files, icon themes and a mplayer 
build (the version included is %1).","<i>SVN r27130</i>"); echo " ";
/*
tr("The package includes also the extra codecs for mplayer, which will allow 
to play some additional formats (like rmvb files). These codecs are to be
used by mplayer only and they will be installed in the same folder, so 
they can't cause any conflict with other codecs you may have installed.");
echo "<br><b><i>";
tr("Package intended for those who want to be sure they'll be able to
play (almost) anything.");
echo"</i></b>";

echo "<br>";
echo "<b>";
tr("Note: this package has been removed, Sourceforge doesn't allow
to host closed source binaries (the codecs)");
echo "<b>";
*/
?>
</td>
</tr>

<!-- codecs -->

<tr>
<td><img src="iconos/kpackage.png"></td>
<td>
<?php 
echo "<b>"; tr("Additional codecs:"); echo "</b> ";
echo download_codecs_link(); 
?>
<br>
<?php

tr("This package adds support for codecs that are not yet implemented
natively in mplayer, like newer RealVideo variants and a lot of uncommon
formats. Note that they are not necessary to play most common formats
like DVDs, MPEG-1/2/4, etc.");
echo " ";
tr("These codecs are to be used by mplayer only and they will be installed 
in the same folder, so they can't cause any conflict with other codecs you 
may have installed.");
echo " ";
tr("If you prefer a zip file, you can get it at 
the <a href=%1>mplayer site</a> (%2).",
"\"http://www.mplayerhq.hu/design7/dload.html\"", 
"windows-essential-20071007.zip");
?>
</td>
</tr>

<tr>
<td><img src="iconos/package.png"></td>
<td>
<?php
echo download_windows_7z_link();
echo "<br>";
tr("Package (without installer) which includes smplayer, shared libraries,
translations and icon themes. It doesn't include mplayer."); 
echo " <b>";
echo tr("This package is for advanced users only!");
echo "</b>";
//echo "<br>";
//echo "<b><i>";
/*
tr("Package for those who don't like installers and/or want to use another 
mplayer build.");
*/
//echo"</i></b>";
?>
</td>
</tr>


<!-- Portable Edition -->

<tr>
<td><img src="iconos/package.png"></td>
<td>
<?php
echo download_windows_portable_link();
echo "<br>";
tr("Portable version of SMPlayer. It can be run from external devices, like 
USB flash drives. It doesn't require installation, just uncompress the 
package wherever you want and double click to run it.");
echo " ";
tr("The package also includes the icon themes, translations and a 
MPlayer build.");
echo " ";
tr("Note: 7z files can be uncompressed with <a href=%1>7-Zip</a>.",
"\"http://www.7-zip.org/\"");
?>
</td>
</tr>


</table>

<!-- LINUX -->
<?php
echo "<h2>".get_tr("Linux")."</h2>";
?>
<p>
<table>
<tr>
<td><img src="iconos/package.png"></td>
<td>
<?php
echo download_src_link();
echo "<br>";
tr("Read the file Install.txt included in the package to know how compile it."); 
?>
</td>
</tr>

<tr>
<td><img src="iconos/suse.png"></td>
<td>
<?php
echo download_rpm_link();
echo "<br>";
tr("Compiled on OpenSuSE 10.2. Requires: libqt4 and mplayer.");
?>
</td>
</tr>

<tr>
<td><img src="iconos/ubuntu.png"></td>
<td>
<?php
echo download_deb_link();
echo "<br>";
tr("Compiled on Ubuntu 7.04."); 
echo "<br>";

echo download_amd64deb_link();
echo "<br>";
tr("Package for AMD64. Compiled on Ubuntu 8.04."); 
//echo "<br>";
?>
</td>
</tr>

<tr>
<td><img src="iconos/ubuntu.png"></td>
<td>
<?php
echo "<b>"; tr("Suggested package:"); echo "</b><br>";
tr("The version of mplayer included in Ubuntu is a little bit old (%1). SMPlayer 
has support for some of the new features of mplayer, so a newer version 
is highly recommended. You can download here %2 (from %3).", "1.0rc2", 
"<b><a href=\"http://downloads.sourceforge.net/smplayer/mplayer_1.0rc2svn25873_i386.deb\">MPlayer SVN r25873</a></b>",
"2008-01-27");
?>
</td>
</tr>
</table>

<?php
echo "<h3>".get_tr("Icon Themes:")."</h3>";
tr("Optional packages which provide some icon themes."); 
?>
<p>
<table>
<tr>
<td><img src="iconos/package.png"></td>
<td>
<?php 
echo download_themes_src_link();
echo "<br>";
echo download_themes_nonfree_src_link();
?>
</td>
</tr>

<tr>
<td><img src="iconos/suse.png"></td>
<td>
<?php
echo download_themes_rpm_link();
echo "<br>";
echo download_themes_nonfree_rpm_link(); 
?>
</td>
</tr>

<tr>
<td><img src="iconos/ubuntu.png"></td>
<td>
<?php
echo download_themes_deb_link();
echo "<br>";
echo download_themes_nonfree_deb_link();
?>
</td>
</tr>
</table>


<!-- Additional packages -->

<?php
echo "<h2>".get_tr("Additional packages")."</h2>";
tr("There are several additional packages for advanced users:
<a href=%1>See sourceforge download page</a>.",
"\"http://sourceforge.net/project/showfiles.php?group_id=185512\"");
?>

<!-- Contributed packages -->
<?php
echo "<h2>".get_tr("Contributed packages")."</h2>";
tr("There are available packages for other distros, created
by other people. <a href=%1>Click here</a> to see them.",
"\"http://smplayer.wiki.sourceforge.net/Contributed+Packages\"");
?>

<?php
echo "<h2>".get_tr("Related Project")."</h2>";
echo "<b><a href=\"http://mulder.dummwiedeutsch.de/home/?page=projects#mplayer\">";
echo "MPlayer for Windows</a></b> ".get_tr("by MuldeR")."<br>";
tr("This package contains a very recent version of SMPlayer (often taken from
the SVN repository) as well as a recent version of MPlayer. It also provides
its own installer, mplayer builds optimized for several processors and
binary codecs.");
?>

<!-- Unstable releases -->

<hr>

<?php
echo "<h1>".get_tr("Unstable releases")."</h1>";
//echo "&lt;Here there could be a list of unstable packages&gt;<p>";
tr("You can get packages directly taken from the SVN (source code and
Windows updates), <a href=%1><b>here</b></a>.",
"\"http://smplayer.wiki.sourceforge.net/Unstable+releases\"");
?>

</div>

<!----------------------end content---------------------->

<!----------------------begin footer---------------------->

<?php
include("footer.php");
?>

<!----------------------end footer---------------------->

</div>

 </body>
</html>
