<?php
include_once("header.php");
print_header();
echo "<body>\n";
print_menu(4);
?>

<div class="container-fluid">
<h1><?php tr("Reviews"); ?></h1>

<?php
include("media_reviews.php");

echo "<h3>". get_tr("Media Reviews") . "</h3>\n";
print_media_reviews(false);
include("user_reviews.php");
?>

<p>
<b>
<?php
tr("If you like SMPlayer please feel free to rate or review SMPlayer in some of these sites:");
?>
<br>
&bull; <a href="http://www.softpedia.com/get/Multimedia/Video/Video-Players/SMPlayer.shtml">Softpedia</a>
&bull; <a href="http://smplayer.en.softonic.com/">Softonic</a>
&bull; <a href="http://download.cnet.com/SMPlayer/3000-2139_4-10645077.html?tag=mncol%3b1">CNET</a>
&bull; <a href="http://sourceforge.net/projects/smplayer/">Sourceforge</a>
</b>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
