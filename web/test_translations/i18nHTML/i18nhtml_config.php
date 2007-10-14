<?php
/*
     (C) 2003, 2004, 2006 Christian Grothoff

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

// Use this file to configure i18nHTML

/**
 * 0: disable recording of translation requests
 * 1: record only missing translations
 * 2: keep full statistics about translation use
 *
 * This option is useful if you need more performance for
 * your server due to high load (i.e. slashdotting).
 */
$i18nHTMLrecordMode = 2; 

/**
 * On which machine is the MySQL server with our translations running?
 */
$i18nHTMLsqlServer = "mysql4-s";

/**
 * Username for MySQL access.
 */
$i18nHTMLsqlUser = "s185512admin";

/**
 * Password for MySQL access.
 */
$i18nHTMLsqlPass = "smplayer";

/**
 * Password for i18nHTML web admin access.
 */
$i18nHTMLsqlAdminPass = "pass";

/**
 * Prefix to all SQL table names used by i18nHTML.
 */
$i18nHTMLsqlPrefix = "i18nHTML"; 

/**
 * Name of the MySQL database to use.
 */
$i18nHTMLsqlDB = "s185512_translations"; 

/**
 * base directory prepended to i18nHTML php pages used
 * in links.  Your webserver should have the files from 
 * the "admin/" directory installed at this location.
 *
 * Must end with a "/" (and must be a directory).
 */
$i18nHTMLbase = "http://" . @php_uname('n') . "/i18nhtml/"; 

/**
 * What marker should be used for untranslated sentences?
 */
$i18nHTMLmarker = "*";  

/**
 * Language of the source text (cannot be translated to).
 */
$i18nHTMLsrcLang = "English";

?>
