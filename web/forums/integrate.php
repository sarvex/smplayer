<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>Fucmnack :: Home</title>
  <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=ISO-8859-1">
  <link href="base.css" rel="stylesheet" title="base style" type="text/css">
<?php define('PUN_ROOT', './forums/');
require PUN_ROOT.'include/common.php';?>
<?php if (isset($_COOKIE['punbb_cookie']))
    list($cookie['user_id'], $cookie['password_hash']) = @unserialize($_COOKIE['punbb_cookie']);?>
 </head>
 <body>

<div id="container">

<!----------------------header---------------------->

<?php
include("header.php");
include("forums/login_frontpage.php");
?>

<!----------------------end header---------------------->

<!----------------------begin menu_left---------------------->

<div id="menu_left">
Main<br><br>

Anime Awards<br><br>

Sponsors<br><br>

Affiliates

</div>

<!----------------------end menu_left---------------------->

<!----------------------begin content---------------------->

<div id="content">
Fucmnack
<br>
<?php
include("news.php");
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
