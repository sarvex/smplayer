<?php

/*
// Determine what locale to use
switch (PHP_OS)
{
	case 'WINNT':
	case 'WIN32':
		$locale = 'english';
		break;

	case 'FreeBSD':
	case 'NetBSD':
	case 'OpenBSD':
		$locale = 'en_US.US-ASCII';
		break;

	default:
		$locale = 'en_US';
		break;
}

// Attempt to set the locale
setlocale(LC_CTYPE, $locale);
*/

// Language definitions for frequently used strings
$lang_common = array(

// Text orientation and encoding
'lang_direction'		=>	'ltr',	// ltr (Left-To-Right) or rtl (Right-To-Left)
'lang_encoding'			=>	'iso-8859-1',
'lang_multibyte'		=>	false,

// Notices
'Bad request'			=>	'Ung�ltige Anfrage. Der Link dem Sie gefolgt sind ist ung�ltig oder veraltet.',
'No view'				=>	'Sie haben keine Berechtigung diese Seite zu betrachten.',
'No permission'			=>	'Sie haben keine Berechtigung f�r den Zugriff auf diese Seite.',
'Bad referrer'			=>	'Ung�ltiger HTTP_REFERER. Sie wurden von einer ung�ltigen Quelle auf dieses Forum weitergeleitet. Bitte gehen Sie zur�ck und versuchen Sie es noch einmal. Wenn dieses Problem weiter besteht kontrollieren Sie bitte die \\\'Base URL\\\' Variable unter Admin/Options und stellen Sie sicher, dass Sie dieses Forum �ber diese URL ansteuern. F�r weitere Informationen �ber den Verweis-Check entnehmen Sie bitte der PunBB-Dokumentation.',

// Topic/forum indicators
'New icon'				=>	'Es gibt neue Beitr�ge',
'Normal icon'			=>	'<!-- -->',
'Closed icon'			=>	'Dieses Thema ist geschlossen',
'Redirect icon'			=>	'Umadressiertes Forum',

// Miscellaneous
'Announcement'			=>	'Ank�ndigung',
'Options'				=>	'Beitragsoptionen',
'Actions'				=>	'Aktionen',
'Submit'				=>	'Absenden',	// "name" of submit buttons
'Ban message'			=>	'Sie sind in diesem Forum gesperrt.',
'Ban message 2'			=>	'Die Sperre l�uft aus am',
'Ban message 3'			=>	'Der Administrator oder Moderator, der Sie gesperrt hat, hat folgende Nachricht hinterlassen:',
'Ban message 4'			=>	'Wenn Sie Fragen haben kontaktiren Sie bitte die Administratoren unter',
'Never'					=>	'Nie',
'Today'					=>	'Heute',
'Yesterday'				=>	'Gestern',
'Info'					=>	'Info',		// a common table header
'Go back'				=>	'Zur�ck',
'Maintenance'			=>	'Wartung',
'Redirecting'			=>	'Leite weiter',
'Click redirect'		=>	'Klicken Sie hier, wenn Sie nicht l�nger warten wollen (oder Ihr Browser Sie nicht weiterleitet)',
'on'					=>	'an',		// as in "BBCode is on"
'off'					=>	'aus',
'Invalid e-mail'		=>	'Die angegebene E-Mail Adresse ist ung�ltig.',
'required field'		=>	'ist erforderlich in diesem Forumlar.',	// for javascript form validation
'Last post'				=>	'Letzter Beitrag',
'by'					=>	'von:',	// as in last post by someuser
'New posts'				=>	'Neuer�Beitrag',	// the link that leads to the first new post (use &nbsp; for spaces)
'New posts info'		=>	'Gehe zum ersten neuen Beitrag in diesem Thema.',	// the popup text for new posts links
'Username'				=>	'Benutzername',
'Password'				=>	'Passwort',
'E-mail'				=>	'E-Mail',
'Send e-mail'			=>	'E-Mail senden',
'Moderated by'			=>	'Moderiert durch',
'Registered'			=>	'Registriert',
'Subject'				=>	'Betreff',
'Message'				=>	'Beitrag',
'Topic'					=>	'Thema',
'Forum'					=>	'Forum',
'Posts'					=>	'Beitr�ge',
'Replies'				=>	'Antworten',
'Author'				=>	'Autor',
'Pages'					=>	'Seiten',
'BBCode'				=>	'BBCode',	// You probably shouldn't change this
'img tag'				=>	'[img] Tag',
'Smilies'				=>	'Smilies',
'and'					=>	'und',
'Image link'			=>	'Bild',	// This is displayed (i.e. <image>) instead of images when "Show images" is disabled in the profile
'wrote'					=>	'schrieb',	// For [quote]'s
'Code'					=>	'Code',		// For [code]'s
'Mailer'				=>	'Mailer',	// As in "MyForums Mailer" in the signature of outgoing e-mails
'Important information'	=>	'Wichtige Information',
'Write message legend'	=>	'Schreiben Sie hier Ihren Beitrag',

// Title
'Title'					=>	'Titel',
'Member'				=>	'Mitglied',	// Default title
'Moderator'				=>	'Moderator',
'Administrator'			=>	'Administrator',
'Banned'				=>	'Gesperrte',
'Guest'					=>	'Gast',

// Stuff for include/parser.php
'BBCode error'			=>	'Der BBCode in diesem Beitrag war falsch.',
'BBCode error 1'		=>	'Fehlender Start f�r [/quote].',
'BBCode error 2'		=>	'Fehlendes Ende f�r [code].',
'BBCode error 3'		=>	'Fehlender Start f�r [/code].',
'BBCode error 4'		=>	'Ein oder mehrere fehlende Enden f�r [quote].',
'BBCode error 5'		=>	'Ein oder mehrere fehlende Anf�nge f�r [/quote].',

// Stuff for the navigator (top of every page)
'Index'					=>	'Startseite',
'User list'				=>	'Mitgliederliste',
'Rules'					=>  'Forumregeln',
'Search'				=>  'Suche',
'Register'				=>  'Registrieren',
'Login'					=>  'Anmelden',
'Not logged in'			=>  'Sie sind nicht angemeldet.',
'Profile'				=>	'Benutzerprofil',
'Logout'				=>	'Abmelden',
'Logged in as'			=>	'Angemeldet als:',
'Admin'					=>	'Adminverwaltung',
'Last visit'			=>	'Ihr letzter Besuch war',
'Show new posts'		=>	'Zeige Beitr�ge seit dem letzten Besuch',
'Mark all as read'		=>	'Alle Foren als gelesen markieren',
'Mark forum as read'	=>	'Mark this forum as read', // MOD: MARK TOPICS AS READ
'Link separator'		=>	'',	// The text that separates links in the navigator

// Stuff for the page footer
'Board footer'			=>	'Brett Fu�zeile',
'Search links'			=>	'Such Links',
'Show recent posts'		=>	'K�rzlich geschriebene Beitr�ge anzeigen',
'Show unanswered posts'	=>	'Zeige unbeantwortete Beitr�ge',
'Show your posts'		=>	'Zeige meine Beitr�ge',
'Show subscriptions'	=>	'Zeige abonnierte Themen',
'Jump to'				=>	'Wechsel zu',
'Go'					=>	' Los ',		// submit button in forum jump
'Move topic'			=>  'Thema verschieben',
'Open topic'			=>  'Thema �ffnen',
'Close topic'			=>  'Thema schlie�en',
'Unstick topic'			=>  'Thema l�sen',
'Stick topic'			=>  'Thema fixieren',
'Moderate forum'		=>	'Forum moderieren',
'Delete posts'			=>	'Mehrere Beitr�ge l�schen',
'Debug table'			=>	'Debug Information',

// For extern.php RSS feed
'RSS Desc Active'		=>	'Das zuletzt aktive Thema aus:',	// board_title will be appended to this string
'RSS Desc New'			=>	'Das neueste Thema aus:',					// board_title will be appended to this string
'Posted'				=>	'Gestartet am:'	// The date/time a topic was started

);
