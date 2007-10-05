<?php
/***********************************************************************

  Copyright (C) 2002-2005  Rickard Andersson (rickard@punbb.org)

  This file is part of PunBB.

  PunBB is free software; you can redistribute it and/or modify it
  under the terms of the GNU General Public License as published
  by the Free Software Foundation; either version 2 of the License,
  or (at your option) any later version.

  PunBB is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston,
  MA  02111-1307  USA

************************************************************************/

define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';
require PUN_ROOT.'include/parser.php';

if (!$pun_config['cb_pbb_version'])
	message('Poki BB Chatbox is not installed correctly. Please make sure you have launch install_mod.php');

if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view']);

// Load the chatbox.php and post.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/chatbox.php';
require PUN_ROOT.'lang/'.$pun_user['language'].'/post.php';

// Same funtion that php native rawurldecode() but with utf8 support
function utf8RawUrlDecode ($source) {
    $decodedStr = "";
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // We got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $entity = "&#". $unicode . ';';
                $decodedStr .= utf8_encode ($entity);
                $pos += 4;
            }
            else {
                // We have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        } else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }
    return $decodedStr;
}

// Error function for ajax queries
function error_ajax($message, $file, $line, $db_error = false)
{
	global $pun_config, $lang_chatbox;
	
	// Defaut error reponse
	$error = $pun_config['cb_space'].$pun_config['cb_ajax_errors'];
	$error = str_replace('<pun_error>', $lang_chatbox['Error Title'], $error);
	$error = str_replace('<pun_date>', format_time(time()), $error);
	
	$error_ajax_msg = '';
	if (!defined('PUN_DEBUG') && $file != false && $line != false)
	{
		$error_ajax_msg .= '<strong>File:</strong> '.$file.'<br /><strong>Line:</strong> '.$line.'<br /><br /><strong>PunBB reported</strong>: '.$message;
		
		if ($db_error)
		{
			$error_ajax_msg .= '<br /><br /><strong>Database reported:</strong> '.pun_htmlspecialchars($db_error['error_msg']).(($db_error['error_no']) ? ' (Errno: '.$db_error['error_no'].')' : '');
			
			if ($db_error['error_sql'] != '')
				$error_ajax_msg .= '<br /><br /><strong>Failed query:</strong> '.pun_htmlspecialchars($db_error['error_sql']);
		}
	}
	else
		$error_ajax_msg .= $message;
	
	// If a database connection was established (before this error) we close it
	if ($db_error)
		$GLOBALS['db']->close();
	
	exit('error:chat'.str_replace('<pun_error_text>', $error_ajax_msg, $error));
}

// If it's AJAX request
if (isset($_POST['ajax']) || isset($_GET['ajax'])) {
	
	// Send no-cache headers
	header('Expires: Thu, 21 Jul 1977 07:30:00 GMT');	// When yours truly first set eyes on this world! :)
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache');		// For HTTP/1.0 compability
	header('Content-type: text/html; charset='.$lang_common['lang_encoding']);
	
	// If new message was submit
	if (isset($_POST['ajax'])) {
		
		// Decode
		$_POST['req_message'] = utf8RawUrlDecode($_POST['req_message']);
		$_POST['form_user'] = utf8RawUrlDecode($_POST['form_user']);
		$_POST['req_username'] = utf8RawUrlDecode($_POST['req_username']);
		$_POST['req_email'] = utf8RawUrlDecode($_POST['req_email']);
		$_POST['email'] = utf8RawUrlDecode($_POST['email']);
		
		// Defaut error reponse
		$error = $pun_config['cb_space'].$pun_config['cb_ajax_errors'];
		$error = str_replace('<pun_error>', $lang_chatbox['Error Title'], $error);
		$error = str_replace('<pun_date>', format_time(time()), $error);
		
		// Make sure form_user is correct
		if (($pun_user['is_guest'] && $_POST['form_user'] != 'Guest') || (!$pun_user['is_guest'] && $_POST['form_user'] != $pun_user['username']))
			error_ajax(parse_message($lang_common['Bad request'], 0), false, false, false);
		
		// Do we have permission to post?
		if ($pun_user['g_post_chatbox'] != '1')
			error_ajax(parse_message($lang_chatbox['No Post Permission'], 0), false, false, false);
		
		// Flood protection
		if (!$pun_user['is_guest'] && $pun_user['last_post_chatbox'] != '' && (time() - $pun_user['last_post_chatbox']) < $pun_user['g_post_flood_chatbox'])
			error_ajax(parse_message($lang_post['Flood start'].' '.$pun_user['g_post_flood_chatbox'].' '.$lang_post['flood end'], 0), false, false, false);
		
		// If it's Guest
		if ($pun_user['is_guest']) {
			$result = $db->query('SELECT id, poster_ip, posted FROM '.$db->prefix.'chatbox_msg WHERE poster_ip=\''.get_remote_address().'\' ORDER BY posted DESC LIMIT 1') or error_ajax('Unable to fetch messages for flood protection', __FILE__, __LINE__, $db->error());
			$cur_post = $db->fetch_assoc($result);
			
			if ((time() - $cur_post['posted']) < $pun_user['g_post_flood_chatbox'])
				error_ajax(parse_message($lang_post['Flood start'].' '.$pun_user['g_post_flood_chatbox'].' '.$lang_post['flood end'], 0), false, false, false);
		}
		
		// If the user is logged in we get the username and e-mail from $pun_user
		if (!$pun_user['is_guest']) {
			$username = $pun_user['username'];
			$email = $pun_user['email'];
		}
		
		// Otherwise it should be in $_POST
		else {
			$username = trim($_POST['req_username']);
			$email = strtolower(trim(($pun_config['p_force_guest_email'] == '1') ? $_POST['req_email'] : $_POST['email']));
			
			// Load the register.php/profile.php language files
			require PUN_ROOT.'lang/'.$pun_user['language'].'/prof_reg.php';
			require PUN_ROOT.'lang/'.$pun_user['language'].'/register.php';
			
			// It's a guest, so we have to validate the username
			if (strlen($username) < 2)
				error_ajax(parse_message($lang_prof_reg['Username too short'], 0), false, false, false);
			else if (!strcasecmp($username, 'Guest') || !strcasecmp($username, $lang_common['Guest']))
				error_ajax(parse_message($lang_prof_reg['Username guest'], 0), false, false, false);
			else if (preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $username))
				error_ajax(parse_message($lang_prof_reg['Username IP'], 0), false, false, false);
			
			if ((strpos($username, '[') !== false || strpos($username, ']') !== false) && strpos($username, '\'') !== false && strpos($username, '"') !== false)
				error_ajax(parse_message($lang_prof_reg['Username reserved chars'], 0), false, false, false);
			if (preg_match('#\[b\]|\[/b\]|\[u\]|\[/u\]|\[i\]|\[/i\]|\[color|\[/color\]|\[quote\]|\[quote=|\[/quote\]|\[code\]|\[/code\]|\[img\]|\[/img\]|\[url|\[/url\]|\[email|\[/email\]#i', $username))
				error_ajax(parse_message($lang_prof_reg['Username BBCode'], 0), false, false, false);
			
			// Check username for any censored words
			$temp = censor_words($username);
			if ($temp != $username)
				error_ajax(parse_message($lang_register['Username censor'], 0), false, false, false);
			
			// Check that the username (or a too similar username) is not already registered
			$result = $db->query('SELECT username FROM '.$db->prefix.'users WHERE username=\''.$db->escape($username).'\' OR username=\''.$db->escape(preg_replace('/[^\w]/', '', $username)).'\'') or error_ajax('Unable to fetch user info', __FILE__, __LINE__, $db->error());
			if ($db->num_rows($result)) {
				$busy = $db->result($result);
				error_ajax(parse_message($lang_register['Username dupe 1'].' '.pun_htmlspecialchars($busy).'. '.$lang_register['Username dupe 2'], 0), false, false, false);
			}
			
			if ($pun_config['p_force_guest_email'] == '1' || $email != '') {
				require PUN_ROOT.'include/email.php';
				if (!is_valid_email($email))
					error_ajax(parse_message($lang_common['Invalid e-mail'], 0), false, false, false);
			}			
			
		}
		
		// Clean up message from POST
		$message = pun_linebreaks(pun_trim($_POST['req_message']));
		
		if ($message == '')
			error_ajax(parse_message($lang_chatbox['Error No message'], 0), false, false, false);
		else if (strlen($message) > $pun_config['cb_msg_maxlength'])
			error_ajax(parse_message($lang_chatbox['Error Too long message'], 0), false, false, false);
		else if ($pun_config['p_message_all_caps'] == '0' && strtoupper($message) == $message && $pun_user['g_id'] > PUN_MOD)
			$message = ucwords(strtolower($message));
		
		$parse_errors = '';
		
		// Validate BBCode syntax
		if ($pun_config['p_message_bbcode'] == '1' && strpos($message, '[') !== false && strpos($message, ']') !== false)
			$message = preparse_bbcode($message, $parse_errors);
		
		if ($parse_errors != '')
			error_ajax(parse_message($parse_errors[0], 0), false, false, false);
		
		// Get the time
		$now = time();
		
		if (!$pun_user['is_guest']) {
			// Insert message
			$db->query('INSERT INTO '.$db->prefix.'chatbox_msg (poster, poster_id, poster_ip, message, posted) VALUES(\''.$db->escape($username).'\', '.$pun_user['id'].', \''.get_remote_address().'\', \''.$db->escape($message).'\', '.$now.')') or error_ajax('Unable to post message', __FILE__, __LINE__, $db->error());
			
			// Increment his/her chatbox post count
  			$low_prio = ($db_type == 'mysql') ? 'LOW_PRIORITY ' : '';
  			$db->query('UPDATE '.$low_prio.$db->prefix.'users SET num_posts_chatbox=num_posts_chatbox+1, last_post_chatbox='.$now.' WHERE id='.$pun_user['id']) or error_ajax('Unable to update user', __FILE__, __LINE__, $db->error());
		}
		else {
			// Insert message
			$email_sql = ($pun_config['p_force_guest_email'] == '1' || $email != '') ? '\''.$email.'\'' : 'NULL';
			$db->query('INSERT INTO '.$db->prefix.'chatbox_msg (poster, poster_id, poster_ip, poster_email, message, posted) VALUES(\''.$db->escape($username).'\', '.$pun_user['id'].', \''.get_remote_address().'\', '.$email_sql.', \''.$db->escape($message).'\', '.$now.')') or error_ajax('Unable to post message', __FILE__, __LINE__, $db->error());
		}
		
		$count = $db->query('SELECT COUNT(id) FROM '.$db->prefix.'chatbox_msg') or error_ajax('Unable to fetch chatbox post count', __FILE__, __LINE__, $db->error());
		$num_post = $db->result($count);
		
		$limit = ($num_post-$pun_config['cb_max_msg'] <= 0) ? 0 : $num_post-$pun_config['cb_max_msg'];
		
		$result = $db->query('SELECT id,posted FROM '.$db->prefix.'chatbox_msg ORDER BY posted ASC LIMIT '.$limit) or error_ajax('Unable to select post to delete', __FILE__, __LINE__, $db->error());
		while ($del_msg = $db->fetch_assoc($result))
			$db->query('DELETE FROM '.$db->prefix.'chatbox_msg WHERE id = '.$del_msg['id'].' LIMIT 1') or error_ajax('Unable to delete post', __FILE__, __LINE__, $db->error());
		
		exit('PostedInDB');
	}
	
	// Now we list all new message
	$cur_msg_txt = '';
	$response = '';
	$count_id = array();
	
	// Define last message timestamp
	$last_msg_time = intval($_GET['last_msg']);
	
	$messages = $db->query('SELECT u.id, u.group_id, u.num_posts_chatbox, m.id AS m_id, m.poster_id, m.poster, m.poster_ip, m.poster_email, m.message, m.posted, g.g_id, g.g_title_chatbox FROM '.$db->prefix.'chatbox_msg AS m INNER JOIN '.$db->prefix.'users AS u ON u.id=m.poster_id INNER JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id WHERE m.posted > '.$last_msg_time.' ORDER BY m.posted ASC LIMIT 0,50') or error_ajax('Unable to fetch messages', __FILE__, __LINE__, $db->error());
	
	while ($cur_msg = $db->fetch_assoc($messages)) {	
		
		$cur_msg_txt = $pun_config['cb_space'].$cur_msg['g_title_chatbox'].$pun_config['cb_disposition'];
		
		// Define last message timestamp
		$last_msg_time = intval($cur_msg['posted']);
		
		// Replace <pun_username>
		if ($cur_msg['g_id'] != PUN_GUEST)
			$cur_msg_txt = str_replace('<pun_username>', '<a href="profile.php?id='.$cur_msg['id'].'">'.pun_htmlspecialchars($cur_msg['poster']).'</a>', $cur_msg_txt);
		else
			$cur_msg_txt = str_replace('<pun_username>', pun_htmlspecialchars($cur_msg['poster']), $cur_msg_txt);
		
		// Replace <pun_date>
		$cur_msg_txt = str_replace('<pun_date>', format_time($cur_msg['posted']), $cur_msg_txt);
				
		// Replace <pun_nbpost>
		if ($cur_msg['g_id'] != PUN_GUEST)
			$cur_msg_txt = str_replace('<pun_nbpost>', $cur_msg['num_posts_chatbox'], $cur_msg_txt);
		else {
			if (!isset($count_id[$cur_msg['poster']])) {
				$like_command = ($db_type == 'pgsql') ? 'ILIKE' : 'LIKE';
				
				$count = $db->query('SELECT COUNT(id) FROM '.$db->prefix.'chatbox_msg WHERE poster '.$like_command.' \''.$db->escape(str_replace('*', '%', $cur_msg['poster'])).'\'') or error_ajax('Unable to fetch user chatbox post count', __FILE__, __LINE__, $db->error());
				$num_post = $db->result($count);
				$count_id[$cur_msg['poster']] = $num_post;
			}
			else
				$num_post = $count_id[$cur_msg['poster']];
			
			$cur_msg_txt = str_replace('<pun_nbpost>', $num_post, $cur_msg_txt);
		}
		
		// Replace <pun_nbpost_txt>
		$cur_msg_txt = str_replace('<pun_nbpost_txt>', $lang_chatbox['Posts'], $cur_msg_txt);
		
		// Add admin feature and replace <pun_admin>
		if ($pun_user['g_id'] < PUN_GUEST) {
			$cur_msg_admin = ' [ <a href="chatbox.php?get_host='.$cur_msg['m_id'].'">'.$cur_msg['poster_ip'].'</a>';
			
			if ($cur_msg['poster_email'])
				$cur_msg_admin .= ' | <a href="mailto:'.$cur_msg['poster_email'].'">'.$lang_common['E-mail'].'</a> ]';
			else
				$cur_msg_admin .= ' ] ';
		}
		else
			$cur_msg_admin = '';
		
		$cur_msg_txt = str_replace('<pun_admin>', $cur_msg_admin, $cur_msg_txt);
		
		// Replace <pun_message>
		$cur_msg_txt = str_replace('<pun_message>', parse_message($cur_msg['message'], 0), $cur_msg_txt);
		
		$response .= $cur_msg_txt . "\n";
	}
	
	// If no new message we return the timestamp
	if (!$response)
		$response = $last_msg_time;
	else
		$response = $last_msg_time.$response;
	
	$response = pun_trim($response);
	exit($response);
}


// This particular function doesn't require forum-based moderator access. It can be used
// by all moderators and admins.
if (isset($_GET['get_host']))
{
	if ($pun_user['g_id'] > PUN_MOD)
		message($lang_common['No permission']);
	
	// Is get_host an IP address or a post ID?
	if (preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $_GET['get_host']))
		$ip = $_GET['get_host'];
	else {
		$get_host = intval($_GET['get_host']);
		if ($get_host < 1)
			message($lang_common['Bad request']);
		
		$result = $db->query('SELECT poster_ip FROM '.$db->prefix.'chatbox_msg WHERE id='.$get_host) or error('Unable to fetch post IP address', __FILE__, __LINE__, $db->error());
		if (!$db->num_rows($result))
			message($lang_common['Bad request']);
	
		$ip = $db->result($result);
	}
	
	message('The IP address is: '.$ip.'<br />The host name is: '.@gethostbyaddr($ip).'<br /><br /><a href="admin_users.php?show_users='.$ip.'">Show more users for this IP</a>');
}

$page_title = pun_htmlspecialchars($lang_chatbox['Page_title']);
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

if ($pun_user['g_read_chatbox'] != '1')
	message($lang_chatbox['No Read Permission']);

// Did someone just hit "Submit"?
if (isset($_POST['form_sent'])) {
	
	// Make sure form_user is correct
	if (($pun_user['is_guest'] && $_POST['form_user'] != 'Guest') || (!$pun_user['is_guest'] && $_POST['form_user'] != $pun_user['username']))
		message($lang_common['Bad request']);
	
	// Do we have permission to post?
	if ($pun_user['g_post_chatbox'] != '1')
		message($lang_chatbox['No Post Permission']);
	
	// Start with a clean slate
	$errors = array();
	
	// Flood protection
	if (!$pun_user['is_guest'] && $pun_user['last_post_chatbox'] != '' && (time() - $pun_user['last_post_chatbox']) < $pun_user['g_post_flood_chatbox'])
		$errors[] = $lang_post['Flood start'].' '.$pun_user['g_post_flood_chatbox'].' '.$lang_post['flood end'];
	
	if ($pun_user['is_guest']) {
		$result = $db->query('SELECT id, poster_ip, posted FROM '.$db->prefix.'chatbox_msg WHERE poster_ip=\''.get_remote_address().'\' ORDER BY posted DESC LIMIT 1') or error('Unable to fetch messages for flood protection', __FILE__, __LINE__, $db->error());
		$cur_post = $db->fetch_assoc($result);
		
		if ((time() - $cur_post['posted']) < $pun_user['g_post_flood_chatbox'])
			$errors[] = $lang_post['Flood start'].' '.$pun_user['g_post_flood_chatbox'].' '.$lang_post['flood end'];
	}
	
	// If the user is logged in we get the username and e-mail from $pun_user
	if (!$pun_user['is_guest']) {
		$username = $pun_user['username'];
		$email = $pun_user['email'];
	}
	
	// Otherwise it should be in $_POST
	else
	{
		$username = trim($_POST['req_username']);
		$email = strtolower(trim(($pun_config['p_force_guest_email'] == '1') ? $_POST['req_email'] : $_POST['email']));
		
		// Load the register.php/profile.php language files
		require PUN_ROOT.'lang/'.$pun_user['language'].'/prof_reg.php';
		require PUN_ROOT.'lang/'.$pun_user['language'].'/register.php';
		
		// It's a guest, so we have to validate the username
		if (strlen($username) < 2)
			$errors[] = $lang_prof_reg['Username too short'];
		else if (!strcasecmp($username, 'Guest') || !strcasecmp($username, $lang_common['Guest']))
			$errors[] = $lang_prof_reg['Username guest'];
		else if (preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $username))
			$errors[] = $lang_prof_reg['Username IP'];
		
		if ((strpos($username, '[') !== false || strpos($username, ']') !== false) && strpos($username, '\'') !== false && strpos($username, '"') !== false)
			$errors[] = $lang_prof_reg['Username reserved chars'];
		if (preg_match('#\[b\]|\[/b\]|\[u\]|\[/u\]|\[i\]|\[/i\]|\[color|\[/color\]|\[quote\]|\[quote=|\[/quote\]|\[code\]|\[/code\]|\[img\]|\[/img\]|\[url|\[/url\]|\[email|\[/email\]#i', $username))
			$errors[] = $lang_prof_reg['Username BBCode'];
		
		// Check username for any censored words
		$temp = censor_words($username);
		if ($temp != $username)
			$errors[] = $lang_register['Username censor'];
		
		// Check that the username (or a too similar username) is not already registered
		$result = $db->query('SELECT username FROM '.$db->prefix.'users WHERE username=\''.$db->escape($username).'\' OR username=\''.$db->escape(preg_replace('/[^\w]/', '', $username)).'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
		if ($db->num_rows($result)) {
			$busy = $db->result($result);
			$errors[] = $lang_register['Username dupe 1'].' '.pun_htmlspecialchars($busy).'. '.$lang_register['Username dupe 2'];
		}
		
		if ($pun_config['p_force_guest_email'] == '1' || $email != '') {
			require PUN_ROOT.'include/email.php';
			if (!is_valid_email($email))
				$errors[] = $lang_common['Invalid e-mail'];
		}
	}
	
	// Clean up message from POST
	$message = pun_linebreaks(pun_trim($_POST['req_message']));
	
	if ($message == '')
		$errors[] = $lang_chatbox['Error No message'];
	else if (strlen($message) > $pun_config['cb_msg_maxlength'])
		$errors[] = $lang_chatbox['Error Too long message'];
	else if ($pun_config['p_message_all_caps'] == '0' && strtoupper($message) == $message && $pun_user['g_id'] > PUN_MOD)
		$message = ucwords(strtolower($message));
	
	// Validate BBCode syntax
	if ($pun_config['p_message_bbcode'] == '1' && strpos($message, '[') !== false && strpos($message, ']') !== false)
		$message = preparse_bbcode($message, $errors);
	
	// Did everything go according to plan?
	if (empty($errors)) {
		
		$now = time();
		
		if (!$pun_user['is_guest']) {
			// Insert message
			$db->query('INSERT INTO '.$db->prefix.'chatbox_msg (poster, poster_id, poster_ip, message, posted) VALUES(\''.$db->escape($username).'\', '.$pun_user['id'].', \''.get_remote_address().'\', \''.$db->escape($message).'\', '.$now.')') or error('Unable to post message', __FILE__, __LINE__, $db->error());
			
			// Increment his/her chatbox post count
  			$low_prio = ($db_type == 'mysql') ? 'LOW_PRIORITY ' : '';
  			$db->query('UPDATE '.$low_prio.$db->prefix.'users SET num_posts_chatbox=num_posts_chatbox+1, last_post_chatbox='.$now.' WHERE id='.$pun_user['id']) or error('Unable to update user', __FILE__, __LINE__, $db->error());
		}
		else {
			// Insert message
			$email_sql = ($pun_config['p_force_guest_email'] == '1' || $email != '') ? '\''.$email.'\'' : 'NULL';
			$db->query('INSERT INTO '.$db->prefix.'chatbox_msg (poster, poster_id, poster_ip, poster_email, message, posted) VALUES(\''.$db->escape($username).'\', '.$pun_user['id'].', \''.get_remote_address().'\', '.$email_sql.', \''.$db->escape($message).'\', '.$now.')') or error('Unable to post message', __FILE__, __LINE__, $db->error());
		}
		
		$count = $db->query('SELECT COUNT(id) FROM '.$db->prefix.'chatbox_msg') or error('Unable to fetch chatbox post count', __FILE__, __LINE__, $db->error());
		$num_post = $db->result($count);
		
		$limit = ($num_post-$pun_config['cb_max_msg'] <= 0) ? 0 : $num_post-$pun_config['cb_max_msg'];
		
		$result = $db->query('SELECT id,posted FROM '.$db->prefix.'chatbox_msg ORDER BY posted ASC LIMIT '.$limit) or error('Unable to select post to delete', __FILE__, __LINE__, $db->error());
		while ($del_msg = $db->fetch_assoc($result))
			$db->query('DELETE FROM '.$db->prefix.'chatbox_msg WHERE id = '.$del_msg['id'].' LIMIT 1') or error('Unable to delete post', __FILE__, __LINE__, $db->error());
		
		$_POST['req_message'] = NULL;
	}
}

// If there are errors, we display them
if (!empty($errors))
{

?>
<div id="posterror" class="block">
	<h2><span><?php echo $lang_post['Post errors'] ?></span></h2>
	<div class="box">
		<div class="inbox">
			<p><?php echo $lang_post['Post errors info'] ?></p>
			<ul>
<?php

	while (list(, $cur_error) = each($errors))
		echo "\t\t\t\t".'<li><strong>'.$cur_error.'</strong></li>'."\n";
?>
			</ul>
		</div>
	</div>
</div>

<?php

}

?>
<script type="text/javascript" src="include/lib/js/prototype.js"></script>
<script type="text/javascript" src="include/lib/js/chatbox.js"></script>
<div class="block">
   <h2>
    <span>
    	<span class="conr" ><img style="display:none;" id="loading" name="loading" src="img/chatbox/loading.gif" /></span>
	<?php echo $lang_chatbox['Chatbox'] ?> <span style="font-size:7px;vertical-align:super;">&copy; PBB ChatBox <?php if ($pun_config['o_show_version'] == '1') echo ' '.$pun_config['cb_pbb_version']; ?></span>
    </span>
  </h2>
	<div class="box">
		<div id="chatbox" class="inbox" style="overflow:auto;height:<?php echo $pun_config['cb_height'] ?>px;">
<?php

$cur_msg_txt = '';
$last_msg_time = '';
$count_id = array();

$result = $db->query('SELECT u.id, u.group_id, u.num_posts_chatbox, m.id AS m_id, m.poster_id, m.poster, m.poster_ip, m.poster_email, m.message, m.posted, g.g_id, g.g_title_chatbox FROM '.$db->prefix.'chatbox_msg AS m INNER JOIN '.$db->prefix.'users AS u ON u.id=m.poster_id INNER JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id ORDER BY m.posted DESC LIMIT '.$pun_config['cb_max_msg']) or error('Unable to fetch messages', __FILE__, __LINE__, $db->error());

$new_msg_time = false;
while ($cur_msg = $db->fetch_assoc($result)) {
	
	// Get newest timestamp
	if ($new_msg_time == false) {
		$last_msg_time = $cur_msg['posted'];
		$new_msg_time = true;
	}
	$cur_msg_txt = $pun_config['cb_space'].$cur_msg['g_title_chatbox'].$pun_config['cb_disposition'].$cur_msg_txt;
	
	if ($cur_msg['g_id'] != PUN_GUEST)
		$cur_msg_txt = str_replace('<pun_username>', '<a href="profile.php?id='.$cur_msg['id'].'">'.pun_htmlspecialchars($cur_msg['poster']).'</a>', $cur_msg_txt);
	else
		$cur_msg_txt = str_replace('<pun_username>', pun_htmlspecialchars($cur_msg['poster']), $cur_msg_txt);
	
	$cur_msg_txt = str_replace('<pun_date>', format_time($cur_msg['posted']), $cur_msg_txt);
	
	if ($cur_msg['g_id'] != PUN_GUEST)
		$cur_msg_txt = str_replace('<pun_nbpost>', $cur_msg['num_posts_chatbox'], $cur_msg_txt);
	else {
		if (!isset($count_id[$cur_msg['poster']])) {
			$like_command = ($db_type == 'pgsql') ? 'ILIKE' : 'LIKE';
		
			$count = $db->query('SELECT COUNT(id) FROM '.$db->prefix.'chatbox_msg WHERE poster '.$like_command.' \''.$db->escape(str_replace('*', '%', $cur_msg['poster'])).'\'') or error('Unable to fetch user chatbox post count', __FILE__, __LINE__, $db->error());
			$num_post = $db->result($count);
			$count_id[$cur_msg['poster']] = $num_post;
		}
		else
			$num_post = $count_id[$cur_msg['poster']];
		
		$cur_msg_txt = str_replace('<pun_nbpost>', $num_post, $cur_msg_txt);
	}
	
	$cur_msg_txt = str_replace('<pun_nbpost_txt>', $lang_chatbox['Posts'], $cur_msg_txt);
	
	if ($pun_user['g_id'] < PUN_GUEST) {
		$cur_msg_admin = ' [ <a href="chatbox.php?get_host='.$cur_msg['m_id'].'">'.$cur_msg['poster_ip'].'</a>';
		if ($cur_msg['poster_email'])
			$cur_msg_admin .= ' | <a href="mailto:'.$cur_msg['poster_email'].'">'.$lang_common['E-mail'].'</a> ]';
		else
			$cur_msg_admin .= ' ] ';
	}
	else
		$cur_msg_admin = '';
	
	$cur_msg_txt = str_replace('<pun_admin>', $cur_msg_admin, $cur_msg_txt);
	$cur_msg_txt = str_replace('<pun_message>', parse_message($cur_msg['message'], 0), $cur_msg_txt);
}

if (!$cur_msg_txt)
	echo $lang_chatbox['No Message'];
else
	echo "\t\t\t".$cur_msg_txt."\n";
?>
		</div>
	</div>
  <div class="chatbox">
    <span>
	<script language="javascript">
	<!--
	// This checkbox is utterly useless, unless we have javascript enabled. As such, we won't display it until then.
	document.write('<span class="conr" style="width:150px;" ><?php echo $lang_chatbox['Autoscroll'] ?>: <input type="checkbox" id="autoscroll" value="" checked  tabindex="<?php echo $cur_index++ ?>" /></span>');

	// -->
	</script>
<?php
if ($pun_user['g_post_chatbox'] == '1') {
    $cur_index = 1;
?>
      <form id="post" method="post" name="formulaire" action="chatbox.php" onsubmit="send_message(); return false;">
         <input type="hidden" name="form_sent" value="1" />
         <input type="hidden" name="form_user" id="form_user" value="<?php echo (!$pun_user['is_guest']) ? pun_htmlspecialchars($pun_user['username']) : 'Guest'; ?>" />
<?php
	if ($pun_user['is_guest']) {
		$email_label = ($pun_config['p_force_guest_email'] == '1') ? '<strong>'.$lang_common['E-mail'].':</strong>' : $lang_common['E-mail'];
		$email_form_name = ($pun_config['p_force_guest_email'] == '1') ? 'req_email' : 'email';
		
		if($email_form_name = 'req_email')
			echo "\t".'<input type="hidden" name="email" id="email" value="" />'."\n";
		else
			echo "\t".'<input type="hidden" name="req_email" id="req_email" value="" />'."\n";
?>
          <strong><?php echo $lang_post['Guest name'] ?>:</strong> <input type="text" name="req_username" id="req_username" value="<?php if (isset($_POST['req_username'])) echo pun_htmlspecialchars($username); ?>" size="15" maxlength="25" tabindex="<?php echo $cur_index++ ?>" /> 
          <?php echo $email_label ?> <input type="text" name="<?php echo $email_form_name ?>" id="<?php echo $email_form_name ?>" value="<?php if (isset($_POST[$email_form_name])) echo pun_htmlspecialchars($email); ?>" size="15" maxlength="50" tabindex="<?php echo $cur_index++ ?>" /> 
<?php
	}
	else {
?>
          <input type="hidden" name="req_username" id="req_username" value="" /> 
          <input type="hidden" name="email" id="email" value="" /> 
          <input type="hidden" name="req_email" id="req_email" value="" /> 
<?php
	}
?>
         <strong><?php echo $lang_chatbox['Message'] ?>:</strong> <input type="text" name="req_message"  id="req_message" value="<?php if (isset($_POST['req_message'])) echo pun_htmlspecialchars($message); ?>" size="35" maxlength="<?php echo $pun_config['cb_msg_maxlength'] ?>"  tabindex="<?php echo $cur_index++ ?>" /> 
         <input type="submit" name="submit" value="<?php echo $lang_chatbox['Btn Send'] ?>" accesskey="s" tabindex="<?php echo $cur_index++ ?>" />
	<script language="javascript">
	<!--
	document.formulaire.req_message.focus();
	// -->
	</script>
	</form>
<?php
}
else
	echo $lang_chatbox['No Post Permission'];
?>
    </span>
  </div>
</div>

<script language="javascript">
	// Begin getting messages
	var LastMsg = '<?php echo $last_msg_time; ?>';
	$('autoscroll').value = 'true';
	get_messages();
	checker = new PeriodicalExecuter(get_messages, <?php echo $pun_config['cb_ajax_refresh']; ?>);
</script>
<?php

require PUN_ROOT.'footer.php';
