<footer>

<div class="row">
<div class="span1">
</div>

<div class="span9">
<p>
<b><?php tr("Other links:");?></b>
&bull; <a href="http://sourceforge.net/donate/index.php?group_id=185512"><?php tr("Donate"); ?></a> &nbsp;
&bull; <?php echo "<a href=\"smtube.php?tr_lang=$tr_lang\">SMTube</a>"; ?> &nbsp;
&bull; <a href="http://smplayer.sourceforge.net/forum/"><?php tr("Forum"); ?></a> &nbsp;
&bull; <a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913573"><?php tr("Bug Tracking"); ?></a> &nbsp;
&bull; <a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913576"><?php tr("Feature Requests"); ?></a> &nbsp;
&bull; <a href="http://smplayer.wiki.sourceforge.net/"><?php tr("Wiki"); ?></a> &nbsp;
&bull;
<?php
if ($site=="sourceforge")
	echo "<a href=\"http://smplayer.berlios.de\">". get_tr("Mirror") ."</a>\n";
else
	echo "<a href=\"http://smplayer.sourceforge.net\">". get_tr("Mirror") ."</a>\n";
?>
&nbsp;
</p>
</div>

<div class="span1">
<a href="http://sourceforge.net/donate/index.php?group_id=185512"><img src="http://images.sourceforge.net/images/project-support.jpg" width="88" height="32" border="0" alt="Support This Project" /></a>
</div>

<div class="span1">
<?php
include("site_logo.php");
?>
</div>

</div> <!-- row -->

<div class="row">
<center><b>&copy The SMPlayer Project</b></center>
</div> <!-- row -->

</footer>

<?php include_once("scripts.php"); ?>
