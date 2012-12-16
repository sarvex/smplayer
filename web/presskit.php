<?php
include_once("header.php");
print_header(get_tr("SMPlayer - Press Kit"));
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">
<h1><?php tr("Press Kit"); ?></h1>
<p><?php tr("Some images you can use in an article, blog, review..."); ?></p>

<h2><?php tr("Logos"); ?></h2>
<p>
<img src="press/smplayer_icon512.png">
<img src="press/smplayer_icon256.png">
<br>
<img src="press/smplayer_icon192.png">
<img src="press/smplayer_icon128.png">
<img src="press/smplayer_icon64.png">
<img src="press/smplayer_icon32.png">
<img src="press/smplayer_icon16.png">

<h2>E-Cover</h2>
<p>
<img src="press/box.jpg">

<h2><?php tr("Screenshots"); ?></h2>
<p>
<?php tr("Some screenshots, in English and Spanish"); echo ":"; ?>
<p>
<a href="press/SMPlayer_screenshots.zip"><b>SMPlayer_screenshots.zip</b></a>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
