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
'Bad request'			=>	'Erro. A hiperligação indicada está incorrecta ou não já não existe.',
'No view'				=>	'Não tem presissão para aceder a este forum.',
'No permission'			=>	'Não tem permissão para aceder a esta página.',
'Bad referrer'			=>	'Bad HTTP_REFERER. You were referred to this page from an unauthorized source. If the problem persists please make sure that \'Base URL\' is correctly set in Admin/Options and that you are visiting the forum by navigating to that URL. More information regarding the referrer check can be found in the PunBB documentation.',

// Topic/forum indicators
'New icon'				=>	'Não existem mensagens novas',
'Normal icon'			=>	'<!-- -->',
'Closed icon'			=>	'O tópico está fechado',
'Redirect icon'			=>	'Forum redireccionado',

// Miscellaneous
'Announcement'			=>	'Aviso',
'Options'				=>	'Opções',
'Actions'				=>	'Acçções',
'Submit'				=>	'Confirmar',	// "name" of submit buttons
'Ban message'			=>	'Você foi expulso deste fórum.',
'Ban message 2'			=>	'Poderá voltar a acerder este fórum em',
'Ban message 3'			=>	'O Administrador ou Moderador respons´vel por sua expulsão deixou a seguinte mensagem:',
'Ban message 4'			=>	'Por favor, envie suas dúvidas ou sugestões para o Administrador dos Fóruns',
'Never'					=>	'Nunca',
'Today'					=>	'Hoje',
'Yesterday'				=>	'Ontem',
'Info'					=>	'Informação',		// a common table header
'Go back'				=>	'Voltar',
'Maintenance'			=>	'Manutenção',
'Redirecting'			=>	'A redireccionar',
'Click redirect'		=>	'A redireccionar automaticamente.',
'on'					=>	'ligado',		// as in "BBCode is on"
'off'					=>	'desligado',
'Invalid e-mail'		=>	'O correio electrónico indicado não é válido.',
'required field'		=>	'é um campo de preenchimento obrigatáorio.',	// for javascript form validation
'Last post'				=>	'Último Comentário',
'by'					=>	'por:',	// as in last post by someuser
'New posts'				=>	'Novos comentários',	// the link that leads to the first new post (use &nbsp; for spaces)
'New posts info'		=>	'Ir para o comentario mais recente deste tópico.',	// the popup text for new posts links
'Username'				=>	'Identificação',
'Password'				=>	'Palavra-Passe',
'E-mail'				=>	'Correio Electrónico',
'Send e-mail'			=>	'Enviar correio electrónico',
'Moderated by'			=>	'Moderado por',
'Registered'			=>	'Registado',
'Subject'				=>	'Assunto',
'Message'				=>	'Mensagem',
'Topic'					=>	'Tópico',
'Forum'					=>	'Forum',
'Posts'					=>	'Comentários',
'Replies'				=>	'Respostas',
'Author'				=>	'Autor',
'Pages'					=>	'Pag.',
'BBCode'				=>	'BBCode',	// You probably shouldn't change this
'img tag'				=>	'[img] tag',
'Smilies'				=>	'\'Smilies\'',
'and'					=>	'e',
'Image link'			=>	'imagem',	// This is displayed (i.e. <image>) instead of images when "Show images" is disabled in the profile
'wrote'					=>	'Comentou',	// For [quote]'s
'Code'					=>	'Código',		// For [code]'s
'Mailer'				=>	'Remetente',	// As in "MyForums Mailer" in the signature of outgoing e-mails
'Important information'	=>	'Informação Importante',
'Write message legend'	=>	'Escreva a sua mensagem e envie-a',

// Title
'Title'					=>	'Título',
'Member'				=>	'Utilizador',	// Default title
'Moderator'				=>	'Moderador',
'Administrator'			=>	'Administrador',
'Banned'				=>	'Expulso',
'Guest'					=>	'Convidado',

// Stuff for include/parser.php
'BBCode error'			=>	'A sintax do BBCode está incorrecta.',
'BBCode error 1'		=>	'Não foi indicada a \'tag\' inicial [/quote].',
'BBCode error 2'		=>	'Não foi indicada a \'tag\' final [code].',
'BBCode error 3'		=>	'Não foi indicada a \'tag\' inicial [/code].',
'BBCode error 4'		=>	'Não foi indicada uma ou mais \'tags\' finais para [quote].',
'BBCode error 5'		=>	'Não foi indicada uma ou mais \'tags\' iniciais para [/quote].',

// Stuff for the navigator (top of every page)
'Index'					=>	'Início',
'User list'				=>	'Utilizadores',
'Rules'					=>  'Regras',
'Search'				=>  'Pesquisa',
'Register'				=>  'Registar-se',
'Login'					=>  'Entrar',
'Not logged in'			=>  'Você não está identificado.',
'Profile'				=>	'Perfil',
'Logout'				=>	'Sair',
'Logged in as'			=>	'Identificação:',
'Admin'					=>	'Admin',
'Last visit'			=>	'Última visita',
'Show new posts'		=>	'Exibir os comentários novos desde a última visita',
'Mark all as read'		=>	'Marcas todas os comentários como lidos',
'Mark forum as read'	=>	'Mark this forum as read', // MOD: MARK TOPICS AS READ
'Link separator'		=>	'',	// The text that separates links in the navigator

// Stuff for the page footer
'Board footer'			=>	'Rodapé do forum',
'Search links'			=>	'Links de pesquisa',
'Show recent posts'		=>	'Exibir comentários recentes',
'Show unanswered posts'	=>	'Exibir comentários não respondidos',
'Show your posts'		=>	'Exibir meus comentários',
'Show subscriptions'	=>	'Exibir os tópicos seleccionados',
'Jump to'				=>	'Ir para',
'Go'					=>	' Ir ',		// submit button in forum jump
'Move topic'			=>  'Mover Tópico',
'Open topic'			=>  'Abrir Tópico',
'Close topic'			=>  'Fechar Tópico',
'Unstick topic'			=>  'Separar Tópico',
'Stick topic'			=>  'Fundir Tópico',
'Moderate forum'		=>	'Moderar Fórum',
'Delete posts'			=>	'Eliminar múltiplos comentários',
'Debug table'			=>	'Informação de \"debug\"',

// For extern.php RSS feed
'RSS Desc Active'		=>	'O tópico mais activo em',	// board_title will be appended to this string
'RSS Desc New'			=>	'O tópico mais recente em',					// board_title will be appended to this string
'Posted'				=>	'Colocado'	// The date/time a topic was started

);
