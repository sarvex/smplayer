<?php
 
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';

//query info out of the DB
$result = $db->query("SELECT id, title, content FROM ".$db_prefix."pages WHERE id='".intval($_GET['id'])."'") or error('Unable to fetch page information', __FILE__, __LINE__, $db->error());
if (!$db->num_rows($result))
	message($lang_common['Bad request']);
	
$data = $db->fetch_assoc($result);

//Set the page title here
$page_title = pun_htmlspecialchars($pun_config['o_board_title']) . ' / '. $data['title'];
define('PUN_ALLOW_INDEX', 1);
require PUN_ROOT.'header.php';

//replace custom bbcode
$pattern = array('#\n\[page_title=([^\[]*?)\]#s',
				 '#\n\[page_break\]#s');
$replace = array("\n\t\t".'</div>'."\n\t".'</div>'."\n".'</div>'."\n".'<div class="block">'."\n\t".'<h2><span>$1</span></h2>'."\n\t".'<div class="box">'."\n\t\t".'<div class="inbox">',
				 "\n\t\t".'</div>'."\n\t".'</div>'."\n".'</div>'."\n".'<div class="block">'."\n\t".'<div class="box">'."\n\t\t".'<div class="inbox">');
				 
$content = preg_replace($pattern, $replace, $data['content']);

?>
<div class="block">
	<h2><span><?php echo $data['title'] ?></span></h2>
	<div class="box">
		<div class="inbox">
<!--==================-->
<!--Start Page Content-->
<?php echo $content."\n" ?>
<!-- End Page Content -->
<!--==================-->
		</div>
	</div>
</div>
<?php
require PUN_ROOT.'footer.php';