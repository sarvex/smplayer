<?php
// New form for localizer, created by rvm <rvm@escomposlinux.org>

// Global things

$translate_from = 'English';
//$translate_to = 'Prueba';
// $translate_import = 'dk';

require('_localizer.php');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$translate_to = $_POST["translate_to"];
$action = $_POST["action"];

$output = array();

function init() {
	global $translate_from, $translate_to;
	global $output, $template, $localized, $charset, $direction, $translate_import, $action, $merge;

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
}

$count = 0;

function hidden($val) {
	global $count;
	$count++;
	echo '<INPUT TYPE=HIDDEN NAME="v'.$count.'" VALUE="'.$val.'">';
}

function save() {
	global $localized, $count, $template, $merge, $output, $translate_to, $translate_from, $charset;

	$output_charset = $_POST["forced_charset"];
	//echo "charset: $charset<br>";
	//echo "output_charset: $output_charset<br>";

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
	foreach ($output as $file => $contents) {

		if ($output_charset!="" && $output_charset!=$charset) {
			$contents= iconv($charset, $output_charset, $contents);
			//$contents = $t;
		}

		file_put_contents_php4($translate_to.'/'.$file, $contents);
	}


}

function build_form() {
	global $template, $localized, $count, $translate_to, $charset;

	echo "<FORM ACTION=\"localizer2.php\" METHOD=\"post\">";
	echo "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"save\">";
	echo "<INPUT TYPE=\"hidden\" NAME=\"translate_to\" VALUE=\"$translate_to\">";

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
				$localized_text = $localized[$file][$array][$name];
				if ($localized_text == "") $localized_text = $template[$file][$array][$name];
				echo '<TR'.($color ? ' BGCOLOR='.$color : '').'><TD>'.$name.'</TD><TD>'.htmlspecialchars($template[$file][$array][$name]).'</TD><TD>'.'<TEXTAREA DIR='.$direction.' ROWS=\"4\" NAME="t'.$count.'" CLASS="pt_input">'.stripslashes($localized_text).'</TEXTAREA></TD></TR>'."\n";
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

	echo "<center>";
	echo "<SPAN CLASS=\"pt_title\">";
	echo " WARNING:";
	echo"  Saving will OVERWRITE existing files! BACK UP FIRST!";
	echo "</SPAN>";
	echo "<BR><BR>";
	echo "<INPUT TYPE=\"submit\" VALUE=\"&gt;&gt; WHEN YOU'RE DONE, CLICK HERE TO SAVE &lt;&lt;\">";
	echo "&nbsp; Output charset: ";
	echo "<input type=\"text\" name=\"forced_charset\" value=\"". $charset ."\">\n";
	echo "</CENTER>";
	echo "<BR>";
	echo "</FORM>";

}

function build_selection_form() {
	global $translate_from;

	echo "<h2>Select the language to edit:</h2>\n";
	//echo "<center>\n";
	echo "<form action=\"localizer2.php\" method=\"post\" >\n";
	echo "<select name=\"translate_to\">\n";

	if ($dh = opendir(".")) {
		while (($file = readdir($dh)) !== false) {
			if (is_dir($file) && $file[0]!="." && $file!=$translate_from) {
				//echo $file ."<br>";
				echo "<option value=\"$file\">$file</option>\n";
			}
		}
		closedir($dh);
	}
	echo "</select>\n";
	echo "<input type=\"submit\" value=\"Select\">\n";
	echo "</form>\n";
	//echo "</center>\n";
}

function print_header($charset) {
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
	echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=".$charset."\">\n";
	echo "</HEAD>";

	echo "<BODY>\n";

	echo "<H1><CENTER>PunBB PHP Localizer</CENTER></H1>\n";
}
?>

<?php
	if ($translate_to == "") {
		print_header("iso-8859-1");
		build_selection_form();
	} else {
		init();
		if ($action == "save") {
			save();
			$charset = $localized['common.php']['$lang_common']['lang_encoding'];
		}
		print_header($charset);
		if ($action == "save") echo "<b>SAVED!</b><br><br>";
		echo "<h2>Editing $translate_to (charset: $charset)</h2>\n";
		build_form();
		echo "<center><a href=\"localizer2.php\">[Go back to language selection]</a></center>";
	}
?>

</body>
</html>
