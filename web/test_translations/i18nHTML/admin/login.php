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
// login management
include_once("i18nHTML/i18nhtml.php");
session_start();
if (isset($_POST['username']))
  $_SESSION['username'] = $_POST['username'];
if (isset($_POST['password']))
  $_SESSION['password'] = $_POST['password'];
$uid = -1;
$level = -1;
if ( (isset($_SESSION['username'])) &&
     (isset($_SESSION['password'])) ) {
  $username =  mysql_real_escape_string($_SESSION['username']);
  $password =  mysql_real_escape_string(crypt($_SESSION['password'], "salty"));
  $query = "SELECT allowed,uid,level FROM " . $i18nHTMLsqlPrefix . 
           "accounts WHERE username=\"$username\" AND password=\"$password\" AND level >= 0";
  $result = mysql_query($query, $connection);
  $num = 0;
  if ($result)
    $num = mysql_numrows($result);
  $count = 0;
  while ($num > 0) {
    $row = mysql_fetch_array($result);
    $allowed = $row["allowed"];
    if ( ($allowed == $lang) ||
	 ($allowed == $i18nHTMLsrcLang) ) {
      $uid = $row["uid"];
      $level = $row["level"];
      break;
    }
    $num--;
  }  
  if ($uid == -1) 
    $error_message = W_("Invalid login or password for selected language!");
 }
if ($uid == -1) {
  include("login_form.php");
  exit();
}
?>