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


define('PUN_ROOT', 'forums/');
require_once PUN_ROOT.'include/common.php';

$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$pid = 30;
if ($id < 1 && $pid < 1)
	message($lang_common['Bad request']);

// Load the viewtopic.php language file
// require_once PUN_ROOT.'lang/'.$pun_user['language'].'/topic.php';

// If a post ID is specified we determine topic ID and page number so we can redirect to the correct message
if ($pid)
{
	$result = $db->query('SELECT topic_id FROM '.$db->prefix.'posts WHERE id='.$pid) or error('Unable to fetch post info', __FILE__, __LINE__, $db->error());
	if (!$db->num_rows($result))
		message($lang_common['Bad request']);

	$id = $db->result($result);

	// Determine on what page the post is located (depending on $pun_user['disp_posts'])
	$result = $db->query('SELECT id FROM '.$db->prefix.'posts WHERE topic_id='.$id.' ORDER BY posted') or error('Unable to fetch post info', __FILE__, __LINE__, $db->error());
	$num_posts = $db->num_rows($result);

	for ($i = 0; $i < $num_posts; ++$i)
	{
		$cur_id = $db->result($result, $i);
		if ($cur_id == $pid)
			break;
	}
	++$i;	// we started at 0

	$_GET['p'] = ceil($i / $pun_user['disp_posts']);
}

// Fetch some info about the topic
if (!$pun_user['is_guest'])
	$result = $db->query('SELECT t.subject, t.closed, t.num_replies, t.sticky, t.question, t.yes, t.no, f.id AS forum_id, f.forum_name, f.moderators, fp.post_replies, s.user_id AS is_subscribed FROM '.$db->prefix.'topics AS t INNER JOIN '.$db->prefix.'forums AS f ON f.id=t.forum_id LEFT JOIN '.$db->prefix.'subscriptions AS s ON (t.id=s.topic_id AND s.user_id='.$pun_user['id'].') LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND t.id='.$id.' AND t.moved_to IS NULL') or error('Unable to fetch topic info', __FILE__, __LINE__, $db->error());
else
	$result = $db->query('SELECT t.subject, t.closed, t.num_replies, t.sticky, t.question, t.yes, t.no, f.id AS forum_id, f.forum_name, f.moderators, fp.post_replies FROM '.$db->prefix.'topics AS t INNER JOIN '.$db->prefix.'forums AS f ON f.id=t.forum_id LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=f.id AND fp.group_id='.$pun_user['g_id'].') WHERE (fp.read_forum IS NULL OR fp.read_forum=1) AND t.id='.$id.' AND t.moved_to IS NULL') or error('Unable to fetch topic info', __FILE__, __LINE__, $db->error());

if (!$db->num_rows($result))
	message($lang_common['Bad request']);

$cur_topic = $db->fetch_assoc($result);

// Generate paging links

require_once PUN_ROOT.'header_frontpage.php';

// Mod poll begin
if ($cur_topic['question'])
{
	require_once PUN_ROOT . 'lang/' . $pun_user['language'] . '/polls.php'; 
    // get the poll data
    $result = $db->query('SELECT ptype,options,voters,votes FROM ' . $db->prefix . 'polls WHERE pollid=' . $id . '') or error('Unable to fetch poll info', __FILE__, __LINE__, $db->error());

    if (!$db->num_rows($result))
        message($lang_common['Bad request']);

    $cur_poll = $db->fetch_assoc($result);

    $options = unserialize($cur_poll['options']);
    if (!empty($cur_poll['voters']))
        $voters = unserialize($cur_poll['voters']);
    else
        $voters = array();

    $ptype = $cur_poll['ptype']; 
    // yay memory!
    // $cur_poll = null;
    $firstcheck = false;
    ?>
    	<?php
    if ((!$pun_user['is_guest']) && (!in_array($pun_user['id'], $voters)) && ($cur_topic['closed'] == '0') && (($cur_topic['post_replies'] == '1' || ($cur_topic['post_replies'] == '' && $pun_user['g_post_replies'] == '1')) || $is_admmod)) 
	{
		$showsubmit = true;
		?>
		<form id="post" method="post" action="forums/vote_frontpage.php">
			<div class="inform">
				<div class="rbox">
<div class="poll_info"><strong><?php echo pun_htmlspecialchars($cur_topic['question']) ?></strong></div>
					<div class="infldset txtarea">
						<input type="hidden" name="poll_id" value="<?php echo $id; ?>" />
						<input type="hidden" name="form_sent" value="1" />
						<input type="hidden" name="form_user" value="<?php echo (!$pun_user['is_guest']) ? pun_htmlspecialchars($pun_user['username']) : 'Guest'; ?>" />
	
						<?php
				        if ($ptype == 1) 
						{
							while (list($key, $value) = each($options)) 
							{
							?>
								<label><input name="vote" <?php if (!$firstcheck) { echo 'checked="checked"'; $firstcheck = true; }; ?> type="radio" value="<?php echo $key ?>" /> <span><?php echo pun_htmlspecialchars($value); ?></span></label>
							<?php
				            } 
				        } 
						elseif ($ptype == 2) 
						{
						    while (list($key, $value) = each($options)) 
							{         
							?>
								<label><input name="options[<?php echo $key ?>]" type="checkbox" value="1" /> <span><?php echo pun_htmlspecialchars($value); ?></span></label>
							<?php
				            } 
				        } 
						elseif ($ptype == 3) 
						{
							
							while (list($key, $value) = each($options)) 
							{
								echo pun_htmlspecialchars($value); ?>
								<label><input name="options[<?php echo $key ?>]" checked="checked" type="radio" value="yes" /> <?php echo $cur_topic['yes']; ?></label>
								<label><input name="options[<?php echo $key ?>]" type="radio" value="no" /> <?php echo $cur_topic['no']; ?></label>
								<br />
							<?php
				            } 
						} 
						else
						{
							message($lang_common['Bad request']);
						}
			?></div><?php
    } 
	else 
	{
		$showsubmit = false;
		?>
		<div class="inform">
		<div class="rbox">
			
			<div class="poll_info"><strong><?php echo pun_htmlspecialchars($cur_topic['question']) ?></strong></div>
			<?php
    		if (!empty($cur_poll['votes']))
    	    		$votes = unserialize($cur_poll['votes']);
    		else
          		$votes = array();
		
			if ($ptype == 1 || $ptype == 2) 
			{
				$total = 0;
				$percent = 0;
				$percent_int = 0;
				while (list($key, $val) = each($options)) 
				{
					if (isset($votes[$key]))
						$total += $votes[$key];
				}
				reset($options);
			}
			
		  	while (list($key, $value) = each($options)) {    

				if ($ptype == 1 || $ptype == 2)
				{ 
					if (isset($votes[$key]))
					{
						$percent =  $votes[$key] * 100 / $total;
						$percent_int = floor($percent);
					}
					?>
						<div class="poll_question"><?php echo pun_htmlspecialchars($value); ?></div>
						<div class="poll_result">
							<img src="img/transparent.gif" class="poll_bar" style="width:<?php if (isset($votes[$key])) echo $percent_int/2; else echo '0'; ?>%;" alt="" />
							<span><?php if (isset($votes[$key])) echo $percent_int . '% - ' . $votes[$key]; else echo '0% - 0'; ?></span>
						</div>
				<?php
				}
				else if ($ptype == 3) 
				{ 
					$total = 0;
					$yes_percent = 0;
					$no_percent = 0;
					$vote_yes = 0;
					$vote_no = 0;
					if (isset($votes[$key]['yes']))
					{
						$vote_yes = $votes[$key]['yes'];
					}

					if (isset($votes[$key]['no'])) {
						$vote_no += $votes[$key]['no'];
					}

					$total = $vote_yes + $vote_no;
					if (isset($votes[$key]))
					{
						$yes_percent =   floor($vote_yes * 100 / $total);
						$no_percent = floor($vote_no * 100 / $total);
					}
					?>
						<div class="poll_question_yesno"><?php echo pun_htmlspecialchars($value); ?></div>
						
						<div class="poll_result_yesno">
							<div class="poll_yesno_answer"><?php echo $cur_topic['yes']; ?></div>
								<img src="img/transparent.gif" class="poll_bar" style="width:<?php if (isset($votes[$key]['yes'])) { echo $yes_percent/2; } else { echo '0';  } ?>%;" alt="" />
								<span><?php if (isset($votes[$key]['yes'])) { echo $yes_percent . "% - " . $votes[$key]['yes']; } else { echo "0% - " . 0; } ?></span>
						</div>
						<div class="poll_result_yesno">						
							<div class="poll_yesno_answer"><?php echo $cur_topic['no']; ?></div>
								<img src="img/transparent.gif" class="poll_bar" style="width:<?php if (isset($votes[$key]['no'])) { echo $no_percent/2; } else { echo '0';  } ?>%;" alt="" />
								<span><?php if (isset($votes[$key]['no'])) { echo $no_percent . "% - " . $votes[$key]['no']; } else { echo "0% - " . 0; } ?></span>
						</div>
					<?php 
				}
				else
				message($lang_common['Bad request']);
            } 	
			?>
<?php echo '<a href="forums/viewtopic.php?id='.$id.'">Replies</a>'; ?><span class="poll_info"> - Total votes : <?php echo $total; ?></span>
			<?php
		} 
		?>
			</div>
				
			</div>

			<?php if ($showsubmit == true) 
			{ 
				echo '<p><input type="submit" name="submit" tabindex="2" value="' . $lang_common['Submit'] . '" accesskey="s" /> <input type="submit" name="null" tabindex="2" value="' . $lang_polls['Null vote']. '" accesskey="n" /></p>
				</form>';
echo '<a href="forums/viewtopic.php?id='.$id.'">Replies</a>';
			} 
			?>
<?php
}
// Mod poll end
