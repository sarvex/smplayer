<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title><?php tr("SMPlayer - Downloads"); ?></title>
  <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">
  <link href="base.css" rel="stylesheet" title="base style" type="text/css">
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
include_once("myfunctions.php");

echo "<h1>".get_tr("Stable version")."</h1>";
echo "<h2>".get_tr("Windows")."</h2>";
?>
<!-- WINDOWS -->
<p>
<table>
<tr>
<td><img src="iconos/kpackage.png"></td>
<td><b>
<?php 
tr("Full package with installer:"); echo " ";
include("download_windows.php"); 
?>
</b><br>
<?php
tr("This package contains everything needed to run smplayer: Qt shared 
libraries, translation files, icon themes... It also includes a mplayer 
build. The version included is %1 from <a href=%2>CCCP</a>.",
"<i>1.0rc2 (svn-r24722)</i>",
"\"http://www.cccp-project.net/smf/index.php?topic=811.0\"");
echo "<br>";
tr("<b>Note:</b> the first time the lib SSA/ASS or fontconfig is used, mplayer
will create a font cache. This process takes some seconds and meanwhile 
<b>smplayer may look hung. Don't worry, just wait.</b>");
echo "<br>";
tr("<b>Note 2:</b> If you had already installed a previous version, it's highly
recommended that you uninstall the old package before installing the new one.");
?>
</td>
</tr>
</table>

<!-- LINUX -->
<?php
echo "<h2>".get_tr("Linux")."</h2>";
//echo "<h3>".get_tr("smplayer")."</h3>";
?>
<p>
<table>
<tr>
<td><img src="iconos/package.png"></td>
<td>
<?php
include("download_source.php");
echo "<br>";
tr("Read the file Install.txt included in the package to know how compile it."); 
?>
</td>
</tr>

<tr>
<td><img src="iconos/suse.png"></td>
<td>
<?php
include("download_suse.php");
echo "<br>";
tr("Compiled on OpenSuSE 10.2. Requires: libqt4 and mplayer (at least 1.0rc1, 
recommended 1.0rc2 or svn).");
?>
</td>
</tr>

<tr>
<td><img src="iconos/ubuntu.png"></td>
<td>
<?php
include("download_ubuntu.php");
echo "<br>";
tr("Compiled on kubuntu 7.04 (should work in ubuntu too)."); 
echo "<br>";
echo "<b>"; tr("Suggested package:"); echo "</b><br>";
tr("The version of mplayer included in Ubuntu is very old (%1). SMPlayer 
has support for some of the new features of mplayer, so a newer version 
is highly recommended. You can download here %2 (from %3).", "1.0rc1", 
"<b><a href=\"http://downloads.sourceforge.net/smplayer/mplayer_1.0rc2svn25873_i386.deb\">MPlayer SVN r25873</a></b>",
"2008-01-27");
?>
</td>
</tr>
</table>

<?php
echo "<h3>".get_tr("Icon Themes:")."</h3>";
?>
<p>
<table>
<tr>
<td><img src="iconos/package.png"></td>
<td>
<?php 
include("download_themes.php");
echo "<br>";
tr("Optional package which provides some icon themes."); 
?>
</td>
</tr>

<tr>
<td><img src="iconos/suse.png"></td>
<td>
<?php
include("download_themes_rpm.php"); 
?>
</td>
</tr>

<tr>
<td><img src="iconos/ubuntu.png"></td>
<td>
<?php
include("download_themes_deb.php");
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
