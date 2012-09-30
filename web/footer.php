<footer>

<div class="row">
<div class="span3">
</div>

<div class="span5">
<table>
<tr>
<td colspan="2">
<h4><?php tr("Other links:"); ?></h4>
</td>
<tr>
<td>
<ul>
<li><a href="http://sourceforge.net/donate/index.php?group_id=185512"><?php tr("Donate"); ?></a></li>
<li><a href="http://smplayer.sourceforge.net/forum/"><?php tr("Forum"); ?></a></li>
<li><a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913573"><?php tr("Bug Tracking"); ?></a></li>
</td>
<td>
<li><a href="http://sourceforge.net/tracker/?group_id=185512&amp;atid=913576"><?php tr("Feature Requests"); ?></a></li>
<li><a href="http://smplayer.wiki.sourceforge.net/"><?php tr("Wiki"); ?></a></li>
<?php
if ($site=="sourceforge")
	echo "<li><a href=\"http://smplayer.berlios.de\">". get_tr("Mirror") ."</a></li>\n";
else
	echo "<li><a href=\"http://smplayer.sourceforge.net\">". get_tr("Mirror") ."</a></li>\n";
?>
</ul>
</td>
</tr>
</table>
</div>

<div class="span1"></div>

<div class="span3">
<br><br>
<a href="http://sourceforge.net/donate/index.php?group_id=185512"><img src="http://images.sourceforge.net/images/project-support.jpg" width="88" height="32" border="0" alt="Support This Project" /></a>

<br><br>
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
