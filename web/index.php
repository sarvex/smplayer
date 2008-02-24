<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title><?php tr("SMPlayer - General Info"); ?></title>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
  <meta name="Description" content="smplayer, multiplatform front-end for mplayer">
  <meta name="Keywords" content="smplayer, mplayer, multimedia, player">
  <link href="base.css" rel="stylesheet" title="base style" type="text/css">
<?php 
include_once("site.php");
if ($site == "sourceforge") 
	$use_forum = $_GET['use_forum'];
else
	$use_forum = false;

if (!isset($use_forum)) $use_forum = 1;
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
header_set_section("main");
?>
<!----------------------end header---------------------->

<!----------------------begin content---------------------->

<div id="content">
<?php
include("info.php");
?>
<div id="news">
<?php
if ($use_forum) {
	//include("news.php");
	include_once("print_post.php");

	// Message id of the post in the forum for "Version 0.6.0rc1 released"
	print_post( intval(get_tr("849")) );
}
?>
</div>
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
