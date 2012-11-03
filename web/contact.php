<?php
include_once("header.php");
print_header(get_tr("SMPlayer - Contact us"));
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">
<h1><?php tr("Contact us"); ?></h1>
<p>
You can send your suggestions, patches, translations or whatever regarding 
smplayer, to 
<b>Ricardo Villalba</b> &lt;smplayer.dev at gmail dot com&gt;
<br>
You can write in English or Spanish.

<h2><?php tr("Support"); ?></h2>
<p>
You can get help in our <a href="http://smplayer.sourceforge.net/forum/">forum</a>.
<br>
If you find bugs in smplayer you can report them in our 
<a href="http://sourceforge.net/tracker/?group_id=185512&atid=913573">bug tracker</a>.
<br>
You can request new features in our <a href="http://sourceforge.net/tracker/?group_id=185512&atid=913576">request tracker</a>.
<br>
<b>Irc channel</b>:
Join #smplayer at irc.oftc.net (or click 
<a href="irc://irc.oftc.net/smplayer">this link</a> if your client supports it).


<h2><?php tr("Credits"); ?></h2>
<p>
<b>Ricardo Villalba</b> (main developer, webmaster, ubuntu packages, spanish translation)
<br>
<b>redxii</b> (windows packages, mplayer builds for windows)
<br>
<b>Charles Barcza</b> (smplayer logo). Conversion to svg by <b>akovia</b>.

<h3><?php tr("Translators"); ?></h3>
<p>
Many people worked on translations for smplayer. You can see the
full list in the <i>about</i> dialog.
<br>
Here is a list of the most active translators:
<ul>
<li>Nardog (Japanese)</li>
<li>Smarquespt (Portuguese)</li>
<li>Xabier Aramendi (Basque)</li>
<li>Gymka (Lithuanian)</li>
<li>Bendihua (Simplified chinese)</li>
</ul>


<h2>Twitter</h2>
<p>
<a target="_blank" href="https://twitter.com/smplayer_dev">
<?php tr("Follow us on Twitter");?></a>

<h2><?php tr("Mirrors"); ?></h2>
<p>
<a href="http://smplayer.sourceforge.net">smplayer.sourceforge.net</a>
<br>
<a href="http://smplayer.berlios.de">smplayer.berlios.de</a>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
