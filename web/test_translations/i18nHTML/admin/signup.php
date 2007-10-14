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
function mkpass($length = 8) {
  $password = "";
  $possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 
  $i = 0; 
  while ($i < $length) { 
    $password .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
    $i++;
  }
  return $password;
}

session_start();
if (isset($_POST['username']))
  $_SESSION['username'] = $_POST['username'];
if (isset($_POST['email']))
  $_SESSION['email'] = $_POST['email'];
if (isset($_POST['language']))
  $_SESSION['language'] = $_POST['language'];
if (isset($_POST['realname']))
  $_SESSION['realname'] = $_POST['realname'];

include_once("i18nHTML/i18nhtml.php");
DOCTYPE("HTML", "Transitional");
echo "<html><head>";
TITLE("i18nHTML account creation");
echo "</head><body>";
H2("i18nHTML account creation");

if ( (isset($_SESSION['username'])) &&
     (isset($_SESSION['language'])) &&
     (isset($_SESSION['email'])) ) {
  $login    =  mysql_real_escape_string($_SESSION['username']);
  $language =  mysql_real_escape_string($_SESSION['language']);
  $email    =  mysql_real_escape_string($_SESSION['email']);
  $realname =  mysql_real_escape_string($_SESSION['realname']);
  $password =  mkpass();

  if ($language == $i18nHTMLsrcLang) {
    W("You must use the MySQL prompt to create accounts that will work for all languages.");
    die();
  }

  $query = "SELECT lang FROM ${i18nHTMLsqlPrefix}languages WHERE lang=\"$language\";";
  $result = mysql_query($query, $connection);     
  $num = 0;
  if ($result)
    $num = mysql_numrows($result);
  if ($num == 0) {
    W("This language is not legal for this system.");
    W("You may want to ask the operator to add it to the set of legal languages.");
  } else {
    $query = "SELECT realname FROM ${i18nHTMLsqlPrefix}accounts WHERE username=\"$login\";";
    $result = mysql_query($query, $connection);     
    $num = 0;
    if ($result)
      $num = mysql_numrows($result);
    if ($num > 0) {
      $row = mysql_fetch_array($result);
      W("Somebody with the name '%s' is already using this login.  Please try another login.\n",
	$row['realname']);
    } else {
      if (mail($email, 
	       "Your i18nHTML password", 
	       "Somebody, possibly you, requested an i18nHTML\naccount $login for translations\n into $lang.\n\n" .
	       "If this was not you, ignore this e-mail.\n\n" .
	       "Otherwise, your password is '$password'.\n" .
	       "You may want to preserve this e-mail\n" .
	       "since i18nHTML does not allow you to\n" .
	       "recover or change your password later.")) {
	$password = mysql_real_escape_string($password);
	$password = crypt($password, "salty");
	$query = "INSERT INTO ${i18nHTMLsqlPrefix}accounts (username,password,realname,allowed,level) VALUES(\"$login\",\"$password\",\"$realname\",\"$language\",0);";
	mysql_query($query, $connection);     
	W("E-mail with password sent, login %s.\n",
	  extlink_("login.php?xlang=$language", "here"));
      } else {
	W("Failed to sent E-mail with password.\n");
      }
    }
  }
}
generateFooter();
echo "</body></html>\n";
?>