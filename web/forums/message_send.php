<?php
/***********************************************************************

  Copyright (C) 2002, 2003, 2004  Rickard Andersson (rickard@punbb.org)

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

if(!$pun_config['o_pms_enabled'] || $pun_user['is_guest'] || $pun_user['g_pm'] == 0)
	message($lang_common['No permission']);

// Load the post.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/pms.php';
require PUN_ROOT.'lang/'.$pun_user['language'].'/post.php';

if (isset($_POST['form_sent']))
{
	// Flood protection
	if($pun_user['g_id'] > PUN_GUEST){
		$result = $db->query('SELECT posted FROM '.$db->prefix.'messages ORDER BY id DESC LIMIT 1') or error('Unable to fetch message time for flood protection', __FILE__, __LINE__, $db->error());
		if(list($last) = $db->fetch_row($result)){
			if((time() - $last) < $pun_user['g_post_flood'])
				message($lang_pms['Flood start'].' '.$pun_user['g_post_flood'].' '.$lang_pms['Flood end']);
		}
	}
	// Smileys
	if (isset($_POST['hide_smilies']))
		$smilies = 0;
	else
		$smilies = 1;

	// Check subject
	$subject = pun_trim($_POST['req_subject']);
	if ($subject == '')
		message($lang_post['No subject']);
	else if (pun_strlen($subject) > 70)
		message($lang_post['Too long subject']);
	else if ($pun_config['p_subject_all_caps'] == '0' && strtoupper($subject) == $subject && $pun_user['g_id'] > PUN_GUEST)
		$subject = ucwords(strtolower($subject));

	// Clean up message from POST
	$message = pun_linebreaks(pun_trim($_POST['req_message']));

	// Check message
	if ($message == '')
		message($lang_post['No message']);
	else if (strlen($message) > 65535)
		message($lang_post['Too long message']);
	else if ($pun_config['p_message_all_caps'] == '0' && strtoupper($message) == $message && $pun_user['g_id'] > PUN_GUEST)
		$message = ucwords(strtolower($message));

	// Validate BBCode syntax
	if ($pun_config['p_message_bbcode'] == '1' && strpos($message, '[') !== false && strpos($message, ']') !== false)
	{
		require PUN_ROOT.'include/parser.php';
		$message = preparse_bbcode($message, $errors);
	}
	if (isset($errors))
		message($errors[0]);

	// Get userid
	$result = $db->query('SELECT id, username, group_id FROM '.$db->prefix.'users WHERE id!=1 AND username=\''.addslashes($_POST['req_username']).'\'') or error('Unable to get user id', __FILE__, __LINE__, $db->error());

	// Send message
	if(list($id,$user,$status) = $db->fetch_row($result)){

		// Check inbox status
		if($pun_user['g_pm_limit'] != 0 && $pun_user['g_id'] > PUN_GUEST && $status > PUN_GUEST)
		{
			$result = $db->query('SELECT count(*) FROM '.$db->prefix.'messages WHERE owner='.$id) or error('Unable to get message count for the receiver', __FILE__, __LINE__, $db->error());
			list($count) = $db->fetch_row($result);
			if($count >= $pun_user['g_pm_limit'])
				message($lang_pms['Inbox full']);
				
			// Also check users own box
			if(isset($_POST['savemessage']) && intval($_POST['savemessage']) == 1)
			{
				$result = $db->query('SELECT count(*) FROM '.$db->prefix.'messages WHERE owner='.$pun_user['id']) or error('Unable to get message count the sender', __FILE__, __LINE__, $db->error());
				list($count) = $db->fetch_row($result);
				if($count >= $pun_user['g_pm_limit'])
					message($lang_pms['Sent full']);
			}
		}
		
		// "Send" message
		$db->query('INSERT INTO '.$db->prefix.'messages (owner, subject, message, sender, sender_id, sender_ip, smileys, showed, status, posted) VALUES(
			\''.$id.'\',
			\''.addslashes($subject).'\',
			\''.addslashes($message).'\',
			\''.addslashes($pun_user['username']).'\',
			\''.$pun_user['id'].'\',
			\''.get_remote_address().'\',
			\''.$smilies.'\',
			\'0\',
			\'0\',
			\''.time().'\'
		)') or error('Unable to send message', __FILE__, __LINE__, $db->error());

		// Save an own copy of the message
		if(isset($_POST['savemessage'])){
			$db->query('INSERT INTO '.$db->prefix.'messages (owner, subject, message, sender, sender_id, sender_ip, smileys, showed, status, posted) VALUES(
				\''.$pun_user['id'].'\',
				\''.addslashes($subject).'\',
				\''.addslashes($message).'\',
				\''.addslashes($user).'\',
				\''.$id.'\',
				\''.get_remote_address().'\',
				\''.$smilies.'\',
				\'1\',
				\'1\',
				\''.time().'\'
			)') or error('Unable to send message', __FILE__, __LINE__, $db->error());
		}
	}
	else{
		message($lang_pms['No user']);
	}
	
	$topic_redirect = intval($_POST['topic_redirect']);
	$from_profile = isset($_POST['from_profile']) ? intval($_POST['from_profile']) : '';
	if($from_profile != 0)
		redirect('profile.php?id='.$from_profile, $lang_pms['Sent redirect']);
	else if($topic_redirect != 0)
		redirect('viewtopic.php?id='.$topic_redirect, $lang_pms['Sent redirect']);
	else
		redirect('message_list.php', $lang_pms['Sent redirect']);
}
else
{
if (isset($_GET['id']))
	$id = intval($_GET['id']);
else
	$id = 0;

	if($id > 0){
		$result = $db->query('SELECT username FROM '.$db->prefix.'users WHERE id='.$id) or error('Unable to fetch message info', __FILE__, __LINE__, $db->error());
		if (!$db->num_rows($result))
			message($lang_common['Bad request']);
		list($username) = $db->fetch_row($result);
	}

	if(isset($_GET['reply']) || isset($_GET['quote'])){
		$r = isset($_GET['reply']) ? intval($_GET['reply']) : 0;
		$q = isset($_GET['quote']) ? intval($_GET['quote']) : 0;

		// Get message info
		empty($r) ? $id = $q : $id = $r;
		$result = $db->query('SELECT * FROM '.$db->prefix.'messages WHERE id='.$id.' AND owner='.$pun_user['id']) or error('Unable to fetch message info', __FILE__, __LINE__, $db->error());
		if (!$db->num_rows($result))
			message($lang_common['Bad request']);
		$message = $db->fetch_assoc($result);

		// Quote the message
		if(isset($_GET['quote']))
			$quote = '[quote='.$message['sender'].']'.$message['message'].'[/quote]';

		// Add subject
		$subject = "RE: " . $message['subject'];
	}

	$action = $lang_pms['Send a message'];
	$form = '<form method="post" id="post" action="message_send.php?action=send" onsubmit="return process_form(this)">';

	$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / '.$action;
	$form_name = 'post';

	$cur_index = 1;
	if (!isset($username))
		$username = '';
	if (!isset($quote))
		$quote = '';
	if (!isset($subject))
		$subject = '';
	require PUN_ROOT.'header.php';
?>
<div class="blockform">
	<h2><span><?php echo $action ?></span></h2>
	<div class="box">
	<?php echo $form."\n" ?>
		<div class="inform">
		<fieldset>
			<legend><?php echo $lang_common['Write message legend'] ?></legend>
			<div class="infldset txtarea">
				<input type="hidden" name="form_sent" value="1" />
				<input type="hidden" name="topic_redirect" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>" />
				<input type="hidden" name="topic_redirect" value="<?php echo isset($_POST['from_profile']) ? $_POST['from_profile'] : '' ?>" />
				<input type="hidden" name="form_user" value="<?php echo (!$pun_user['is_guest']) ? pun_htmlspecialchars($pun_user['username']) : 'Guest'; ?>" />
				<label class="conl"><strong><?php echo $lang_pms['Send to'] ?></strong><br /><?php echo '<input type="text" name="req_username" size="25" maxlength="25" value="'.pun_htmlspecialchars($username).'" tabindex="'.($cur_index++).'" />'; ?><br /></label>
				<div class="clearer"></div>
				<label><strong><?php echo $lang_common['Subject'] ?></strong><br /><input class="longinput" type='text' name='req_subject' value='<?php echo pun_htmlspecialchars($subject) ?>' size="80" maxlength="70" tabindex='<?php echo $cur_index++ ?>' /><br /></label>
						<?php require PUN_ROOT.'mod_modern_bbcode.php'; ?>
						<label><textarea name="req_message" rows="7" cols="75" tabindex="1"></textarea></label>
						<ul class="bblinks">
							<li><a href="help.php#bbcode" onclick="window.open(this.href); return false;"><?php echo $lang_common['BBCode'] ?></a>: <?php echo ($pun_config['p_message_bbcode'] == '1') ? $lang_common['on'] : $lang_common['off']; ?></li>
							<li><a href="help.php#img" onclick="window.open(this.href); return false;"><?php echo $lang_common['img tag'] ?></a>: <?php echo ($pun_config['p_message_img_tag'] == '1') ? $lang_common['on'] : $lang_common['off']; ?></li>
							<li><a href="help.php#smilies" onclick="window.open(this.href); return false;"><?php echo $lang_common['Smilies'] ?></a>: <?php echo ($pun_config['o_smilies'] == '1') ? $lang_common['on'] : $lang_common['off']; ?></li>
						</ul>
					</div>
				</fieldset>
<?php
	$checkboxes = array();

	if ($pun_config['o_smilies'] == '1')
		$checkboxes[] = '<label><input type="checkbox" name="hide_smilies" value="1" tabindex="'.($cur_index++).'"'.(isset($_POST['hide_smilies']) ? ' checked="checked"' : '').' />'.$lang_post['Hide smilies'];

	$checkboxes[] = '<label><input type="checkbox" name="savemessage" value="1" checked="checked" tabindex="'.($cur_index++).'" />'.$lang_pms['Save message'];

	if (!empty($checkboxes))
	{
?>
			</div>
			<div class="inform">
				<fieldset>
					<legend><?php echo $lang_common['Options'] ?></legend>
					<div class="infldset">
						<div class="rbox">
							<?php echo implode('<br /></label>'."\n\t\t\t\t", $checkboxes).'<br /></label>'."\n" ?>
						</div>
					</div>
				</fieldset>
<?php
	}
?>
			</div>
			<p><input type="submit" name="submit" value="<?php echo $lang_pms['Send'] ?>" tabindex="<?php echo $cur_index++ ?>" accesskey="s" /><a href="javascript:history.go(-1)"><?php echo $lang_common['Go back'] ?></a></p>
		</form>
	</div>
</div>
<?php
	require PUN_ROOT.'footer.php';
}
