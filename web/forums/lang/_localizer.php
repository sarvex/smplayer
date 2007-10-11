<?php

// Include file for PunBB PHP Localizer ...

function file_put_contents_php4($location, $whattowrite) {
	if (file_exists($location))
		unlink($location);
	$fileHandle = fopen($location, "wb");
	fwrite($fileHandle, $whattowrite);
	fclose($fileHandle);
}

function load_arrays(&$data, $path, $file) {
	global $merge, $output, $localized;
	
	$source = file_get_contents($path);
	$tokens = token_get_all($source);

	define(STATE_SKIPPING, 0);
	define(STATE_IN_ARRAY, 1);
	define(STATE_GOT_KEY, 2);
	define(STATE_GOT_ARROW, 3);

	$state = STATE_SKIPPING;
	
	foreach ($tokens as $token) {
		if (is_string($token)) {
			if ($merge) $output[$file] .= $token;
			if ($token == ')') {
				$state = STATE_SKIPPING;
				// echo '[ARRAY_END]';
			}
		} else {
			list($id, $text) = $token;
			
			switch($id) {
				
				case T_WHITESPACE:
					if ($merge) $output[$file] .= $text;
					break;
					
				case T_VARIABLE:
					if ($merge) $output[$file] .= $text;
					if ($state == STATE_SKIPPING) {
						if (substr($text, 0, 6) == '$lang_') {
							$state = STATE_IN_ARRAY;
							$arr_name = $text;
							$data[$arr_name] = array();
							// echo '[GOT_ARRAY_BEGINNING]';
						}
					}
					break;
				
				case T_CONSTANT_ENCAPSED_STRING:
				case T_STRING:
					switch($state) {
						case STATE_IN_ARRAY:
							$state = STATE_GOT_KEY;
							$key_name = substr($text, 1, strlen($text)-2);
							// echo '[GOT_KEY]';
							if ($merge) $output[$file] .= $text;
							break;
						case STATE_GOT_ARROW:
							if ((substr($text, 0, 1) == "'") && (substr($text, strlen($text)-1, 1) == "'")) {
								$data[$arr_name][$key_name] = stripslashes(substr($text, 1, strlen($text)-2));
								if ($merge) $output[$file] .= "'".$localized[$file][$arr_name][$key_name]."'";
							} else {
								if ($merge) $output[$file] .= $text;
							}
							// echo '[GOT_VALUE]';
							$state = STATE_IN_ARRAY;
							break;
						default:
							if ($merge) $output[$file] .= $text;
							break;
					}
					break;
				
				case T_DOUBLE_ARROW:
					if ($merge) $output[$file] .= $text;
					if ($state == STATE_GOT_KEY) {
						$state = STATE_GOT_ARROW;
						// echo '[GOT_ARROW]';
					}
					break;
				
				default:
					if ($merge) $output[$file] .= $text;
					break;
					
			}
			
		}
	}
}

function load_language($lang, $import=false) {
	$data = array();
	if (!is_dir($lang))
		die($lang . ' language folder not found');
	$d = dir($lang);
	while (false !== ($entry = $d->read())) {
		if ((substr($entry, strlen($entry)-4, 4) == '.php')) {
			$file = ($import ? substr($entry, strlen($lang)+1) : $entry);
			load_arrays($data[$file], $lang."/".$entry, $file);
		}
	}
	$d->close();
	return($data);
}

?>
