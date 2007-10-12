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
'lang_encoding'			=>	'utf-8',
'lang_multibyte'		=>	false,

// Notices
'Bad request'			=>	'Sol·licitud errònia. L\'enllaç seguit és incorrecte o ha caducat.',
'No view'				=>	'No teniu permís per a veure aquests fòrums.',
'No permission'			=>	'No teniu permís per a accedir a aquesta pàgina.',
'Bad referrer'			=>	'HTTP_REFERER erroni. Heu estat dirigit a aquesta pàgina des de una font no autoritzada. Si el problema continua per favor assegureu-vos que la \'URL base\' està correctament configurada a Admin/Options i que esteu visitant el fòrum a partir d\'aquesta URL. Podeu trobar més informació al voltant d\'aquest tema a la documentació de PunBB.',

// Topic/forum indicators
'New icon'				=>	'Hi ha missatges nous',
'Normal icon'			=>	'<!-- -->',
'Closed icon'			=>	'Aquest tema està tancat',
'Redirect icon'			=>	'Fòrum redirigit',

// Miscellaneous
'Announcement'			=>	'Avís',
'Options'				=>	'Opcions',
'Actions'				=>	'Accions',
'Submit'				=>	'Envia',	// "name" of submit buttons
'Ban message'			=>	'Esteu expulsat d\'aquest fòrum.',
'Ban message 2'			=>	'L\'expulsió expira a la fi de',
'Ban message 3'			=>	'L\'administrador o moderador que vos ha expulsat ha deixat el següent missatge:',
'Ban message 4'			=>	'Per favor adreceu qualsevol pregunta a l\'administrador del fòrum a',
'Never'					=>	'Mai',
'Today'					=>	'Avui',
'Yesterday'				=>	'Ahir',
'Info'					=>	'Info',		// a common table header
'Go back'				=>	'Tornar arrere',
'Maintenance'			=>	'Manteniment',
'Redirecting'			=>	'Redirigint',
'Click redirect'		=>	'Premeu ací si no voleu esperar més (o si el vostre explorador no vos reenvia automàticament)',
'on'					=>	'actiu',		// as in "BBCode is on"
'off'					=>	'inactiu',
'Invalid e-mail'		=>	'L\'adreça de correu que heu proporcionat no és vàlida.',
'required field'		=>	'és un camp requerit en aquest formulari.',	// for javascript form validation
'Last post'				=>	'Últim missatge',
'by'					=>	'per',	// as in last post by someuser
'New posts'				=>	'Missatges nous',	// the link that leads to the first new post (use &nbsp; for spaces)
'New posts info'		=>	'Anar al primer missatge nou d\'aquest tema.',	// the popup text for new posts links
'Username'				=>	'Nom d\'Usuari',
'Password'				=>	'Contrasenya',
'E-mail'				=>	'E-mail',
'Send e-mail'			=>	'Envia e-mail',
'Moderated by'			=>	'Moderat per',
'Registered'			=>	'Registrat',
'Subject'				=>	'Assumpte',
'Message'				=>	'Missatge',
'Topic'					=>	'Tema',
'Forum'					=>	'Fòrum',
'Posts'					=>	'Missatges',
'Replies'				=>	'Respostes',
'Author'				=>	'Autor',
'Pages'					=>	'Pàgines',
'BBCode'				=>	'BBCode',	// You probably shouldn't change this
'img tag'				=>	'Marcador [img]',
'Smilies'				=>	'Smilies',
'and'					=>	'i',
'Image link'			=>	'imatge',	// This is displayed (i.e. <image>) instead of images when "Show images" is disabled in the profile
'wrote'					=>	'escrigué',	// For [quote]'s
'Code'					=>	'Codi',		// For [code]'s
'Mailer'				=>	'Administrador de correu',	// As in "MyForums Mailer" in the signature of outgoing e-mails
'Important information'	=>	'Informació important',
'Write message legend'	=>	'Escriviu el vostre missatge i envieu',

// Title
'Title'					=>	'Títol',
'Member'				=>	'Membre',	// Default title
'Moderator'				=>	'Moderador',
'Administrator'			=>	'Administrador',
'Banned'				=>	'Expulsat',
'Guest'					=>	'Visitant',

// Stuff for include/parser.php
'BBCode error'			=>	'La sintaxi del BBCode en aquest missatge és errònia.',
'BBCode error 1'		=>	'Falta el marcador d\'inici per a [/quote].',
'BBCode error 2'		=>	'Falta el marcador de fi per a [code].',
'BBCode error 3'		=>	'Falta el marcador d\'inici per a [/code].',
'BBCode error 4'		=>	'Falta un o més marcadors de fi per a [quote].',
'BBCode error 5'		=>	'Falta un o més marcadors d\'inici per a [/quote].',

// Stuff for the navigator (top of every page)
'Index'					=>	'Inici',
'User list'				=>	'Llista d\'usuaris',
'Rules'					=>  'Regles',
'Search'				=>  'Cerca',
'Register'				=>  'Registre',
'Login'					=>  'Entreu',
'Not logged in'			=>  'No esteu identificat.',
'Profile'				=>	'Perfil',
'Logout'				=>	'Sortiu',
'Logged in as'			=>	'Identificat com',
'Admin'					=>	'Administració',
'Last visit'			=>	'Última visita',
'Show new posts'		=>	'Mostra missatges nous des de l\'última visita',
'Mark all as read'		=>	'Marca tots els temes com a llegits',
'Mark forum as read'	=>	'Mark this forum as read', // MOD: MARK TOPICS AS READ
'Link separator'		=>	'',	// The text that separates links in the navigator

// Stuff for the page footer
'Board footer'			=>	'Peu del fòrum',
'Search links'			=>	'Cerca enllaços',
'Show recent posts'		=>	'Mostra missatges recents',
'Show unanswered posts'	=>	'Mostra missatges sense resposta',
'Show your posts'		=>	'Mostra els meus missatges',
'Show subscriptions'	=>	'Mostra els meus temes subscrits',
'Jump to'				=>	'Anar a',
'Go'					=>	' Anar ',		// submit button in forum jump
'Move topic'			=>  'Mou tema',
'Open topic'			=>  'Obri tema',
'Close topic'			=>  'Tanca tema',
'Unstick topic'			=>  'Desmarca permanent',
'Stick topic'			=>  'Marca com a permanent',
'Moderate forum'		=>	'Modereu el fòrum',
'Delete posts'			=>	'Esborra missatges múltiples',
'Debug table'			=>	'Informació de depuració',

// For extern.php RSS feed
'RSS Desc Active'		=>	'Últims temes actius a',	// board_title will be appended to this string
'RSS Desc New'			=>	'Últims temes a',					// board_title will be appended to this string
'Posted'				=>	'Enviat'	// The date/time a topic was started

);
