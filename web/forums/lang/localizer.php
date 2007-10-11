<?php

/*

PunBB PHP Localizer (v1.2)
-------------------

This script can be used to create/edit/update language file sets for
PunBB v1.2.x - language files from v1.1.x can no longer be edited,
but there is an import feature (see below), which will enable you to
upgrade your v1.1.x language files for PunBB v1.2.x.

Please read these instructions carefully before using this utility.

--- BEFORE YOU BEGIN ------------------------------------------------

1. Copy the "localizer.php" and "_localizer.php" files to your "lang"
   folder, under your PunBB installation.

2. Ensure that PHP has read/write access permissions to the "lang"
   folders.

3. Before starting an actual translation, please test the save
   function, to ensure that you don't loose your work!

--- TO CREATE A NEW TRANSLATION -------------------------------------

1. Copy the 'English' folder to a new folder, and rename it.

2. Adjust the $translate_from and $translate_to variables.

3. Open localizer.php in your browser, edit and save your changes.

   For example, if you were creating a new translation into Danish,
   you would rename the folder to "Danish" and set the variables to:

   $translate_from = 'English';
   $translate_to = 'Danish';

--- TO EDIT/UPDATE AN EXISTING TRANSLATION --------------------------

1. Ensure that the original 'English' folder is present.

2. Adjust the $translate_from and $translate_to variables.

3. Open localizer.php in your browser, edit and save your changes.

   Keep in mind that code and comments in your original translation
   will be lost - if your translation requires changes to the code,
   you will have to manually copy these out before editing, and then
   paste them back in afterwards.
   
   A simpler solution in this case may be, to simply use this
   utility to check your translation against the latest version of
   the english language files - that is, don't use the save button,
   just use the page to see which strings have been added or
   deprecated since your last update, then make the actual changes
   manually in a text editor.

--- TO UPGRADE A v1.1.x TRANSLATION TO v1.2.x -----------------------

1. Copy your v1.1.x language folder into the "lang" folder of your
   PunBB v1.2.x installation.

2. Make a copy of the "English" folder, and rename it.

3. Adjust the $translate_to and $translate_from variables, and set
   the $translate_import variable to your v1.1.x language foldername.

4. Open localizer.php in your browser, press save - the strings
   that were imported from your v1.1.x language files will then
   saved into your new v1.2.x-compatible language files.

5. Comment out the $translate_import variable, reload localizer.php
   in your browser, edit and save changes.

   For example, if you were upgrading a v1.1.x danish set of
   language files, you would first make a copy of the "English"
   folder, rename it to "Danish", then set the following variables:

   $translate_from = 'English';
   $translate_to = 'Danish';
   $translate_import = 'dk';
   
   You would then open localizer.php, press save, then comment out
   the import variable:

   $translate_from = 'English';
   $translate_to = 'Danish';
   // $translate_import = 'dk';

   Then edit normally.

*/

$translate_from = 'English';
$translate_to = 'Spanish';
// $translate_import = 'dk';

require('_localizer.php');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$action = $_POST["action"];
/*
if ($action == 'save')
	header("Location: localizer.php"); 
*/
?>
<HTML>

<HEAD>

<TITLE>PunBB PHP Localizer</TITLE>

<STYLE>
	BODY, TD, TH {
		font-family: verdana,arial,helvetica;
		font-size: 11px;
	}
	.pt_title {
		width: 100%;
		border: 1px solid #000000;
		padding: 2px;
		padding-left: 4px;
		margin-bottom: 4px;
		margin-top: 4px;
		font-weight: bold;
		background-color: #D0D0FF;
	}
	.pt_table {
		border: 0px;
		width: 100%;
		border-collapse: collapse;
	}
	.pt_table TD {
		padding: 4px;
		vertical-align: top;
		border: 1px solid #000000;
	}
	.pt_table TH {
		padding: 4px;
		border: 2px solid #000000;
		background-color: #D0D0D0;
	}
	.pt_input {
		width: 100%;
		font-size: 11px; /* change the font size of the editing boxes here, if you like */
		background-color: transparent;
		border: 0px;
	}
</STYLE>

<?php

$output = array();

$merge = false;
if ($translate_import && ($action != 'save')) {
	$localized = load_language($translate_import, true);
	$charset = $localized['_common.php']['$lang_common']['lang_encoding'];
	$direction = $localized['_common.php']['$lang_common']['lang_direction'];
} else {
	$localized = load_language($translate_to);
	$charset = $localized['common.php']['$lang_common']['lang_encoding'];
	$direction = $localized['common.php']['$lang_common']['lang_direction'];
}

$merge = false;
$template = load_language($translate_from);

echo '<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset='.$charset.'">';

?>

</HEAD>

<BODY>

<H1><CENTER>PunBB PHP Localizer</CENTER></H1>

<FORM ACTION="localizer.php" METHOD="post">
<INPUT TYPE="hidden" NAME="action" VALUE="save">

<?php
if ($translate_import)
	echo '<TABLE WIDTH=100% BORDER=1 CELLSPACING=0 CELLPADDING=8><TR><TD ALIGN=CENTER BGCOLOR=#FFA0A0><B>PLEASE NOTE</B><P/>The localized strings were imported from an older set of language files (prior to PunBB v.1.2.x) ... You should press SAVE at the bottom of the page ONCE to import these strings into a newer set of language files - then comment out the $translate_import setting and <A HREF="localizer.php">click here</A> to reload this page before starting your actual editing...</TD></TR></TABLE>';


$count = 0;

function hidden($val) {
	global $count;
	$count++;
	echo '<INPUT TYPE=HIDDEN NAME="v'.$count.'" VALUE="'.$val.'">';
}

if ($action == 'save') {
	// Parse submitted form:
	$localized = array();
	$count = $_POST["count"];
	for ($i=1; $i<=$count; $i++) {
		switch (substr($_POST["v".$i], 0, 2)) {
			case 'f:':
				$file = substr($_POST["v".$i], 2);
				break;
			case 'a:':
				$arr_name = substr($_POST["v".$i], 2);
				break;
			default:
				$localized[$file][$arr_name][$_POST["v".$i]] = $_POST["t".$i];
		}
	}
	// Merge with template:
	$merge = true;
	$template = load_language($translate_from);
	// Save output files:
	foreach ($output as $file => $contents)
		file_put_contents_php4($translate_to.'/'.$file, $contents);

	//echo "<a href=\"localizer.php\">Return</a>";
	echo "<b>SAVED!</b><br><br>";

} /*else*/ {
	// Build the form:
	foreach ($template as $file => $array) {
		hidden('f:'.$file);
		foreach ($template[$file] as $array => $data) {
			hidden('a:'.$array);
			echo '<SPAN CLASS="pt_title">'.$file.' : '.$array.'</SPAN>';
			echo '<TABLE CLASS="pt_table"><TR><TH WIDTH=20%>Key</TH><TH WIDTH=40%>Template</TH><TH WIDTH=40%>Localized</TH></TR>';
			$alt = true;
			foreach ($template[$file][$array] as $name => $value) {
				$alt = !$alt;
				$color = ($alt ? '#F0F0F0' : null);
				if (!$localized[$file][$array][$name] || ($localized[$file][$array][$name] == $template[$file][$array][$name]))
					$color = '#FFD0D0';
				hidden($name);
				echo '<TR'.($color ? ' BGCOLOR='.$color : '').'><TD>'.$name.'</TD><TD>'.htmlspecialchars($template[$file][$array][$name]).'</TD><TD>'.'<TEXTAREA DIR='.$direction.' ROWS=4 NAME="t'.$count.'" CLASS="pt_input">'.$localized[$file][$array][$name].'</TEXTAREA></TD></TR>'."\n";
			}
			foreach ($localized[$file][$array] as $name => $value) {
				if (!$template[$file][$array][$name] && ($template[$file][$array][$name] != $localized[$file][$array][$name])) {
					$alt = !$alt;
					$color = ($alt ? '#F0F0F0' : null);
					echo '<TR'.($color ? ' BGCOLOR='.$color : '').' STYLE="color:#808080"><TD>'.$name.'</TD><TD><B>DEPRECATED</B></TD><TD>'.'<DIV CLASS="pt_input">'.$localized[$file][$array][$name].'</DIV></TD></TR>'."\n";
				}
			}
			echo '</TABLE>';
			echo '<INPUT TYPE=HIDDEN NAME="count" VALUE="'.$count.'">';
		}
	}
}

?>

<BR>


<CENTER>
<br>
<SPAN CLASS="pt_title">
		WARNING:
		Saving will OVERWRITE existing files! BACK UP FIRST!
</SPAN>
		<BR><BR>
		<INPUT TYPE="submit" VALUE="&gt;&gt; WHEN YOU'RE DONE, CLICK HERE TO SAVE &lt;&lt;">
	</CENTER>
	<BR>



</FORM>

</BODY>

</HTML>
