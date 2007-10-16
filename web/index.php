<?php include_once("l10n.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>SMPlayer - The SMPlayer Project</title>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
  <meta name="Description" content="smplayer, multiplatform front-end for mplayer">
  <meta name="Keywords" content="smplayer, mplayer, multimedia, player">
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

<div id="languages">
<div id="languages_links">
<ul>
<li><a href="#">Dutch</a> |&nbsp</li>
<li><a href="#">English</a> |&nbsp</li>
<li><a href="#">French</a> |&nbsp</li>
<li><a href="index.php?lang=es">Spanish</a></li>
</ul>
</div>
</div>

<?php
include("header.php");
?>

<!----------------------end header---------------------->

<!----------------------begin content---------------------->

<div id="content">
<?php
include("info.php");
?>
<div id="news">
<?php
include("news.php");
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
