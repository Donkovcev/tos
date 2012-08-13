<?php


$nc_forum2_topic = nc_forum2_topic::get_object();

if ($nc_forum2_topic->get_closed_status($f_Topic_ID)) {
	$posting = 0;
}

if(!isset($current_user['ForumName']) && !nc_captcha_verify_code($nc_captcha_code, $nc_captcha_hash)) {
	$captcha_error = 1;
	$posting = 0;
}

$error_id = 0;

switch(true) {
	case (!$AUTH_USER_ID && !$f_Subject && !$f_Message):
	$error_id = 1;
	break;
	case (!$AUTH_USER_ID && !$f_Subject && $f_Message):
	$error_id = 2;
	break;
	case (!$AUTH_USER_ID && $f_Subject && !$f_Message):
	$error_id = 3;
	break;
	case ($AUTH_USER_ID && !$f_Message):
	$error_id = 4;
	break;
}

if($error_id != 0) {
	$posting = 0;
}

if($posting == 0) {
	$return_page = preg_replace('@(error|captcha)=\d?@', '', $_SERVER['HTTP_REFERER']);
	if(strpos($return_page, '?') === false) {
		if($error_id != 0)
			$return_page .= "?error=$error_id";
			
		if($captcha_error) {
			$return_page .= "&captcha=$captcha_error";
		}
	} else {
		if($error_id != 0)
			$return_page .= "&error=$error_id";
			
		if($captcha_error) {
			$return_page .= "&captcha=$captcha_error";
		}
	}
	$return_page = preg_replace('@&+@iu', '&', $return_page);
	$return_page = str_replace(".html?&", ".html?", $return_page);
	header("Location: $return_page");
	exit;
}


?>