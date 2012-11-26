<?php
include_once("header.php");
print_header(get_tr("SMPlayer - FAQ"), 1);
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">

<div class="row-fluid">
<h1><?php tr("Frequently Asked Questions"); ?></h1>

<div class="span5">
<h3><?php tr("How can I download subtitles from opensubtitles.org?"); ?></h3>
<p>
<?php
tr("It's very easy. Just open a video, and then select the option \"Find
subtitles on opensubtitles.org\" within the Subtitles menu. A new window
will show a list of suitable subtitles for the video you're playing.
Select one and click on the Download button. The subtitle file will be
downloaded and displayed in the video.");
?>

<h3><?php tr("DVD menus, where are they?"); ?></h3>
<p>
<?php
tr("Go to the Drive section in preferences and check the option
\"Enable DVD menus (Experimental)\" and set your DVD drive.");
?>

<h3><?php tr("How can I download a Youtube video?"); ?></h3>
<p>
<?php
tr("Right click on a video in the Youtube browser, and select the option
\"Record video\".");
?>

<h3><?php tr("How can I change the skin?"); ?></h3>
<p>
<?php
tr("Go to the SMPlayer preferences, select the Interface section, then
select the \"Skinnable GUI\". Now you can choose among several skins.");
?>

<h3><?php tr("Where is the configuration stored? Can I reset the settings?"); ?></h3>
<p>
<?php
tr("The easiest way to find the configuration files of SMPlayer is by
selecting the option \"Open configuration folder\" in the Help menu. If
you want to delete the current configuration and start with the default
settings, just delete the file smplayer.ini (important: be sure SMPlayer
is not running when you delete the file).");
?>

<h3><?php tr("What's the difference between SMPlayer and MPlayer?"); ?></h3>
<p>
<?php
tr("They are two different applications that work together. SMPlayer
actually is not a media player... MPlayer is. MPlayer is a command-line
application, it doesn't have menus or buttons. It is controlled by the
keyboard. As this is not very user friendly, several graphical
interfaces have been developed, and SMPlayer is one of them. So MPlayer
is the playback engine, SMPlayer adds the buttons, menus, dialogs, and so
on. The Windows packages already include a MPlayer build along with
SMPlayer.");
?>

<h3><?php tr("What does the \"ps\" mean in some of the installers name?"); ?></h3>
<p>
<?php
tr("It means that the installer includes a \"promotional screen\" from a
sponsor. This screen offers the user the possibility to install a third
party application. It may be for example a demo version of an
interesting application. It's up to you to decide whether give it a try
or not. If you install it but then you don't like it, you can uninstall it
easily later.");
echo "<br>";
tr("If you decide to install it, the sponsor will send a few cents to
SMPlayer. This way we don't need to ask the users for donations. You can
find more info at %1.", 
"<a href=\"http://www.opencandy.com/faqs/\">www.opencandy.com/faqs</a>");
echo "<br>";
tr("If you just don't want to see this screen, just download the no \"ps\" installer.");
?>

</div>

<div class="span5">
<h3><?php tr("How can I take advantage of all my CPU cores?"); ?></h3>
<p>
<?php
tr("Multithreaded decoding requires a recent build of MPlayer or FFmpeg-mt
in Linux. MPlayer2 automatically uses all cores, but MPlayer requires
manual adjustment. You can adjust the number of threads used for
decoding in Preferences -> Performance. Set it to equal or less than the
number of cores (and threads in the case of hyperthreaded Intel CPUs)
your processor has. Setting it to greater than your CPU is capable of
will have no effect.");
?>

<h3><?php tr("I want the subtitles to be displayed on the black border instead of the image, how can I do it?"); ?></h3>
<p>
<?php
tr("Select the option \"Add black borders\" in the video filters menu.");
?>

<h3><?php tr("Is UMPlayer related to SMPlayer?"); ?></h3>
<p>
<?php
tr("Yes. UMPlayer was a fork created from SMPlayer 0.6.9. They added several
new features, like new skins, and Youtube&trade; and SHOUTcast&trade; support. 
Most of those features are now included in SMPlayer as well.");
echo "<br>";
tr("The UMPlayer project seems dead (no updates since a lot of months) and
version 0.98 can't play Youtube videos anymore, so if you are a user of
UMPlayer it's recommended to switch to SMPlayer. 
Moreover SMPlayer includes new features not present in UMPlayer.");
echo "<br>";
tr("Anyway, if you still prefer to use UMPlayer we released a new version
with the Youtube problem fixed: %1.",
"<a href=\"http://smplayer.sourceforge.net/umplayer.php?tr_lang=". $tr_lang ."\">http://smplayer.sf.net/umplayer.php</a>");
?>

<h3><?php tr("What's \"smtube\"?"); ?></h3>
<p>
<?php
tr("It's the Youtube browser that was first included in UMPlayer, and we
adapted it for SMPlayer. We made it an independent application, and on
Linux it can run on its own, the user can select the player to use
(SMPlayer isn't even required).");
?>

<h3><?php tr("I'm using Windows Vista or later and every time I play a video Aero is disabled, why?"); ?></h3>
<p>
<?php
tr("This happens when using directx as video driver (Preferences -> General
-> Video). You can change it to gl, gl2 or direct3d.");
?>

<h3><?php tr("(Windows) I'm unable to open files with special or non-English characters, why?"); ?></h3>
<p>
<?php
tr("If you are unable to open files with special or non-English characters,
enable Pass short filenames (8+3) to MPlayer under Options ->
Preferences -> Advanced to work around this problem.");
?>

<h3><?php tr("Some menu options make the video to go blank for a moment. Why?"); ?></h3>
<p>
<?php
tr("Some options require to stop the MPlayer process and launch it again
with new parameters. That's why playback interrupts for a moment.");
?>

</div>

</div> <!-- row -->

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
