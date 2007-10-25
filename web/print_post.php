<?php
function print_post($id) {
  define('PUN_ROOT', 'forums/');
  require_once PUN_ROOT.'include/common.php';
  require_once PUN_ROOT.'include/parser.php';
  global $db;

  $data = $db->query('SELECT message '
          . ' FROM posts '
          . ' WHERE id = ' .$id);

  $cur_post = $db->fetch_assoc($data);
  $cur_post['message'] = parse_message($cur_post['message'], $cur_post['hide_smilies']);

  echo $cur_post['message']."\n";
}
?>

