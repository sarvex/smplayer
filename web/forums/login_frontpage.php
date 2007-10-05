<?php
 
// Show login if not logged in
if($pun_user['is_guest'])
{
	if(!isset($focus_element) || (isset($focus_element) && !in_array('login', $focus_element)))
	{
 
	// Load the language files
	require PUN_ROOT.'lang/'.$pun_user['language'].'/common.php';
	require PUN_ROOT.'lang/'.$pun_user['language'].'/login.php';

	// Set the $redirect_url to this page, 
	$redirect_url = '/fucmnack/index.php';
	if(isset($_SERVER['REQUEST_URI'])) {
		$redirect_url = $_SERVER['REQUEST_URI'] ;
	}

	$required_fields = array('req_username' => $lang_common['Username'], 'req_password' => $lang_common['Password']);
 
?>
<div id="login">
<form name="login" method="post" action="forums/login.php?action=in" onsubmit="return process_form(this)">
 <p style="padding: 0px; margin: 0px;">
  <input type="hidden" name="form_sent" value="1" />
  <input type="hidden" name="redirect_url" value="<?php echo $redirect_url ?>" />
  <?php echo $lang_common['Username'] ?>:
  <input type="text" name="req_username" size="9" maxlength="25" />
  <br><?php echo $lang_common['Password'] ?>:&nbsp
  <input type="password" name="req_password" size="9" maxlength="16" />
  <br><a href="#" onclick="document.login.submit(); return false"><?php echo $lang_common['Login'] ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="forums/register.php"><?php echo $lang_common['Register'] ?></a>
 </p>
</form>
</div>
<?php
	}
}else
{
?>
<div id="login">
<p style="padding: 0px; margin: 0px;">
<?php echo $lang_common['Logged in as'].' <strong>'.pun_htmlspecialchars($pun_user['username']).'</strong>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="forums/login_redirect.php?action=out&amp;id='.$pun_user['id'].'">'.$lang_common['Logout'].'</a>'; ?>
</p>
</div>
<?php
}
?>
