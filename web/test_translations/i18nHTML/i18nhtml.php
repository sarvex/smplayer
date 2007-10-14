<?php
/*
     (C) 2003, 2004, 2005, 2006, 2007 Christian Grothoff and other contributing authors.

     This code is free software; you can redistribute it and/or modify
     it under the terms of the GNU General Public License as published
     by the Free Software Foundation; either version 2, or (at your
     option) any later version.

     The code is distributed in the hope that it will be useful, but
     WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
     General Public License for more details.

     You should have received a copy of the GNU General Public License
     along with the code; see the file COPYING.  If not, write to the
     Free Software Foundation, Inc., 59 Temple Place - Suite 330,
     Boston, MA 02111-1307, USA.
*/
  // This file defines the functions that will be used
  // to build the webpage.  The set may not contain everything
  // you might want, so feel free to define your own extensions.

  // Use W("text") to output translations.
  // $lang/xlang are used to specify the language
  // $editor can be set to create a translation
  // tag even if a translation is already available.
  // there is currently no security.
  //
  // An "_" is used for functions that return the
  // translated string instead of printing it directly.
  // These functions are used for "%s" printing with W().
  //
  // Most of the code should be straight forward. Look
  // at some of the example files that use it and compare with
  // the generated pages.
// obtain user db specific configuration parameters
include("i18nhtml_config.php");
header("Content-type: text/html; charset=utf-8");

// establish default connection to database server
$connection = @mysql_connect($i18nHTMLsqlServer,
			     $i18nHTMLsqlUser,
			     $i18nHTMLsqlPass);
if (!$connection) {
   die ('Failure connecting to ' . $i18nHTMLsqlServer . ': ' . mysql_error());
}

// and select database on server that holds translations
if ($connection) {
  $db_selected = mysql_select_db($i18nHTMLsqlDB,
		  $connection);
  if (!$db_selected) {
     die ('Error selecting db : ' . mysql_error());
  }
}

/* mapping of real-names to language codes */
$languagecodes = array("English"=>"en",
		       "German"=>"de",
		       "French"=>"fr",
		       "Portuguese"=>"pt",
		       "Russian"=>"ru",
		       "Romanian"=>"ro",
		       "Spanish"=>"es",
		       "Italian"=>"it",
		       "Simplified chinese"=>"zh_CN",
		       "Catalan"=>"ca",
		       "Basque"=>"eu",
		       "Arabic"=>"ar",
		       "Bulgarian"=>"bg",
		       "Czech"=>"cs",
		       "Dutch"=>"nl",
		       "Esperanto"=>"eo",
		       "Hebrew"=>"he",
		       "Japanese"=>"ja",
		       "Norwegian"=>"no",
		       "Polish"=>"po",
		       "Ukrainian"=>"uk",
		       "Danish"=>"da",
		       "Swedish"=>"sv");

/* try to automagically figure out user preferences */
$hlang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
if ($hlang) {
  $tok = strtok($hlang, ";");
  while ($tok) {
    foreach($languagecodes as $name=>$code) {
      if (0 == strncmp($tok, $code, 2)) {
        $lang = $name;
        break 2;
      }
    }
    $tok = strtok(";");
  }
}

/**
 * Replace certain HTML named special characters with their
 * numeric codes (some browsers don't work with the symbolic names).
 */
$htmlin  = array("&rsquo;", "&gt;",  "&quot;", "&prime;", "&amp;", "\"",    "'",      "`",       "&lsquo;");
$htmlout = array("&#8217;", "&#62;", "&#34;" , "&#8242;", "&#38;", "&#34;", "&#8242;", "&#8217;", "&#8216;");
function fix($a) {
  global $htmlin;
  global $htmlout;
  return str_replace($htmlin, $htmlout, $a);
}

// Quote variable to make safe from
// http://fr.php.net/manual/en/function.mysql-real-escape-string.php
function quote_smart($value) {
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }
   $value = mysql_real_escape_string($value);
   return $value;
}

// If no language is specified, use default
if ( (! $lang) || ($lang=="") )
  $lang = $i18nHTMLsrcLang;
$xlang = $_REQUEST['xlang'];
if ($xlang)
  $lang = $xlang;

$lang = ucfirst(strtolower($lang));
$lang = quote_smart($lang);

$query = "SELECT lang FROM ${i18nHTMLsqlPrefix}languages WHERE lang=\"" . mysql_real_escape_string($lang) . "\";";
$result = mysql_query($query, $connection);     
$num = 0;
if ($result)
  $num = mysql_numrows($result);
if ($num == 0) {
  $xlang = $i18nHTMLsrcLang;
  $lang = $i18nHTMLsrcLang;
 }

$lang = ucfirst(strtolower($lang));
$lang = quote_smart($lang);
$editor = $_REQUEST['editor'];
$i18nHTMLhasTranslation = 0; // set by last call to translation_query()


// *************************************************
// i18nHTML configuration API functions
// *************************************************

// change the marker text shown to indicate text
// is translatable (link to translate page text)
function setTranslateLinkMarker($marker) {
  global $i18nHTMLmarker;

  if ($marker == "")
    $i18nHTMLmarker = "*";  // reset to default value
  else
    $i18nHTMLmarker = $marker;
}

// ***************************************************
// i18nHTML _internal_ API functions (don't look here)
// ***************************************************

// returns a HTML string to link to enable one to translate the given
// text ($a) when $editor has a nonzero value or
// $i18nHTMLhasTranslation is 0; otherwise and empty string ("") is
// returned.
function translateLink_($a) {
  global $lang;
  global $HTTP_SERVER_VARS;
  global $editor;
  global $i18nHTMLhasTranslation;
  global $i18nHTMLmarker;
  global $i18nHTMLbase;

  if ($hasTranslation == "")
    $hasTranslation = $i18nHTMLhasTranslation;
  if ( ($editor) || ($i18nHTMLhasTranslation == 0) ) {
    $protocol = "http";
    if ($HTTP_SERVER_VARS["HTTPS"] == "on") {
       $protocol = "https"; // switch to https
    }
    $back = $protocol . "://" . $HTTP_SERVER_VARS["HTTP_HOST"] . $HTTP_SERVER_VARS["REQUEST_URI"];
    return "<a href=\"${i18nHTMLbase}translate.php?xlang="
      . $lang
      . "&amp;text=" . urlencode(fix($a))
      . "&amp;back=" . urlencode($back)
      . "\" title=\"" . fix($a)
      . "\">" . $i18nHTMLmarker . "</a>\n";
  } else
    return "";
}

// displays a link to the page to enable one to
// translate the given text ($a)
// see translateLink_
function translateLink($a) {
  echo translateLink_($a);
}

/**
 * transcode unicode entities to/from HTML entities
 *
 * Also, this function transforms HTML entities into their equivalent Unicode entities.
 * For example, w.bloggar posts pages using HTML entities.
 * If you have to modify these pages using web forms, you would like to get UTF-8 instead.
 *
 * @link http://www.evolt.org/article/A_Simple_Character_Entity_Chart/17/21234/ A Simple Character Entity Chart
 *
 * @param string the string to be transcoded
 * @param boolean TRUE to transcode to Unicode, FALSE to transcode to HTML
 * @return a transcoded string
 */
function transcode($input, $to_unicode=TRUE) {
  // initialize tables only once
  static $html_entities, $unicode_entities;
  if(!is_array($html_entities)) {


    // numerical order
    $codes = array(
		   '&#160;'	=> '&nbsp;',	// non-breaking space
		   '&#161;'	=> '&iexcl;',	// inverted exclamation mark
		   '&#162;'	=> '&cent;',	// cent sign
		   '&#163;'	=> '&pound;',	// pound sign
		   '&#164;'	=> '&curren;',	// currency sign
		   '&#165;'	=> '&yen;',		// yen sign
		   '&#166;'	=> '&brvbar;',	// broken bar
		   '&#167;'	=> '&sect;',	// section sign
		   '&#168;'	=> '&uml;',		// diaeresis
		   '&#169;'	=> '&copy;',	// copyright sign
		   '&#170;'	=> '&ordf;',	// feminine ordinal indicator
		   '&#171;'	=> '&laquo;',	// left-pointing double angle quotation mark
		   '&#172;'	=> '&not;',		// not sign
		   '&#173;'	=> '&shy;',		// soft hyphen
		   '&#174;'	=> '&reg;',		// registered sign
		   '&#175;'	=> '&macr;',	// macron
		   '&#176;'	=> '&deg;',		// degree sign
		   '&#177;'	=> '&plusmn;',	// plus-minus sign
		   '&#178;'	=> '&sup2;',	// superscript two
		   '&#179;'	=> '&sup3;',	// superscript three
		   '&#180;'	=> '&acute;',	// acute accent
		   '&#181;'	=> '&micro;',	// micro sign
		   '&#182;'	=> '&para;',	// pilcrow sign
		   '&#183;'	=> '&middot;',	// middle dot
		   '&#184;'	=> '&cedil;',	// cedilla
		   '&#185;'	=> '&sup1;',	// superscript one
		   '&#186;'	=> '&ordm;',	// masculine ordinal indicator
		   '&#187;'	=> '&raquo;',	// right-pointing double angle quotation mark
		   '&#188;'	=> '&frac14;',	// vulgar fraction one quarter
		   '&#189;'	=> '&frac12;',	// vulgar fraction one half
		   '&#190;'	=> '&frac34;',	// vulgar fraction three quarters
		   '&#191;'	=> '&iquest;',	// inverted question mark
		   '&#192;'	=> '&Agrave;',	// latin capital letter A with grave
		   '&#193;'	=> '&Aacute;',	// latin capital letter A with acute
		   '&#194;'	=> '&Acirc;',	// latin capital letter A with circumflex
		   '&#195;'	=> '&Atilde;',	// latin capital letter A with tilde
		   '&#196;'	=> '&Auml;',	// latin capital letter A with diaeresis
		   '&#197;'	=> '&Aring;',	// latin capital letter A with ring above
		   '&#198;'	=> '&AElig;',	// latin capital letter AE
		   '&#199;'	=> '&Ccedil;',	// latin capital letter C with cedilla
		   '&#200;'	=> '&Egrave;',	// latin capital letter E with grave
		   '&#201;'	=> '&Eacute;',	// latin capital letter E with acute
		   '&#202;'	=> '&Ecirc;',	// latin capital letter E with circumflex
		   '&#203;'	=> '&Euml;',	// latin capital letter E with diaeresis
		   '&#204;'	=> '&Igrave;',	// latin capital letter I with grave
		   '&#205;'	=> '&Iacute;',	// latin capital letter I with acute
		   '&#206;'	=> '&Icirc;',	// latin capital letter I with circumflex
		   '&#207;'	=> '&Iuml;',	// latin capital letter I with diaeresis
		   '&#208;'	=> '&ETH;',		// latin capital letter ETH
		   '&#209;'	=> '&Ntilde;',	// latin capital letter N with tilde
		   '&#210;'	=> '&Ograve;',	// latin capital letter O with grave
		   '&#211;'	=> '&Oacute;',	// latin capital letter O with acute
		   '&#212;'	=> '&Ocirc;',	// latin capital letter O with circumflex
		   '&#213;'	=> '&Otilde;',	// latin capital letter O with tilde
		   '&#214;'	=> '&Ouml;',	// latin capital letter O with diaeresis
		   '&#215;'	=> '&times;',	// multiplication sign
		   '&#216;'	=> '&Oslash;',	// latin capital letter O with stroke
		   '&#217;'	=> '&Ugrave;',	// latin capital letter U with grave
		   '&#218;'	=> '&Uacute;',	// latin capital letter U with acute
		   '&#219;'	=> '&Ucirc;',	// latin capital letter U with circumflex
		   '&#220;'	=> '&Uuml;',	// latin capital letter U with diaeresis
		   '&#221;'	=> '&Yacute;',	// latin capital letter Y with acute
		   '&#222;'	=> '&THORN;',	// latin capital letter THORN
		   '&#223;'	=> '&szlig;',	// latin small letter sharp s
		   '&#224;'	=> '&agrave;',	// latin small letter a with grave
		   '&#225;'	=> '&aacute;',	// latin small letter a with acute
		   '&#226;'	=> '&acirc;',	// latin small letter a with circumflex
		   '&#227;'	=> '&atilde;',	// latin small letter a with tilde
		   '&#228;'	=> '&auml;',	// latin small letter a with diaeresis
		   '&#229;'	=> '&aring;',	// latin small letter a with ring above
		   '&#230;'	=> '&aelig;',	// latin small letter ae
		   '&#231;'	=> '&ccedil;',	// latin small letter c with cedilla
		   '&#232;'	=> '&egrave;',	// latin small letter e with grave
		   '&#233;'	=> '&eacute;',	// latin small letter e with acute
		   '&#234;'	=> '&ecirc;',	// latin small letter e with circumflex
		   '&#235;'	=> '&euml;',	// latin small letter e with diaeresis
		   '&#236;'	=> '&igrave;',	// latin small letter i with grave
		   '&#237;'	=> '&iacute;',	// latin small letter i with acute
		   '&#238;'	=> '&icirc;',	// latin small letter i with circumflex
		   '&#239;'	=> '&iuml;',	// latin small letter i with diaeresis
		   '&#240;'	=> '&eth;',		// latin small letter eth
		   '&#241;'	=> '&ntilde;',	// latin small letter n with tilde
		   '&#242;'	=> '&ograve;',	// latin small letter o with grave
		   '&#243;'	=> '&oacute;',	// latin small letter o with acute
		   '&#244;'	=> '&ocirc;',	// latin small letter o with circumflex
		   '&#245;'	=> '&otilde;',	// latin small letter o with tilde
		   '&#246;'	=> '&ouml;',	// latin small letter o with diaeresis
		   '&#247;'	=> '&divide;',	// division sign
		   '&#248;'	=> '&oslash;',	// latin small letter o with stroke
		   '&#249;'	=> '&ugrave;',	// latin small letter u with grave
		   '&#250;'	=> '&uacute;',	// latin small letter u with acute
		   '&#251;'	=> '&ucirc;',	// latin small letter u with circumflex
		   '&#252;'	=> '&uuml;',	// latin small letter u with diaeresis
		   '&#253;'	=> '&yacute;',	// latin small letter y with acute
		   '&#254;'	=> '&thorn;',	// latin small letter thorn
		   '&#255;'	=> '&yuml;',	//
		   '&#338;'	=> '&OElig;',	// latin capital ligature OE
		   '&#339;'	=> '&oelig;',	// latin small ligature oe
		   '&#352;'	=> '&Scaron;',	// latin capital letter S with caron
		   '&#353;'	=> '&scaron;',	// latin small letter s with caron
		   '&#376;'	=> '&Yuml;',	// latin capital letter Y with diaeresis
		   '&#402;'	=> '&fnof;' ,	// latin small f with hook
		   '&#710;'	=> '&circ;',	// modifier letter circumflex accent
		   '&#732;'	=> '&tilde;',	// small tilde
		   '&#913;'	=> '&Alpha;',	// greek capital letter alpha
		   '&#914;'	=> '&Beta;',	// greek capital letter beta
		   '&#915;'	=> '&Gamma;',	// greek capital letter gamma
		   '&#916;'	=> '&Delta;',	// greek capital letter delta
		   '&#917;'	=> '&Epsilon;',	// greek capital letter epsilon
		   '&#918;'	=> '&Zeta;',	// greek capital letter zeta
		   '&#919;'	=> '&Eta;',		// greek capital letter eta
		   '&#920;'	=> '&Theta;',	// greek capital letter theta
		   '&#921;'	=> '&Iota;',	// greek capital letter iota
		   '&#922;'	=> '&Kappa;',	// greek capital letter kappa
		   '&#923;'	=> '&Lambda;',	// greek capital letter lambda
		   '&#924;'	=> '&Mu;',		// greek capital letter mu
		   '&#925;'	=> '&Nu;',		// greek capital letter nu
		   '&#926;'	=> '&Xi;',		// greek capital letter xi
		   '&#927;'	=> '&Omicron;',	// greek capital letter omicron
		   '&#928;'	=> '&Pi;',		// greek capital letter pi
		   '&#929;'	=> '&Rho;',		// greek capital letter rho
		   '&#931;'	=> '&Sigma;',	// greek capital letter sigma
		   '&#932;'	=> '&Tau;',		// greek capital letter tau
		   '&#933;'	=> '&Upsilon;',	// greek capital letter upsilon
		   '&#934;'	=> '&Phi;',		// greek capital letter phi
		   '&#935;'	=> '&Chi;',		// greek capital letter chi
		   '&#936;'	=> '&Psi;',		// greek capital letter psi
		   '&#937;'	=> '&Omega;',	// greek capital letter omega
		   '&#945;'	=> '&alpha;',	// greek small letter alpha
		   '&#946;'	=> '&beta;',	// greek small letter beta
		   '&#947;'	=> '&gamma;',	// greek small letter gamma
		   '&#948;'	=> '&delta;',	// greek small letter delta
		   '&#949;'	=> '&epsilon;',	// greek small letter epsilon
		   '&#950;'	=> '&zeta;',	// greek small letter zeta
		   '&#951;'	=> '&eta;',		// greek small letter eta
		   '&#952;'	=> '&theta;',	// greek small letter theta
		   '&#953;'	=> '&iota;',	// greek small letter iota
		   '&#954;'	=> '&kappa;',	// greek small letter kappa
		   '&#955;'	=> '&lambda;',	// greek small letter lambda
		   '&#956;'	=> '&mu;',		// greek small letter mu
		   '&#957;'	=> '&nu;',		// greek small letter nu
		   '&#958;'	=> '&xi;',		// greek small letter xi
		   '&#959;'	=> '&omicron;',	// greek small letter omicron
		   '&#960;'	=> '&pi;',		// greek small letter pi
		   '&#961;'	=> '&rho;',		// greek small letter rho
		   '&#962;'	=> '&sigmaf;',	// greek small letter final sigma
		   '&#963;'	=> '&sigma;',	// greek small letter sigma
		   '&#964;'	=> '&tau;',		// greek small letter tau
		   '&#965;'	=> '&upsilon;',	// greek small letter upsilon
		   '&#966;'	=> '&phi;',		// greek small letter phi
		   '&#967;'	=> '&chi;',		// greek small letter chi
		   '&#968;'	=> '&psi;',		// greek small letter psi
		   '&#969;'	=> '&omega;',	// greek small letter omega
		   '&#977;'	=> '&thetasym;',	// greek small letter theta symbol
		   '&#978;'	=> '&upsih;',	// greek upsilon with hook symbol
		   '&#982;'	=> '&piv;',		// greek pi symbol
		   '&#8194;'	=> '&ensp;',	// en space
		   '&#8195;'	=> '&emsp;',	// em space
		   '&#8201;'	=> '&thinsp;',	// thin space
		   '&#8204;'	=> '&zwnj;',	// zero width non-joiner
		   '&#8205;'	=> '&zwj;',		// zero width joiner
		   '&#8206;'	=> '&lrm;',		// left-to-right mark
		   '&#8207;'	=> '&rlm;',		// right-to-left mark
		   '&#8211;'	=> '&ndash;',	// en dash
		   '&#8212;'	=> '&mdash;',	// em dash
		   '&#8216;'	=> '&lsquo;',	// left single quotation mark
		   '&#8217;'	=> '&rsquo;',	// right single quotation mark
		   '&#8218;'	=> '&sbquo;',	// single low-9 quotation mark
		   '&#8220;'	=> '&ldquo;',	// left double quotation mark
		   '&#8221;'	=> '&rdquo;',	// right double quotation mark
		   '&#8222;'	=> '&bdquo;',	// double low-9 quotation mark
		   '&#8224;'	=> '&dagger;',	// dagger
		   '&#8225;'	=> '&Dagger;',	// double dagger
		   '&#8226;'	=> '&bull;',	// bullet
		   '&#8230;'	=> '&hellip;',	// horizontal ellipsis
		   '&#8240;'	=> '&permil;',	// per mille sign
		   '&#8242;'	=> '&prime;',	// primeminutes
		   '&#8243;'	=> '&Prime;',	// double prime
		   '&#8249;'	=> '&lsaquo;',	// single left-pointing angle quotation mark
		   '&#8250;'	=> '&rsaquo;',	// single right-pointing angle quotation mark
		   '&#8254;'	=> '&oline;',	// overline
		   '&#8260;'	=> '&frasl;',	// fraction slash
		   '&#8364;'	=> '&euro;',	// euro sign
		   '&#8465;'	=> '&image;',	// blackletter capital I
		   '&#8472;'	=> '&weierp;',	// script capital P
		   '&#8476;'	=> '&real;',	// blackletter capital R
		   '&#8482;'	=> '&trade;',	// trade mark sign
		   '&#8501;'	=> '&alefsym;',	// alef symbol
		   '&#8592;'	=> '&larr;',	// leftwards arrow
		   '&#8593;'	=> '&uarr;',	// upwards arrow
		   '&#8594;'	=> '&rarr;',	// rightwards arrow
		   '&#8595;'	=> '&darr;',	// downwards arrow
		   '&#8596;'	=> '&harr;',	// left right arrow
		   '&#8629;'	=> '&crarr;',	// downwards arrow with corner leftwards
		   '&#8656;'	=> '&lArr;',	// leftwards double arrow
		   '&#8657;'	=> '&uArr;',	// upwards double arrow
		   '&#8658;'	=> '&rArr;',	// rightwards double arrow
		   '&#8659;'	=> '&dArr;',	// downwards double arrow
		   '&#8660;'	=> '&hArr;',	// left right double arrow
		   '&#8704;'	=> '&forall;',	// for all
		   '&#8706;'	=> '&part;',	// partial differential
		   '&#8707;'	=> '&exist;',	// there exists
		   '&#8709;'	=> '&empty;',	// empty set
		   '&#8711;'	=> '&nabla;',	// nabla
		   '&#8712;'	=> '&isin;',	// element of
		   '&#8713;'	=> '&notin;',	// not an element of
		   '&#8715;'	=> '&ni;',		// contains as member
		   '&#8719;'	=> '&prod;',	// n-ary product
		   '&#8721;'	=> '&sum;',		// n-ary sumation
		   '&#8722;'	=> '&minus;',	// minus sign
		   '&#8727;'	=> '&lowast;',	// asterisk operator
		   '&#8730;'	=> '&radic;',	// square root
		   '&#8733;'	=> '&prop;',	// proportional to
		   '&#8734;'	=> '&infin;',	// infinity
		   '&#8736;'	=> '&ang;',		// angle
		   '&#8743;'	=> '&and;',		// logical and
		   '&#8744;'	=> '&or;',		// logical or
		   '&#8745;'	=> '&cap;',		// intersection
		   '&#8746;'	=> '&cup;',		// union
		   '&#8747;'	=> '&int;',		// integral
		   '&#8756;'	=> '&there4;',	// therefore
		   '&#8764;'	=> '&sim;',		// tilde operator
		   '&#8773;'	=> '&cong;',	// approximately equal to
		   '&#8776;'	=> '&asymp;',	// almost equal to
		   '&#8800;'	=> '&ne;',		// not equal to
		   '&#8801;'	=> '&equiv;',	// identical to
		   '&#8804;'	=> '&le;',		// less-than or equal to
		   '&#8805;'	=> '&ge;',		// greater-than or equal to
		   '&#8834;'	=> '&sub;',		// subset of
		   '&#8835;'	=> '&sup;',		// superset of
		   '&#8836;'	=> '&nsub;',	// not a subset of
		   '&#8838;'	=> '&sube;',	// subset of or equal to
		   '&#8839;'	=> '&supe;',	// superset of or equal to
		   '&#8853;'	=> '&oplus;',	// circled plus
		   '&#8855;'	=> '&otimes;',	// circled times
		   '&#8869;'	=> '&perp;',	// up tack
		   '&#8901;'	=> '&sdot;',	// dot operator
		   '&#8968;'	=> '&lceil;',	// left ceiling
		   '&#8969;'	=> '&rceil;',	// right ceiling
		   '&#8970;'	=> '&lfloor;',	// left floor
		   '&#8971;'	=> '&rfloor;',	// right floor
		   '&#9001;'	=> '&lang;',	// left-pointing angle bracket
		   '&#9002;'	=> '&rang;',	// right-pointing angle bracket
		   '&#9674;'	=> '&loz;',		// lozenge
		   '&#9824;'	=> '&spades;',	// black spade suit
		   '&#9827;'	=> '&clubs;',	// black club suit
		   '&#9829;'	=> '&hearts;',	// black heart suit
		   '&#9830;'	=> '&diams;'	// black diam suit
		   );

    // split entities for use in str_replace()
    foreach($codes as  $unicode_entity => $html_entity) {
      $unicode_entities[] = $unicode_entity;
      $html_entities[] = $html_entity;
    }
  }
  // transcode HTML entities to Unicode
  if($to_unicode)
    return str_replace($html_entities, $unicode_entities, $input);

  // transcode Unicode entities to HTML entities
  else
    return str_replace($unicode_entities, $html_entities, $input);
}

/**
 * transcode multi-byte characters to HTML representations for Unicode
 *
 * This function is aiming to preserve Unicode characters through storage in a ISO-8859-1 compliant system.
 *
 * Every multi-byte UTF-8 character is transformed to its equivalent HTML numerical entity (eg, &amp;#4568;)
 * that may be handled safely by PHP and by MySQL.
 *
 * Of course, this solution does not allow for full-text search in the database and therefore, is not a
 * definitive solution to internationalization issues.
 * It does enable, however, practical use of Unicode to build pages in foreign languages.
 *
 * Also, this function transforms HTML entities into their equivalent Unicode entities.
 * For example, w.bloggar posts pages using HTML entities.
 * If you have to modify these pages using web forms, you would like to get UTF-8 instead.
 *
 * @link http://www.evolt.org/article/A_Simple_Character_Entity_Chart/17/21234/ A Simple Character Entity Chart
 *
 * @param string the original UTF-8 string
 * @return a string acceptable in an ISO-8859-1 storage system (ie., PHP4 + MySQl 3)
 */
function to_unicode($input) {
  // transcode HTML entities to Unicode entities
  $input = transcode($input);
  // scan the whole string
  $output = '';
  $index = 0;
  while($index < strlen($input)) {
    // look at one char
    $char = ord($input[$index]);
    // one byte (0xxxxxxx)
    if ($char < 0x80) {
      // some chars may be undefined
      $output .= chr($char);
      $index += 1;
      // two bytes (110xxxxx 10xxxxxx)
    } else if ($char < 0xE0) {
      // strip weird sequences (eg, C0 80 -> NUL)
      if($value = (($char % 0x20) * 0x40) + (ord($input[$index + 1]) % 0x40))
	$output .= '&#' . $value . ';';
      $index += 2;
      // three bytes (1110xxxx 10xxxxxx 10xxxxxx) example: euro sign = \xE2\x82\xAC -> &#8364;
    } else if ($char < 0xF0) {
      // strip weird sequences
      if($value = (($char % 0x10) * 0x1000) + ((ord($input[$index + 1]) % 0x40) * 0x40) + (ord($input[$index + 2]) % 0x40))
	$output .= '&#' . $value . ';';
      $index += 3;
      // four bytes (11110xxx 10xxxxxx 10xxxxxx 10xxxxxx)
    } else if($char < 0xF8) {
      // strip weird sequences
      if ($value = (($char % 0x08) * 0x40000) + ((ord($input[$index + 1]) % 0x40) * 0x1000) + ((ord($input[$index + 2]) % 0x40) * 0x40)
	 + (ord($input[$index + 3]) % 0x40))
	$output .= '&#' . $value . ';';
      $index += 4;
      // five bytes (111110xx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx)
    } else if($char < 0xFC) {
      // strip weird sequences
      if ($value = (($char % 0x04) * 0x1000000) + ((ord($input[$index + 1]) % 0x40) * 0x40000) + ((ord($input[$index + 2]) % 0x40) * 0x1000)
	 + ((ord($input[$index + 3]) % 0x40) * 0x40) + (ord($input[$index + 4]) % 0x40))
	$output .= '&#' . $value . ';';
      $index += 5;
      // six bytes (1111110x 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx)
    } else {
      // strip weird sequences
      if ($value = (($char % 0x02) * 0x40000000) + ((ord($input[$index + 1]) % 0x40) * 0x1000000) + ((ord($input[$index + 2]) % 0x40) * 0x40000)
	 + ((ord($input[$index + 3]) % 0x40) * 0x1000) + ((ord($input[$index + 4]) % 0x40) * 0x40) + (ord($input[$index + 4]) % 0x40))
	$output .= '&#' . $value . ';';
      $index += 6;
    }
  }
  // return the translated string
  return $output;
}

// returns either the translated string or the original string.
// Assumes we are passed the original string as occurs in text; result
// will be html tokenized by htmlentities() using UTF8.
// $i18nHTMLhasTranslation is set to nonzero value if a translation is
// available or failure connecting to database, otherwise it is set to
// 0.
function translation_query($a) {
  global $connection;
  global $lang;
  global $i18nHTMLrecordMode;
  global $i18nHTMLhasTranslation;
  global $i18nHTMLsqlPrefix;
  global $i18nHTMLsrcLang;

  $i18nHTMLhasTranslation = 1; // assume translation until failure

  if ($a == "")
    return $a;
  $a = fix($a);
  $a_sql = quote_smart($a);
  if (!$connection) {
    // database not available, just print English
    return $a;
  }

  if ($i18nHTMLsrcLang == $lang) {
    // no need to translate english, that's the
    // hard-wired source language!
    if ($i18nHTMLrecordMode == 2) {
      // if not already in pending table (and recordMode set to allow us)
      // then insert this string into it
      $query = "SELECT count FROM ${i18nHTMLsqlPrefix}pending WHERE c=\"$a_sql\" AND lang=\"$lang\"";
      $result = mysql_query($query, $connection);
      $num = 0;
      if ($result)
        $num = mysql_num_rows($result);
      if (0 == $num) {
        $query = "INSERT INTO ${i18nHTMLsqlPrefix}pending VALUES(\"$a_sql\", \"$lang\", 0)";
        mysql_query($query, $connection);
      }
    }
    return $a;
  }
  // attempt to get translation
  $query = "SELECT translation FROM ${i18nHTMLsqlPrefix}map WHERE name=\"$a_sql\" AND lang=\"$lang\"";
  $result = mysql_query($query, $connection);
  $num = 0;
  if ($result)
    $num = mysql_num_rows($result);
  if (0 == $num) {  // didn't find a translation
    if ($i18nHTMLrecordMode > 0) {
      // either insert untranslated item into pending table or update
      // referenced count; count is used to display more used strings
      // during mass translation before less common ones.
      $query = "SELECT count FROM ${i18nHTMLsqlPrefix}pending WHERE c=\"$a_sql\" AND lang=\"$lang\"";
      $result = mysql_query($query, $connection);
      $num = 0;
      if ($result)
        $num = mysql_numrows($result);
      $count = 0;
      if ($num > 0) {
        $row = mysql_fetch_array($result);
        $count = $row["count"] + 1;
        $query = "UPDATE $i18nHTMLsqlPrefix{pending} SET count=$count WHERE c=\"$a_sql\" AND lang=\"$lang\"";
      } else {
        $query = "INSERT INTO ${i18nHTMLsqlPrefix}pending VALUES(\"$a_sql\", \"$lang\", 1)";
      }
      mysql_query($query, $connection);

    }
    $i18nHTMLhasTranslation = 0; // no translation was found
    return $a;              // just return English string
  } else { // translation available

    $row = mysql_fetch_array($result);
    return $row["translation"];
  }
}

// *************************************************
// Fundamental i18nHTML API functions
// *************************************************

// translate the sentence $a and return the result.
function TRANSLATE_($a,$args=null) {
  if ($a == "")
    return 0;
  return vsprintf(translation_query($a), $args);
}

// translate the sentence $a and output just
// the translated text (without link to translate.php)
function TRANSLATE($a,$args=null) {
  echo TRANSLATE_($a);
}

// translate the sentence $a adding a link
// to enable editing translations and return the result.
function W_($a,$args=null) {
  if ($a == "")
    return 0;
  return TRANSLATE_($a,$args) . translateLink_($a);
}

// translate the sentence $a appending a link
// to enable edit the translation and output the
// result.
function W($a, $args=NULL) {
  if ($a != "")
    echo W_($a, $args) . "\n";
}

// create internationalized, internal link to
// $a.php with description $b
function intlink_($a, $b) {
  global $lang;

  $ret = "<a href=\"${a}?xlang=$lang\">" . TRANSLATE_($b) . "</a>";
  $ret = $ret . translateLink_($b);
  return $ret;
}

// create internationalized, internal link to
// $a.php with description $b
function intlink($a, $b) {
  echo intlink_($a, $b);
}

// create internationalized, external link to
// $a with description $b
function extlink_($a, $b) {
  $ret = "<a href=\"${a}\">" . TRANSLATE_($b) . "</a>" . translateLink_($b);
  return $ret;
}

// create internationalized, external link to
// $a with description $b
function extlink($a, $b) {
  echo extlink_($a, $b);
}

// create internationalized, external link to
// $a with description $b and title $c
function extlink_title_($a, $b, $c) {
  $ret = "<a href=\"${a}\" title=\"" . TRANSLATE_($c) . "\">" . TRANSLATE_($b) . "</a>" . translateLink_($b) . translateLink_($c);
  return $ret;
}

// create internationalized, external link to
// $a with description $b and title $c
function extlink_title($a, $b, $c) {
  echo extlink_title_($a, $b, $c);
}


// *************************************************
// global, call-once helper functions
// *************************************************

// outputs appropriate DOCTYPE declaration for the document
// this should be the 1st line in your php file after including
// i18nhtml.inc.  Valid types are: HTML for HTML 4 documents,
// XHTML1 for xhtml 1.0 documents, and XHTML1.1 for xhtml 1.1
// defaulting to HTML4 if $type is blank or unknown.  An optional
// $mode may be specified, it must be one of "Transitional",
// "Strict", or "Frameset", defaulting to "Transitional".
// Note for XHTML1.1 $mode is ignored.
// example:
//           include("i18nhtml.inc");
//           DOCTYPE("XHTML1");
function DOCTYPE($type=null, $mode=null) {
  // depending on $mode, use appropriate dtd
  if ($mode == "Strict") {
    $dtd = "strict";
    if ($type != "XHTML1") // Strict not specified except for XHTML1.0
      $mode = "";
  } else if ($mode == "Frameset") {
    $dtd = "frameset";
  } else { // $mode == Transitional, default, or unknown
    $dtd = "loose";
    $mode = "Transitional";
  }
  if ($type == "XHTML1")
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 " . $mode . 
         "//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-" . $dtd . ".dtd\">\n";
  else if ($type == "XHTML1.1")
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
  else
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 " . $mode . 
         "//EN\" \"http://www.w3.org/TR/html4/" . $dtd . ".dtd\">\n";
}

function TITLE($a,$b="") {
  global $lang;
  global $languagecodes;
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" >";
  echo "<title>" . TRANSLATE_($a,$b) . "</title>\n";
  if (isset($languagecodes[$lang])) {
    echo "<meta name=\"content-language\" content=\"" .
         $languagecodes[$lang] . "\">";
    echo "<meta name=\"language\" content=\"" .
         $languagecodes[$lang] . "\">";
  }
}

// displays a list of all languages currently available with
// at least 1 translated string.
function generateLanguageBar() {
  global $connection;
  global $i18nHTMLsqlPrefix;
  global $i18nHTMLsrcLang;

  if ($connection) {
    $query = "SELECT lang FROM ${i18nHTMLsqlPrefix}languages ORDER BY lang";
    $result = mysql_query($query, $connection);
    $num = 0;
    if ($result)
      $num = mysql_numrows($result);
    echo "<center>[<a href=\"?xlang=${i18nHTMLsrcLang}\">" . W_($i18nHTMLsrcLang) . "</a>";
    while ($num-- > 0) {
      $row = mysql_fetch_array($result);
      $next = $row["lang"];
      if ($next == $i18nHTMLsrcLang)
	continue;
      echo " | <a href=\"?xlang=$next\">" . W_($next) . "</a>";
    }
    echo "]</center>";
  }
}


// displays text at the bottom of the page to indicate
// translation mode (including link to active) and
// copyright notice for i18nHTML.
function generateFooter() {
  global $xlang;
  global $editor;
  global $HTTP_SERVER_VARS;
  global $i18nHTMLsrcLang;
  global $i18nHTMLbase;

  P();
  echo "Translation engine based on <a href=\"http://gnunet.org/i18nHTML/\">i18nHTML</a> (C) 2003, 2004, 2005, 2006, 2007 <a href=\"http://grothoff.org/christian/\">Christian Grothoff</a>.<br />\n";
  if ( ($xlang) && ($xlang != $i18nHTMLsrcLang) ) {
    $protocol = "http";
    if ($HTTP_SERVER_VARS["HTTPS"] == "on") {
       $protocol = "https"; // switch to https
    }
    $back = $protocol . "://" . $HTTP_SERVER_VARS["HTTP_HOST"] . $HTTP_SERVER_VARS["REQUEST_URI"];
    echo "<center><small>\n";
    if ($editor != 1)
      echo " <a href=\"$back&amp;editor=1\">" . W_("enter translation mode") . "</a>";
    else
      W(" Translation Mode Active (for this page only)");
    echo "&nbsp;&nbsp;&nbsp;";
    intlink($i18nHTMLbase, "go to i18nHTML administration page");
    echo "</small></center>\n";
  } else {
    echo "<center><small>\n";
    intlink($i18nHTMLbase, "go to i18nHTML administration page");
    echo "</small></center>\n";
  }
  echo "</p>\n";
}



// *************************************************
// HTML construct helper functions
// *************************************************

function LI($a,$b="") {
  echo "<li>" . W_($a,$b) . "</li>\n";
}
function TH($a,$b="") {
  echo "<th>" . W_($a,$b) . "</th>\n";
}
function TD($a,$b="") {
  echo "<td>" . W_($a,$b) . "</td>\n";
}
function DT($a,$b="") {
  echo "<dt>" . W_($a,$b) . "</dt>\n";
}
function DD($a,$b="") {
  echo "<dd>" . W_($a,$b) . "</dd>\n";
}
function H1($a,$b="") {
  echo "<h1>" . W_($a,$b) . "</h1>\n";
}
function H2($a,$b="") {
  echo "<h2>" . W_($a,$b) . "</h2>\n";
}
function H3($a,$b="") {
  echo "<h3>" . W_($a,$b) . "</h3>\n";
}
function H4($a,$b="") {
  echo "<h4>" . W_($a,$b) . "</h4>\n";
}
function H5($a,$b="") {
  echo "<h5>" . W_($a,$b) . "</h5>\n";
}
function PRE($a) {
  echo "<pre>" . $a . "</pre>";
}
// 'verbatim' (untranslated) "li"
function LIV($a) {
  echo "<li>" . $a . "</li>\n";
}
function BP($attr="") {
  echo "<p $attr>\n";
}
function EP() {
  echo "</p>\n";
}
function BOL($attr="") {
  echo "<ol $attr>\n";
}
function EOL() {
  echo "</ol>\n";
}
function P($attr="") {
  EP();
  BP($attr);
}
function BR($attr="") {
  echo "<br $attr/>\n";
}
function HR() {
  echo "<hr/>\n";
}
function DTDD($a,$b,$args=null) {
  DT($a);
  DD($b,$args);
}
function LILI($a,$b) {
  if ( ($a[0] == '#') ||
       ( ($a[0] == 'h') &&
         ($a[1] == 't') &&
         ($a[2] == 't') &&
         ($a[3] == 'p') ) ) {
    echo "<li>" . extlink_($a,$b) . "</li>\n";
  } else {
    echo "<li>" . intlink_($a,$b) . "</li>\n";
  }
}
function ANCHOR($a) {
  echo "<a name=\"$a\"></a>\n";
}
function IMG_($src, $alt, $align="CENTER", $width, $height, $border=0, $hspace=0, $vspace=0) {
  $ret = "";

  if ($align == "CENTER")
    $ret = $ret . "<p><center>\n";
  $ret = $ret . "<img src=\"" . $src . "\" alt=\"";
  $ret = $ret . TRANSLATE_($alt);
  $ret = $ret . "\" align=\"" . $align . "\" width=$width height=$height border=$border hspace=$hspace vspace=$vspace>\n";
  $ret = $ret . translateLink_($alt);
  if ($align == "CENTER")
    $ret = $ret . "</center></p>\n";
  return $ret;
}
function IMG($src, $alt, $align="CENTER", $width, $height, $border=0, $hspace=0, $vspace=0) {
  echo IMG_($src, $alt, $align, $width, $height, $border, $hspace, $vspace);
}
?>
