<?php
include_once("header.php");
print_header(get_tr("FAQ"));
echo "<body>\n";
print_menu(0);

$faq_id = 0;
$faq_style = 0;

function print_faq($question, $answer) {
	global $faq_id, $faq_style;

	if ($faq_style==0) {
		/* Q. = Initial for "Question" */
		$Q = get_tr("Q.");
		echo '<div class="accordion-group">';
		echo '<div class="accordion-heading">';
		echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'. $faq_id .'One">';
		echo "<h4>$Q $question</h4>";
		echo '</a>';
		echo '</div>';
		echo '<div id="collapse'. $faq_id .'One" class="accordion-body collapse">';
		echo '<div class="accordion-inner">';
		echo "<blockquote><p><i>$answer</i></blockquote>";
		echo '</div>';
		echo '</div>';
		echo '</div>';

		$faq_id++;
	} 
	elseif ($faq_style==1) {
		echo "<h4>$question</h4>\n";
		echo "<blockquote>\n";
		echo "<p>\n";
		echo "$answer\n";
		echo "</blockquote>\n";
	}
}
?>

<div class="container-fluid">
<h1><?php tr("Frequently Asked Questions"); ?></h1>

<div class="row-fluid">

<div class="span6">
<div class="accordion" id="accordion2">
<?php
print_faq(get_tr("How can I download subtitles from opensubtitles.org?"),
get_tr("It's very easy. Just open a video, and then select the option \"Find
subtitles on opensubtitles.org\" within the Subtitles menu. A new window
will show a list of suitable subtitles for the video you're playing.
Select one and click on the Download button. The subtitle file will be
downloaded and displayed in the video."));

print_faq(get_tr("The video equalizer doesn't work, why?"),
get_tr("With some cards or video drivers the hardware video 
equalizer may not work. Go to Preferences -> General -> Video 
and enable the software equalizer."));

print_faq(get_tr("DVD menus, where are they?"),
get_tr("Go to the Drive section in preferences and check the option
\"Enable DVD menus (Experimental)\" and set your DVD drive."));

print_faq(get_tr("How can I download a Youtube video?"),
get_tr("Right click on a video in the Youtube browser, and select the option
\"Record video\"."));

print_faq(get_tr("How can I change the skin?"),
get_tr("Go to the SMPlayer preferences, select the Interface section, then
select the \"Skinnable GUI\". Now you can choose among several skins.") ." ".
get_tr("In linux you need to install the package smplayer-skins."));

print_faq(get_tr("Where is the configuration stored? Can I reset the settings?"),
get_tr("The easiest way to find the configuration files of SMPlayer is by
selecting the option \"Open configuration folder\" in the Help menu. If
you want to delete the current configuration and start with the default
settings, just delete the file smplayer.ini (important: be sure SMPlayer
is not running when you delete the file)."));

print_faq(get_tr("What's the difference between SMPlayer and MPlayer?"),
get_tr("They are two different applications that work together. SMPlayer
actually is not a media player... MPlayer is. MPlayer is a command-line
application, it doesn't have menus or buttons. It is controlled by the
keyboard. As this is not very user friendly, several graphical
interfaces have been developed, and SMPlayer is one of them. So MPlayer
is the playback engine, SMPlayer adds the buttons, menus, dialogs, and so
on. The Windows packages already include a MPlayer build along with
SMPlayer."));

print_faq(get_tr("What does the \"ps\" mean in some of the installers name?"),
get_tr("It means that the installer includes a \"promotional screen\" from a
sponsor. This screen offers the user the possibility to install a third
party application. It may be for example a demo version of an
interesting application. It's up to you to decide whether give it a try
or not. If you install it but then you don't like it, you can uninstall it
easily later.") ."<br>".
get_tr("If you decide to install it, the sponsor will send a few cents to
SMPlayer. This way we don't need to ask the users for donations. You can
find more info at %1.", 
"<a href=\"http://www.opencandy.com/faqs/\">www.opencandy.com/faqs</a>") ."<br>".
get_tr("If you just don't want to see this screen, just download the no \"ps\" installer."));

print_faq(get_tr("The current time of the movie appears in the up left corner of the image, how can I hide it?"),
get_tr("Options -> OSD -> Subtitles only."));

echo '</div> <!-- accordion -->';
echo '</div> <!-- span -->';
echo '<div class="span6">';
echo '<div class="accordion" id="accordion2">';

print_faq(get_tr("How can I take advantage of all my CPU cores?"),
get_tr("Multithreaded decoding requires a recent build of MPlayer or FFmpeg-mt
in Linux. MPlayer2 automatically uses all cores, but MPlayer requires
manual adjustment. You can adjust the number of threads used for
decoding in Preferences -> Performance. Set it to equal or less than the
number of cores (and threads in the case of hyperthreaded Intel CPUs)
your processor has. Setting it to greater than your CPU is capable of
will have no effect."));

print_faq(get_tr("I want the subtitles to be displayed on the black border instead of the image, how can I do it?"),
get_tr("Select the option \"Add black borders\" in the video filters menu."));

print_faq(get_tr("Is UMPlayer related to SMPlayer?"),
get_tr("Yes. UMPlayer was a fork created from SMPlayer 0.6.9. They added several
new features, like new skins, and Youtube&trade; and SHOUTcast&trade; support. 
Most of those features are now included in SMPlayer as well.") ."<br>".
get_tr("The UMPlayer project seems dead (no updates since a lot of months) and
version 0.98 can't play Youtube videos anymore, so if you are a user of
UMPlayer it's recommended to switch to SMPlayer. 
Moreover SMPlayer includes new features not present in UMPlayer."));

print_faq(get_tr("What's \"smtube\"?"),
get_tr("It's the Youtube browser that was first included in UMPlayer, and we
adapted it for SMPlayer. We made it an independent application, and on
Linux it can run on its own, the user can select the player to use
(SMPlayer isn't even required)."));

print_faq(get_tr("I'm using Windows Vista or later and every time I play a video Aero is disabled, why?"),
get_tr("This happens when using directx as video driver (Preferences -> General
-> Video). You can change it to gl, gl2 or direct3d."));

print_faq(get_tr("(Windows) I'm unable to open files with special or non-English characters, why?"),
get_tr("If you are unable to open files with special or non-English characters,
enable Pass short filenames (8+3) to MPlayer under Options ->
Preferences -> Advanced to work around this problem."));

print_faq(get_tr("Some menu options make the video to go blank for a moment. Why?"),
get_tr("Some options require to stop the MPlayer process and launch it again
with new parameters. That's why playback interrupts for a moment."));
?>
</div> <!-- accordion -->
</div> <!-- row -->

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
