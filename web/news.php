<?php
 
define('PUN_ALLOW_INDEX', 1);
require_once PUN_ROOT.'header_frontpage.php';
require_once PUN_ROOT.'include/parser.php';
require_once PUN_ROOT.'lang/'.$pun_user['language'].'/common.php';
require_once PUN_ROOT.'lang/'.$pun_user['language'].'/topic.php';
require_once PUN_ROOT.'lang/'.$pun_user['language'].'/login.php';

//----------------------------------------------------------------------//

//These are the forums from which the news is retrieved
$forumids = array(5);

//This is the overall limit for how many news items will be displayed
$master_limit = '4';

//This is the amount of characters above which truncation will occur
$trunc_chars = '7000';

//----------------------------------------------------------------------//

function close_tags($string)
{
    if (preg_match_all ('/<([a-z]+)[ >]/', $string, $start_tags))
    {
        $start_tags = $start_tags[1];

        if (preg_match_all ('/<\/([a-z]+)>/', $string, $end_tags))
        {
            $complete_tags = array();
            $end_tags = $end_tags[1];

            foreach ($start_tags as $key => $val)
            {
                $posb = array_search ($val, $end_tags);
                if (is_integer ($posb))
                {
                    unset ($end_tags[$posb]);
                }
                else
                {
                    $complete_tags[] = $val;
                }
            }
        }
        else
        {
            $complete_tags = $start_tags;
        }

        $complete_tags = array_reverse ($complete_tags);
        for ($i = 0; $i < count ($complete_tags); $i++)
        {
            $string .= '</' . $complete_tags[$i] . '>';
        }
    }

        // Removes irrelevant tags
    $xhtml_tags = array ('</img>', '</hr>', '</br>');
    $string = str_replace ($xhtml_tags, '', $string);
    return $string;
}

//----------------------------------------------------------------------//

function truncate($string)
{
global $pun_config;
$trunc_chars = '5000';
$length = $trunc_chars;
$append = '...';

    if (strlen ($string) <= $length)
    {
        return $string;
    }
    else if ($length > 0)
    {
        preg_match ('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$length.',}\b#U', $string, $matches);
        $string = $matches[0];
        $string = close_tags (preg_replace ('#\s*<[^>]+>?\s*$#', '', $string).$append);
        return $string;
    }
}

//----------------------------------------------------------------------//

$result = $db->query('SELECT t.id, t.subject, t.num_replies, t.last_post, t.last_post_id, t.last_poster, t.num_views, t.forum_id, u.use_avatar, u.num_posts, u.registered, u.title, p.id AS pid, p.poster, p.poster_id, p.message, p.hide_smilies, p.posted, g.g_title, f.forum_name FROM '.$db->prefix.'topics AS t INNER JOIN '.$db->prefix.'posts AS p ON p.topic_id=t.id AND p.posted=t.posted INNER JOIN '.$db->prefix.'users AS u ON u.id=p.poster_id LEFT JOIN '.$db->prefix.'groups AS g ON g.g_id=u.group_id INNER JOIN '.$db->prefix.'forums AS f ON f.id=t.forum_id WHERE t.forum_id IN ('.implode(',', $forumids).') AND t.moved_to IS NULL AND f.redirect_url IS NULL ORDER BY t.posted DESC LIMIT '.$master_limit) or error('Unable to fetch announcements', __FILE__, __LINE__, $db->error());

if ($db->num_rows($result))
{
    while($cur_post = $db->fetch_assoc($result))
    {
        echo '<div class="block">';
      $news_message = parse_message($cur_post['message'], $cur_post['hide_smilies']);

        if (pun_strlen($news_message) > $trunc_chars)
        {
            $news_message = truncate($news_message);
            $read_more = '&nbsp;|&nbsp;<a href="forums/viewtopic.php?id='.$cur_post['id'].'">Read More</a>';
        }
        else
        {
            $read_more = '';
        }

        if ($cur_post['num_replies'] != '0')
        {
            $replies = '&nbsp;<a href="forums/viewtopic.php?id='.$cur_post['id'].'#p'.$cur_post['last_post_id'].'">Replies</a>:&nbsp;'.$cur_post['num_replies'].'&nbsp;';
        }
        else
        {
            $replies = '&nbsp;Replies: '.$cur_post['num_replies'].'&nbsp;';
        }

echo '<div class="subject"><a style="text-decoration: none;" href="/new/forums/viewtopic.php?id='.$cur_post['id'].'">'.pun_htmlspecialchars($cur_post['subject']).'</a>'.'</div>'."\n";
?>
<div class="news_content">
<?php echo $news_message."\n" ?>
</div>
<?php

if ($cur_post['poster_id'] == $pun_user['id'] || $pun_user['g_id'] < PUN_GUEST){
echo '<div class="news_info">'.format_time($cur_post['posted']).' by<span class="user'.(isset($cur_post['g_title']) ? ' '.strtolower(str_replace(' ', '', $cur_post['g_title'])) : '').'">&nbsp;<a class="poster" href="/new/forums/profile.php?id='.$cur_post['poster_id'].'">'.pun_htmlspecialchars($cur_post['poster']).'</a>'.$read_more.'</span></div>';

                echo '<div class="news_actions">'.'<a href="/new/forums/delete.php?id='.$cur_post['pid'].'">'.$lang_topic['Delete'].'</a> | <a href="/new/forums/edit.php?id='.$cur_post['pid'].'">'.$lang_topic['Edit'].'</a>'.' | <a href="/new/forums/post.php?tid='.$cur_post['id'].'">'.'Reply'.'</a>'.' | <a href="/new/forums/post.php?tid='.$cur_post['id'].'&amp;qid='.$cur_post['pid'].'">'.$lang_topic['Quote'].'</a>'.'</div>'."\n\n";
            }else{
 
               echo '<div class="news_info">'.format_time($cur_post['posted']).' by<span class="user'.(isset($cur_post['g_title']) ? ' '.strtolower(str_replace(' ', '', $cur_post['g_title'])) : '').'">&nbsp;<a class="poster" href="/new/forums/profile.php?id='.$cur_post['poster_id'].'">'.pun_htmlspecialchars($cur_post['poster']).'</a>'.$read_more.'</span></div>'."\n";
}
?>
</div>
<?php
    }
}
?>
