<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title><?php tr("SMPlayer - Downloads"); ?></title>
  <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">
  <link href="base.css" rel="stylesheet" title="base style" type="text/css">
<?php define('PUN_ROOT', 'forums/');
require PUN_ROOT.'include/common.php';
if (isset($_COOKIE['punbb_cookie']))
list($cookie['user_id'], $cookie['password_hash']) = @unserialize($_COOKIE['punbb_cookie']);
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
"<i>svn-r23855</i>",
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
echo "<h3>".get_tr("Source")."</h3>";
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
<td><img src="iconos/package.png"></td>
<td>
<?php 
include("download_themes.php");
echo "<br>";
tr("Optional package which provides some icon themes."); 
?>
</td>
</tr>
</table>

<?php echo "<h3>".get_tr("Binaries")."</h3>"; ?>
<p>
<table>

<tr>
<td><img src="iconos/suse.png"></td>
<td>
<?php
include("download_suse.php");
echo "<br>";
tr("Compiled on OpenSuSE 10.2. Requires: libqt4 and mplayer (at least 1.0rc1, 
recommended 1.0rc2 or svn).");
echo "<br>";
include("download_themes_rpm.php"); 
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
include("download_themes_deb.php");
?>
</td>
</tr>
</table>


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
