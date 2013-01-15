<footer>

<div class="row">
<div class="span1">
</div>

<div class="span9">
<p>
<b><?php tr("Other links:");?></b>
<div class="row-fluid">
<div class="span3">
<ul class="icons">
<li><i class="icon-exclamation-sign"></i>
<?php echo "<a href=\"latest.php?tr_lang=$tr_lang\">". get_tr("Latest changes") ."</a>"; ?></li>
<li><i class="icon-user"></i>
<a href="http://smplayer.sourceforge.net/forum/"><?php tr("Forum"); ?></a></li>
<!-- <li><?php echo "<a href=\"faq.php?tr_lang=$tr_lang\">". get_tr("FAQ") ."</a>"; ?></li> -->
<li><i class="icon-comments"></i>
<?php echo "<a href=\"reviews.php?tr_lang=$tr_lang\">". get_tr("Reviews") ."</a>"; ?></li>
<li><i class="icon-circle"></i>
<?php echo "<a href=\"presskit.php?tr_lang=$tr_lang\">". get_tr("Press Kit") ."</a>"; ?></li>
</ul>
</div> <!-- span3 -->

<div class="span3">
<ul class="icons">
<li><i class="icon-circle"></i>
<a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913573"><?php tr("Bug Tracking"); ?></a></li>
<li><i class="icon-circle"></i>
<a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913576"><?php tr("Feature Requests"); ?></a></li>
<li><i class="icon-circle"></i>
<?php echo "<a href=\"smtube.php?tr_lang=$tr_lang\">SMTube</a>"; ?></li>
<!-- <li><?php echo "<a href=\"umplayer.php?tr_lang=$tr_lang\">UMPlayer</a>"; ?></li> -->
<li><i class="icon-circle"></i>
<a href="http://smplayer.info/blog/"><?php tr("Blog"); ?></a></li>
</ul>
</div> <!-- span3 -->

<div class="span4">
<ul class="icons">
<li><i class="icon-circle"></i>
<?php
if ($site=="sourceforge")
	echo "<a href=\"http://smplayer.berlios.de\">". get_tr("Mirror") ."</a>\n";
else
	echo "<a href=\"http://smplayer.info\">". get_tr("Mirror") ."</a>\n";
?>
</li>
<li><i class="icon-envelope"></i>
<?php echo "<a href=\"contact.php?tr_lang=$tr_lang\">". get_tr("Contact us") ."</a>"; ?></li>
<!-- <li><a href="http://smplayer.wiki.sourceforge.net/"><?php tr("Wiki"); ?></a></li> -->
<li><i class="icon-circle"></i>
<a target="_blank" href="http://code.google.com/p/mplayer-for-windows/"><?php tr("MPlayer builds for Windows"); ?></a></li>
<li><i class="icon-twitter"></i>
<?php
echo "<a target=\"_blank\" href=\"https://twitter.com/smplayer_dev\" title=\"" .get_tr("Follow us on Twitter") ."\">Twitter</a>\n";
?>
</li>
</div> <!-- span3 -->

</div> <!-- span9 -->
</div> <!-- row -->

<div class="span2">
<div class="row-fluid">
<br>
<?php
include("site_logo.php");
?>
</div> <!-- row -->
</div> <!-- span2 -->

</div> <!-- row -->

</footer>

<?php include_once("scripts.php"); ?>
