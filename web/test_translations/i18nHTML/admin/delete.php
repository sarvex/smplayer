<?php
/*
     (C) 2006, 2007 Christian Grothoff

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
include("login.php");
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("i18nHTML translation deletion");
echo "</head><body>";
session_start();

$success = 0;
$updated = 0;
$total = 0;
$utotal = 0;

foreach ($_POST as $postval => $selected) {
  if ( ($selected == 1) &&
       (strstr($postval, "tid") == $postval) ) {
    $total++;
    $tid = substr($postval, 3);
    if (! is_numeric($tid)) 
      continue;
    $query = "SELECT uid FROM ${i18nHTMLsqlPrefix}map WHERE tid=${tid}";
    $result = mysql_query($query, $connection);
    if (! $result) 
      continue;    
    $num = mysql_numrows($result);
    if ($num != 1) 
      continue; // oops! Primary key not unique!?
    $row = mysql_fetch_array($result);
    $truid = $row["uid"];
    $query = "SELECT level FROM ${i18nHTMLsqlPrefix}accounts WHERE uid=${truid}";
    $result = mysql_query($query, $connection);
    $ok = 1;
    if ($result) {
      $num = mysql_numrows($result);
      if ($num == 1) {
	$row = mysql_fetch_array($result);
	$trlevel = $row["level"];
	if ( ($level <= $trlevel) &&
	     ($uid != $truid) )
	  $ok = 0; // insufficient level!
      }
    }
    if (! $ok) 
      continue; // refuse!    
    $query = "DELETE FROM ${i18nHTMLsqlPrefix}map WHERE tid=${tid}";
    mysql_query($query, $connection);
    $success++;
  } // if delete operation



  if (strstr($postval, "eid") == $postval) {
    $tid = substr($postval, 3);
    if (! is_numeric($tid)) 
      continue;
    $query = "SELECT uid,translation FROM ${i18nHTMLsqlPrefix}map WHERE tid=${tid}";
    $result = mysql_query($query, $connection);
    if (! $result) 
      continue;    
    $num = mysql_numrows($result);
    if ($num != 1) 
      continue; // oops! Primary key not unique!?
    $row = mysql_fetch_array($result);
    $truid = $row["uid"];
    $oldtrans = $row["translation"];
    $etran = fix(to_unicode($selected));
    if ($etran == $oldtrans)
      continue;
    $utotal++;
    
    $etran = mysql_real_escape_string($etran);
    $query = "SELECT level FROM ${i18nHTMLsqlPrefix}accounts WHERE uid=${truid}";
    $result = mysql_query($query, $connection);
    $ok = 1;
    if ($result) {
      $num = mysql_numrows($result);
      if ($num == 1) {
	$row = mysql_fetch_array($result);
	$trlevel = $row["level"];
	if ( ($level <= $trlevel) &&
	     ($uid != $truid) )
	  $ok = 0; // insufficient level!
      }
    }
    if (! $ok) 
      continue; // refuse!    
    $query = "UPDATE ${i18nHTMLsqlPrefix}map SET translation=\"${etran}\" WHERE tid=${tid}";
    // mysql_query($query, $connection);
    $updated++;
  } // if update operation

} // for all POSTs
BP();
W("Successfully deleted %s translations.",
  $success);
if ($success != $total)
  W("Note that some deletions failed.");
W("Successfully updated %s translations.",
  $updated);
if ($updated != $utotal)
  W("Note that some updates failed.");
EP();
generateFooter();
echo "</body></html>\n";
?>