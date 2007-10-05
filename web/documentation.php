<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>SMPlayer - The S Media Player</title>
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

<div id="languages">
<div id="languages_links">
<ul>
<li><a href="#">Dutch</a> |&nbsp</li>
<li><a href="#">English</a> |&nbsp</li>
<li><a href="#">French</a> |&nbsp</li>
<li><a href="#">Spanish</a></li>
</ul>
</div>
</div>

<div id="header">
<br><br>
<span style="font-size: 26px"><a href="index.php">The SMPlayer Project</a></span>

<div id="navigation">
<div id="navigation_box">
<div id="header_links">
<ul>
<li><a href="index.php"><span>Main</a></span></li>
<li><a href="screenshots.php"><span>Screenshots</span></a></li>
<li><a href="downloads.php"><span>Downloads</span></a></li>
<li><a href="forums/index.php"><span>Forums</span></a></li>
<li><a href="http://sourceforge.net/tracker/?group_id=185512&atid=913573"><span>Bug Tracking</span></a></li>
<li><a href="http://sourceforge.net/tracker/?group_id=185512&atid=913576"><span>Feature Requests</span></a></li>
<li id="active_tab"><a href="documentation.php"><span id="text_black">Documentation</span></a></li>
</ul>
</div>
</div>
</div>

</div>

<!----------------------end header---------------------->

<!----------------------begin content---------------------->

<div id="content">
Documentation
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
