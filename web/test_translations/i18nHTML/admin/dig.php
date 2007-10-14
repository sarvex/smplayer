<?php
/*
     (C) 2007 Christian Grothoff

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
include_once("i18nHTML/i18nhtml.php");
include_once("login.php");
$mode = $_REQUEST['mode'];
DOCTYPE("HTML", "Transitional");
echo "<html><head>\n";
TITLE("i18nHTML administration: searching for bad translations");
echo "</head><body>";
if ($level <= 0) {
  W("This page requires higher-level access priviledges."); 
  generateFooter();
  echo "</body></html>";
  die();
 }
BP();
W("Using heuristic %s.", $mode);
BR();
W("The worst offenders (acccording to the selected heuristic) are shown towards the beginning of the table.");
EP();

$data = ARRAY();
$xcond = "";
// allow limiting by ip
if ($_REQUEST['ip']) {
  $cleanip = mysql_real_escape_string($_REQUEST['ip']);
  $xcond = $xcond . "AND ip='$cleanip' ";
}
// allow limiting by user id
if ($_REQUEST['tuid']) {
  $cleanuid = mysql_real_escape_string($_REQUEST['tuid']);
  $xcond = $xcond . "AND uid='$cleanuid' ";
}
$query = "SELECT name,ip,translation,uid,tid FROM ${i18nHTMLsqlPrefix}map WHERE lang=\"${lang}\"${xcond} ORDER BY name";
$result = mysql_query($query, $connection);
$hidden = 0;
$perfect = 0;
$num = 0;
$alpha = 1;
if ($result)
  $num = mysql_numrows($result);
while ($num-- > 0) {
  $row = mysql_fetch_array($result);
  if (! $row) 
    continue; // oops!?
  $text = stripslashes($row["name"]);
  $translation = stripslashes($row["translation"]);
  $truid = $row["uid"];
  $tid = $row["tid"];
  $ipaddr = $row["ip"];
  if (! is_numeric($tid))
    continue; // oops!?

  $query2 = "SELECT level FROM ${i18nHTMLsqlPrefix}accounts WHERE uid=${truid}";
  $result2 = mysql_query($query2, $connection);
  $ok = 1;
  if ($result2) {
    $num = mysql_numrows($result2);
    if ($num == 1) {
      $row = mysql_fetch_array($result2);
      $trlevel = $row["level"];
      if ( ($level <= $trlevel) &&
	   ($uid != $truid) )
	$ok = 0; // insufficient level!
    }
  }
  if ($ok == 0) {
    $hidden++;
    continue; // not high-enough level, do not show
  }

  $score = 0;
  switch($mode) {
  case "wwcd": // weighted word-count distance
    if ( ($text == "") || ($translation == "") ) {
      $score = 999999;
    } else {
      $wc1 = count(explode(" ", $text));
      $wc2 = count(explode(" ", $translation));
      $dist = $wc1 - $wc2;
      if ($wc1 == 0)
	$wc1 = 1; // avoid division by zero
      $score = 1000 * $dist * $dist / $wc1;
    }
    break;
  case "wccd": // weighted character-count distance
    $wc1 = strlen($text);
    $wc2 = strlen($translation);
    $dist = $wc1 - $wc2;
    if ($wc1 == 0)
      $wc1 = 1; // avoid division by zero
    $score = 1000 * ($dist * $dist) / $wc1;
    break;
  case "wlmc": // weighted average word-length mismatch
    if ( ($text == "") || ($translation == "") ) {
      $score = 999999;
    } else {
      $e1 = explode(" ", $text);
      $e2 = explode(" ", $translation);
      $l1 = array_map("strlen", $e1);
      $l2 = array_map("strlen", $e2);
      $t1 = array_sum($l1);
      $t2 = array_sum($l2);
      $a1 = $t1 / count($e1);
      $a2 = $t2 / count($e2);
      $dist = $a1 - $a2;
      $score = $dist * $dist;
    }
    break;
  case "psmc": // percent sign mismatch counts
    if ( ($text == "") || ($translation == "") ) {
      $score = 999999;
    } else {
      $e1 = explode("%", $text);
      $e2 = explode("%", $translation);
      $total = 0;    
      for ($pos=1;$pos<count($e1);$pos++) {
	$t1 = $e1[$pos];
	if (! isset($e2[$pos])) {
	  $total++;
	  continue;
	}
	$t2 = $e2[$pos];
	// first character after "%" should match
	if ( (strlen($t1) > 0) && 
	     (strlen($t2) > 0) && 
	     ($t1[0] != $t2[0]) ) {
	  $total++;
	}
      }
      $score = $total;
    }
  case "punc": // punctuation mismatch counts
    if ( ($text == "") || ($translation == "") ) {
      $score = 999999;
    } else {
      $cc1 = count_chars($text, 0);
      $cc2 = count_chars($translation, 0);
      $total = 0;    
      $puncts = ARRAY('.',',','!','?',';','\"','\'','`',':','-','=','+','-','(',')','*');
      foreach ($puncts as $punct) {	
	$t1 = $cc1[ord($punct)];
	$t2 = $cc2[ord($punct)];
	$del = $t1 - $t2;
	$total += $del * $del;
      }
      $score = 1000 * $total / strlen($text);
    }
    break;
  case "totc": // total number of contributed translations    
    $query2 = "SELECT tid FROM ${i18nHTMLsqlPrefix}map WHERE ";
    if ($truid == 2) 
      $query2 = $query2 . "ip=\"$ipaddr\" AND uid=$truid";
    else
      $query2 = $query2 . "uid=$truid";
    $result2 = mysql_query($query2, $connection);     
    $score = 1;
    if ($result2)
      $score += mysql_numrows($result2);
    break;
  case "alpha":
  default:
    $score = $alpha++; // alphabetical ordering
    break;
  }
  $entry = "<tr><td><table border=0><tr><td>&quot;$text&quot;</td></tr>\n" . 
           "<tr><td>&quot;$translation&quot;</td></tr></table></td>\n" . 
           "<td><a href=\"dig.php?mode=$mode&tuid=$truid&xlang=$lang\">$truid</a>/" . 
               "<a href=\"dig.php?mode=$mode&ip=$ipaddr&xlang=$lang\">$ipaddr</a></td>\n" .
           "<td>$score</td>\n" .
           "<td><input type=\"checkbox\" name=\"tid${tid}\" value=\"1\" /></td></tr>"; 
  if (isset($data[$score]))
    $entries = $data[$score];
  else
    $entries = ARRAY();
  $entries[] = $entry;
  if ($score > 0)
    $data[$score] = $entries;
  else
    $perfect++;
}
// sort results
switch($mode) {
 case "alpha":
 case "totc":
   ksort($data);
   break;
 default:
   krsort($data);
   break;
 }
H2("Translations to ${lang}");
echo "<form name=\"dig_form\" method=\"post\" action=\"delete.php?xlang=${lang}\">\n";
echo "<table border='5'>\n";
echo "<tr>";
TH("Original and Translation");
TH("Translator");
TH("Score");
TH("Delete");
echo "</tr>\n";
foreach ($data as $score => $entries) {
  foreach ($entries as $entry) {
    echo $entry;
  }
}
echo "</table>\n";
BR();
echo "<input type=\"submit\" class=\"button\" value=\"";
TRANSLATE("Delete selected translations");
echo "\"/>";
echo "</form>\n";
BP();
if ($_REQUEST['tuid']) {
  $truid = mysql_real_escape_string($_REQUEST['tuid']);
  $query2 = "SELECT username, realname FROM ${i18nHTMLsqlPrefix}accounts WHERE uid=${truid}";
  $result2 = mysql_query($query2, $connection);
  $ok = 1;
  if ($result2) {
    $num = mysql_numrows($result2);
    if ($num == 1) {
      $row = mysql_fetch_array($result2);
      W("Translations shown were limited to user <tt>%s</tt> (real name `%s')",
	ARRAY($row["username"],
	      $row["realname"]));     
    }
  }
}
if ($hidden > 0) 
  W("Did not show %s translations due to insufficient level of user.",
    $hidden); 
BR();
if ($perfect > 0)
  W("Did not show %s translations due to perfect proximity score.",
    $perfect);
EP();
HR();
generateFooter();
echo "</body></html>";
?>