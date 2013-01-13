<?php
include_once("header.php");
print_header(get_tr("Press Kit"), get_tr("Press kit for SMPlayer"));
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">
<h1><?php tr("Press Kit"); ?></h1>
<p><?php tr("Some images you can use in an article, blog, review..."); ?></p>

<h2><?php tr("Logos"); ?></h2>
<p>
<img src="press/smplayer_icon256.png">
<br>
<a class="btn btn-success btn-large" href="press/smplayer.svg"><img src="images/arrow-down.png"> <b>smplayer.svg</b></a>

<h2>E-Cover</h2>
<p>
<img src="press/box.png">

<h2><?php tr("Screenshots"); ?></h2>
<p>
<?php tr("Some screenshots, in English and Spanish"); echo ":"; ?>
<p>
<a class="btn btn-success btn-large" href="press/SMPlayer_screenshots.zip"><img src="images/arrow-down.png"> <b>SMPlayer_screenshots.zip</b></a>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
