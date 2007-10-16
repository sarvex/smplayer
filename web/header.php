<div id="header">
<br><br>
<span style="font-size: 26px">
<?php 
echo "<a href=\"index.php?lang=".$lang."\">";
tr("The SMPlayer Project");
echo "</a></span>";
?>

<div id="navigation">
<div id="navigation_box">
<div id="header_links">
<ul>
<?php
echo "<li id=\"active_tab\"><a href=\"index.php?lang=".$lang."\"><span id=\"text_black\">";
tr("Main");
echo "</a></span></li>\n";

echo "<li><a href=\"screenshots.php?lang=".$lang."\"><span>";
tr("Screenshots");
echo "</span></a></li>\n";

echo "<li><a href=\"downloads.php?lang=".$lang."\"><span>";
tr("Downloads");
echo "</span></a></li>\n";

echo "<li><a href=\"forums/index.php\"><span>";
tr("Forums");
echo "</span></a></li>\n";

echo "<li><a href=\"http://sourceforge.net/tracker/?group_id=185512&atid=913573\"><span>";
tr("Bug Tracking");
echo "</span></a></li>\n";

echo "<li><a href=\"http://sourceforge.net/tracker/?group_id=185512&atid=913576\"><span>";
tr("Feature Requests");
echo "</span></a></li>\n";

echo "<li><a href=\"documentation.php?lang=".$tr_lang."\"><span>";
tr("Documentation");
echo "</span></a></li>\n";
?>
</ul>
</div>
</div>
</div>

</div>
