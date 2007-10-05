<?php

define('PUN_ROOT', 'forums/');
require_once PUN_ROOT.'include/common.php';
require_once PUN_ROOT.'include/parser.php';

$id = 17;

//$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$data = $db->query('SELECT message '
        . ' FROM posts '
        . ' WHERE id = ' .$id);

$cur_post = $db->fetch_assoc($data);
$cur_post['message'] = parse_message($cur_post['message'], $cur_post['hide_smilies']);

echo $cur_post['message']."\n"

?>
