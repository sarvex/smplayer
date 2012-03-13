<?php
/*
 * l10n.php: some php functions to translate a web: 
 * (c) RVM 2007 <rvm@escomposlinux.org>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 *
 * Includes some code from Pophorator:
 *  Pophorator :: Copyright (C) 2004, 2005 Jarno Elonen <elonen@iki.fi>
 */
/* detect language and set tr_lang variable to that language */
/* Copyright gymka <gymka@mail.ru> 2012                      */
function detect_lang() {
        if(!isset($_REQUEST["tr_lang"])) { // if it's first visit, in url tr_lang is not set, so you can set it.
                switch (substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2)) { // take first language from browser „autoselect language“ variable
        case "lt":
        $_REQUEST["tr_lang"]="lt"; 
        $tr_lang="lt";
        break;
        case "it":
        $_REQUEST["tr_lang"]="it"; 
        $tr_lang="it";
        break; 
        case "es":
        $_REQUEST["tr_lang"]="es"; 
        $tr_lang="es";
        break; 
        case "ja":
        $_REQUEST["tr_lang"]="ja"; 
        $tr_lang="ja";
        break; 
        case "de":
        $_REQUEST["tr_lang"]="de"; 
        $tr_lang="de";
        break; 
        case "ru":
        $_REQUEST["tr_lang"]="ru"; 
        $tr_lang="ru";
        break; 
        case "pl":
        $_REQUEST["tr_lang"]="pl"; 
        $tr_lang="pl";
        break; 
        case "ro":
        $_REQUEST["tr_lang"]="ro"; 
        $tr_lang="ro";
        break; 
        case "uk":
        $_REQUEST["tr_lang"]="uk"; 
        $tr_lang="uk";
        break; 
        case "zh":
        $_REQUEST["tr_lang"]="zh"; 
        $tr_lang="zh";
        break; 
        case "hu":
        $_REQUEST["tr_lang"]="hu"; 
        $tr_lang="hu";
        break; 
        case "pt":
        $_REQUEST["tr_lang"]="pt"; 
        $tr_lang="pt";
        break; 
        case "fi":
        $_REQUEST["tr_lang"]="fi"; 
        $tr_lang="fi";
        break; 
        default:
        $_REQUEST["tr_lang"]="en"; 
        $tr_lang="en";
        break; 
        }  
}
}
        
function decode_po_quotes($txt)
{
  return stripcslashes(preg_replace('/"[^"]*$/', '', preg_replace('/^[^"]*"/', '', $txt)));
}

// Read a .po[t] file
function parse_po( $lines )
{
  $res = array();
  $last_line_type = "comment";

  $empty_entry = array(
    "comments" => array(),
    "autocomments" => array(),
    "sources" => array(),
    "flags" => array(),
    "msgid" => "",
    "msgstr" => "" );
  $cur = $empty_entry;

  $lineno = 0;
  foreach( $lines as $line )
  {
    $lineno++;
    $line = trim($line);

    if (strlen($line))
    {
      if ( preg_match('/^#/', $line))
      {
        if ( $last_line_type != "comment" )
        {
          if ( strlen($cur["msgid"]) || strlen(join('', $cur["comments"])) )
            $res[] = $cur;
          $cur = $empty_entry;
        }

        $cur["lineno"] = $lineno;

        if ( preg_match('/^#:/', $line))
          $cur["sources"][] = trim(substr($line, 2));
        else if ( preg_match('/^#,/', $line))
          $cur["flags"] = preg_split('/[#, \t]+/', $line, -1, PREG_SPLIT_NO_EMPTY);
        else if ( preg_match('/^#[.]/', $line))
          $cur["autocomments"][] = trim(substr($line, 2));
        else
          $cur["comments"][] = trim(substr($line, 2));

        $last_line_type = "comment";
      }
      else if ( preg_match('/^msgid[ \t]+["]*/', $line))
      {
        if ( $last_line_type != "comment" )
        {
          if ( strlen($cur["msgid"]) || strlen($cur["comments"]) )
            $res[] = $cur;
          $cur = $empty_entry;
        }
        $cur["msgid"] = decode_po_quotes(substr($line, 6));
        $last_line_type = "msgid";
      }
      else if ( preg_match('/^msgstr[ \t]+["]*/', $line))
      {
        if ( $cur === False )
          $cur = $empty_entry;

        $cur["msgstr"] = decode_po_quotes($line);
        $last_line_type = "msgstr";
      }
      else if ( preg_match('/^"/', $line))
      {
        if ( !preg_match( '/msg(id|str)/', $last_line_type ))
          print "Warning: syntax error in PO-file on line $lineno \n";
        else
          $cur[$last_line_type] .= decode_po_quotes($line);
      }
      else
      {
        print "Warning: malformed line $lineno in PO-file.\n";
      }
    }
  }
  if ( strlen($cur["msgid"]) /* || strlen($cur["comments"]) */ )
    $res[] = $cur;

  $res2 = array();
  foreach( $res as $r )
    $res2[md5($r["msgid"])] = $r;

  return $res2;
}

function parse_po_file($file) {
	return parse_po( file($file) );
}

function list_po_contents() {
	global $po_contents;
	foreach( $po_contents as $id => $arr ) {
		echo "msgid: '". $arr['msgid'] ."'<br>";
		echo "msgstr: '". $arr['msgstr'] ."'<br>";
		echo "<br><br>";
	}
}

function get_translation($orig_text, $arg1="", $arg2="", $arg3="", $arg4="" ) {
	global $po_contents;

	$translation = $orig_text;
	foreach( $po_contents as $id => $arr ) {
		//echo "comparing '".$arr['msgid']."' to '". $orig_text ."'<br>";
		if ( $arr['msgid'] == $orig_text ) {
			if ($arr['msgstr']!="") 
				$translation = $arr['msgstr'];

			break;
		}
	}

	// Replace arguments
	$translation = str_replace("%1", $arg1, $translation);
	$translation = str_replace("%2", $arg2, $translation);
	$translation = str_replace("%3", $arg3, $translation);
	$translation = str_replace("%4", $arg4, $translation);

	return $translation;
}

function tr($orig_text, $arg1="", $arg2="", $arg3="", $arg4="") {
	echo get_translation($orig_text, $arg1, $arg2, $arg3, $arg4);
}

function get_tr($orig_text, $arg1="", $arg2="", $arg3="", $arg4="") {
  return get_translation($orig_text, $arg1, $arg2, $arg3, $arg4);
}

function init_translation() {
	global $tr_lang, $po_contents;

	session_start();

	if (isset($_REQUEST["tr_lang"])) {
		$tr_lang = $_REQUEST["tr_lang"];
		$_SESSION["tr_lang"] = $tr_lang;
	}
	else
	if (isset($_SESSION["tr_lang"])) {
		$tr_lang = $_SESSION["tr_lang"];
	}

	if (!isset($tr_lang)) $tr_lang="en";

	$po_contents = array();
	$filename = "translations/".$tr_lang.".po";

	if (file_exists($filename)) {
		$po_contents = parse_po_file($filename);
	}
}

// main

detect_lang();
init_translation();

?>
