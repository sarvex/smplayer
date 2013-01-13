<?php
include_once("header.php");
print_header(get_tr("Contact us"), get_tr("Contact and copyright info for SMPlayer"));
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">
<h1><?php tr("Contact us"); ?></h1>
<p>
<?php
tr("You can send your suggestions, patches, translations or whatever regarding 
smplayer, to %1", "<b>Ricardo Villalba</b> &lt;smplayer.dev at gmail dot com&gt;");
echo "<br>";
tr("You can write in English or Spanish.");
?>

<h2><?php tr("Support"); ?></h2>
<p>
<?php
tr("You can get help in our %1.", "<a href=\"http://smplayer.sourceforge.net/forum/\">". get_tr("forum") ."</a>");
echo "<br>";
tr("If you find bugs in smplayer you can report them in our %1.", 
"<a href=\"http://sourceforge.net/tracker/?group_id=185512&atid=913573\">". get_tr("bug tracker") ."</a>");
echo "<br>";
tr("You can request new features in our %1.",
"<a href=\"http://sourceforge.net/tracker/?group_id=185512&atid=913576\">". get_tr("request tracker") ."</a>");
echo "<br>";
echo "<b>". get_tr("Irc channel") ."</b>: ";
tr("Join #smplayer at irc.oftc.net (or click %1 if your client supports it).",
"<a href=\"irc://irc.oftc.net/smplayer\">". get_tr("this link") ."</a>");
?>

<h2><?php tr("Credits"); ?></h2>
<p>
<?php
echo "<b>Ricardo Villalba</b> (". get_tr("main developer, webmaster, ubuntu packages, spanish translation") .")";
echo "<br>";
echo "<b>redxii</b> (". get_tr("windows packages, mplayer builds for windows") .")";
echo "<br>";
echo "<b>Charles Barcza</b> (". get_tr("smplayer logo") ."). ". get_tr("Conversion to svg by %1.", "<b>akovia</b>");
?>

<h3><?php tr("Translators"); ?></h3>
<p>
<?php
tr("Many people worked on translations for smplayer. You can see the
full list in the <i>about</i> dialog.");
echo "<br>";
tr("Here is a list of the most active translators:");
?>
<ul>
<li>Nardog (<?php tr("Japanese");?>)</li>
<li>Sérgio Marques (<?php tr("Portuguese");?>)</li>
<li>Xabier Aramendi (<?php tr("Basque");?>)</li>
<li>Gymka (<?php tr("Lithuanian");?>)</li>
<li>Bendihua (<?php tr("Simplified chinese");?>)</li>
</ul>

<h3><?php tr("Skins"); ?></h3>
<p>
<?php
tr("The skins have been ported from umplayer. The authors are:");
echo " ";
echo "David Yen (black, vista), err0rsm1th (gonzo, mac), Echo (modern).";
?>

<h2>Twitter</h2>
<p>
<a target="_blank" href="https://twitter.com/smplayer_dev">
<?php tr("Follow us on Twitter");?></a>

<h2><?php tr("Mirrors"); ?></h2>
<p>
<a href="http://smplayer.info">http://smplayer.info</a>
<br>
<a href="http://smplayer.sourceforge.net">http://smplayer.sourceforge.net</a>
<br>
<a href="http://smplayer.berlios.de">http://smplayer.berlios.de</a>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
