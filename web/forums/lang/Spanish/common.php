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
'Bad request'			=>	'Solicitud errónea. El enlace es incorrecto o ha caducado.',
'No view'				=>	'Careces de permisos para ver estos foros.',
'No permission'			=>	'Careces de permisos para acceder a esta página',
'Bad referrer'			=>	'HTTP_REFERER erróneo. Has sido dirigido a esta página desde una fuente no autorizada. Si el problema continua por favor asegúrate de que la \'URL base\' está correctamente configurada en Admin/Options y que estás visitando el foro desde esta URL. Puedes encontrar más información sobre este tema en la documentación de PunB.',

// Topic/forum indicators
'New icon'				=>	'Hay mensajes nuevos',
'Normal icon'			=>	'<!-- -->',
'Closed icon'			=>	'Este tema está cerrado',
'Redirect icon'			=>	'Foro redirigido',

// Miscellaneous
'Announcement'			=>	'Anuncio',
'Options'				=>	'Opciones',
'Actions'				=>	'Acciones',
'Submit'				=>	'Enviar',	// "name" of submit buttons
'Ban message'			=>	'Estás expulsado de este foro. ',
'Ban message 2'			=>	'La expulsión expira al final de',
'Ban message 3'			=>	'El administrador o moderador que te ha expulsado ha dejado el siguiente mensaje:',
'Ban message 4'			=>	'Por favor dirige cualquier pregunta al administrador del foro en',
'Never'					=>	'Nunca',
'Today'					=>	'Hoy',
'Yesterday'				=>	'Ayer',
'Info'					=>	'Info',		// a common table header
'Go back'				=>	'Volver',
'Maintenance'			=>	'Mantenimiento',
'Redirecting'			=>	'Redirigiendo',
'Click redirect'		=>	'Pulsa aquí si no quieres esperar más (o si tu explorador no te reenvía automáticamente)',
'on'					=>	'activado',		// as in "BBCode is on"
'off'					=>	'desactivado',
'Invalid e-mail'		=>	'La dirección de correo que has entrado no es válida.',
'required field'		=>	'es un campo requerido en este formulario.',	// for javascript form validation
'Last post'				=>	'Último mensaje',
'by'					=>	'por',	// as in last post by someuser
'New posts'				=>	'Mensajes&nbsp;nuevos',	// the link that leads to the first new post (use &nbsp; for spaces)
'New posts info'		=>	'Ir al primer mensaje nuevo de este tema.',	// the popup text for new posts links
'Username'				=>	'Nombre de usuario',
'Password'				=>	'Contraseña',
'E-mail'				=>	'E-mail',
'Send e-mail'			=>	'Enviar e-mail',
'Moderated by'			=>	'Moderado por',
'Registered'			=>	'Registrado',
'Subject'				=>	'Asunto',
'Message'				=>	'Mensaje',
'Topic'					=>	'Tema',
'Forum'					=>	'Foro',
'Posts'					=>	'Mensajes',
'Replies'				=>	'Respuestas',
'Author'				=>	'Autor',
'Pages'					=>	'Páginas',
'BBCode'				=>	'BBCode',	// You probably shouldn't change this
'img tag'				=>	'Marcador [img]',
'Smilies'				=>	'Smileys',
'and'					=>	'y',
'Image link'			=>	'imagen',	// This is displayed (i.e. <image>) instead of images when "Show images" is disabled in the profile
'wrote'					=>	'dijo',	// For [quote]'s
'Code'					=>	'Código',		// For [code]'s
'Mailer'				=>	'Administrador de correo',	// As in "MyForums Mailer" in the signature of outgoing e-mails
'Important information'	=>	'Información importante',
'Write message legend'	=>	'Escribe tu mensaje y envíalo',

// Title
'Title'					=>	'Título',
'Member'				=>	'Miembro',	// Default title
'Moderator'				=>	'Moderador',
'Administrator'			=>	'Administrador',
'Banned'				=>	'Expulsado',
'Guest'					=>	'Invitado',

// Stuff for include/parser.php
'BBCode error'			=>	'La sintaxis del BBCode en este mensaje es errónea.',
'BBCode error 1'		=>	'Falta el marcador de inicio de [/quote].',
'BBCode error 2'		=>	'Falta el marcador final del [code].',
'BBCode error 3'		=>	'Falta el marcador de inicio para un [/code].',
'BBCode error 4'		=>	'Falta uno o más marcadores finales de [quote].',
'BBCode error 5'		=>	'Falta uno o más marcadores de inicio para [/quote].',

// Stuff for the navigator (top of every page)
'Index'					=>	'Índice',
'User list'				=>	'Lista de usuarios',
'Rules'					=>  'Reglas',
'Search'				=>  'Busca',
'Register'				=>  'Regístrate',
'Login'					=>  'Conectar',
'Not logged in'			=>  'No estás conectado',
'Profile'				=>	'Perfil',
'Logout'				=>	'Desconectar',
'Logged in as'			=>	'Conectado como',
'Admin'					=>	'Administración',
'Last visit'			=>	'Última visita',
'Show new posts'		=>	'Mostrar mensajes nuevos desde la última visita',
'Mark all as read'		=>	'Marcar todos los temas como leidos',
'Mark forum as read'    =>      'Marcar este foro como leido', // MOD: MARK TOPICS AS READ
'Link separator'		=>	'',	// The text that separates links in the navigator

// Stuff for the page footer
'Board footer'			=>	'Pie del foro',
'Search links'			=>	'Busca renlaces',
'Show recent posts'		=>	'Mostrar mensajes recientes',
'Show unanswered posts'	=>	'Mostrar mensajes sin respuesta',
'Show your posts'		=>	'Mostrar tus mensajes',
'Show subscriptions'	=>	'Muestra tus temas suscritos',
'Jump to'				=>	'Ir a',
'Go'					=>	' Ir',		// submit button in forum jump
'Move topic'			=>  'Mover tema',
'Open topic'			=>  'Abrir tema',
'Close topic'			=>  'Cerrar tema',
'Unstick topic'			=>  'Desmarcar tema como fijo',
'Stick topic'			=>  'Marcar tema como fijo',
'Moderate forum'		=>	'Moderar el foro',
'Delete posts'			=>	'Borrar mensajes múltiples',
'Debug table'			=>	'Información de depuración',

// For extern.php RSS feed
'RSS Desc Active'		=>	'Los temas más recientes activos en',	// board_title will be appended to this string
'RSS Desc New'			=>	'Los últimos temas en',					// board_title will be appended to this string
'Posted'				=>	'Enviado'	// The date/time a topic was started

);
