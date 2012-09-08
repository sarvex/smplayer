<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title><?php tr("SMPlayer - Downloads"); ?></title>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8">
<link href="base.css" rel="stylesheet" title="base style" type="text/css">
<link rel="icon" type="image/png" href="images/icons/smplayer_icon16.png">
</head>
<body>

<div id="sm_container">

<!-- header -->
<?php
include("header.php");
print_header();
?>
<!-- end header -->

<!-- begin content -->

<div id="sm_content">
<?php
include_once("download_links.php");

echo "<h1>".get_tr("Stable version")."</h1>";
echo "<h2>".get_tr("Windows")."</h2>";
?>
<!-- WINDOWS -->
<p>
<table>

<tr>
<td><img src="iconos/kpackage.png" alt="*"></td>
<td>
<?php 
echo download_windows_full_link(get_tr("Click here to get the full package"));
?>
<br>
<?php
tr("This package contains smplayer, themes, translations, mplayer %1, 
and the YouTube browser (smtube).","<i>r34835</i>");
?>
</td>
</tr>

<tr>
<td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
tr("There are available other packages for advanced users, %1.", download_all_link(get_tr("here")));
?>
</td></tr>

</table>

<!-- LINUX -->
<?php
echo "<h2>".get_tr("Linux")."</h2>";
?>
<p>
<table>
<tr>
<td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
echo download_src_link();
echo "<br>";
tr("Read the file Install.txt included in the package to know how compile it."); 
?>
</td>
</tr>

<tr>
<td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
echo download_smtube_link();
echo "<br>";
tr("Allows to play and download videos from YouTube. Source code."); 
?>
</td>
</tr>

<tr>
<td><img src="iconos/ubuntu.png" alt="*"></td>
<td>
<?php
echo "<b>"; tr("Packages for Ubuntu:"); echo "</b><br>";
tr("To install smplayer, just run these commands in a terminal:");
?>
<pre>
sudo add-apt-repository ppa:rvm/smplayer
sudo apt-get update
sudo apt-get install smplayer smtube
</pre>
</td>
</tr>

<tr><td><img src="iconos/package.png" alt="*"></td>
<td>
<?php
echo "<a href=\"https://sourceforge.net/apps/mediawiki/smplayer/index.php?title=Contributed_Packages\">" .
     "<b>". get_tr("Contributed packages for other distros") . "</b></a>";
?>
</td>
</tr>
</table>

</div>

<!-- end content -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->
</div>

</body>
</html>
