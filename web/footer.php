<footer>

<div class="row">
<div class="span1">
</div>

<div class="span9">
<p>
<b><?php tr("Other links:");?></b>
<table class"table">
<tr>
<td>
<ul>
<li><?php echo "<a href=\"latest.php?tr_lang=$tr_lang\">". get_tr("Latest changes") ."</a>"; ?></li>
<li><a href="http://smplayer.info/forum/"><?php tr("Forum"); ?></a></li>
<li><?php echo "<a href=\"faq.php?tr_lang=$tr_lang\">". get_tr("FAQ") ."</a>"; ?></li>
<li><?php echo "<a href=\"presskit.php?tr_lang=$tr_lang\">". get_tr("Press Kit") ."</a>"; ?></li>
</ul>
</td>

<td>
<ul>
<li><a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913573"><?php tr("Bug Tracking"); ?></a></li>
<li><a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913576"><?php tr("Feature Requests"); ?></a></li>
<li><?php echo "<a href=\"smtube.php?tr_lang=$tr_lang\">SMTube</a>"; ?></li>
<!-- <li><?php echo "<a href=\"umplayer.php?tr_lang=$tr_lang\">UMPlayer</a>"; ?></li> -->
<li><a href="http://smplayer.info/blog/"><?php tr("Blog"); ?></a></li>
</ul>
</td>

<td>
<ul>
<li>
<?php
if ($site=="sourceforge")
	echo "<a href=\"http://smplayer.berlios.de\">". get_tr("Mirror") ."</a>\n";
else
	echo "<a href=\"http://smplayer.info\">". get_tr("Mirror") ."</a>\n";
?>
</li>
<li><?php echo "<a href=\"contact.php?tr_lang=$tr_lang\">". get_tr("Contact us") ."</a>"; ?></li>
<!-- <li><a href="http://smplayer.wiki.sourceforge.net/"><?php tr("Wiki"); ?></a></li> -->
<li><a target="_blank" href="http://code.google.com/p/mplayer-for-windows/"><?php tr("MPlayer builds for Windows"); ?></a></li>
<li>
<?php
echo "<a target=\"_blank\" href=\"https://twitter.com/smplayer_dev\">Twitter<img src=\"images/twitter.png\" title=\"" .get_tr("Follow us on Twitter") ."\"></a>\n";
?>
</li>
</td>
</tr>
</table>
</p>
</div>

<div class="span2">
<p>
<table class"table">
<tr>
<td>
<?php
include("site_logo.php");
?>
</td>
</tr>
</table>
</div>

</div> <!-- row -->

</footer>

<?php include_once("scripts.php"); ?>
