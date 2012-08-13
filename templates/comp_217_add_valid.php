<?php


if(!$AUTH_USER_ID || $current_user['PermissionGroup_ID'] != 1) {
	
	//AUTH_USER_ID
	if(!$AUTH_USER_ID && (strlen(trim($f_questioning_name)) < 5) && (strlen(trim($f_questioning_text)) < 5)) {
		$posting = 0;
		$error_id = 1;
	} else if(!$AUTH_USER_ID && strlen(trim($f_questioning_name)) < 5) {
		$posting = 0;
		$error_id = 2;
	} else if(strlen(trim($f_questioning_text)) < 5) {
		$posting = 0;
		$error_id = 3;
	}
	
	if($posting == 0 && $error_id) {
		$return_page = preg_replace('@(error|captcha)=\d?@', '', $_SERVER['HTTP_REFERER']);

		if(strpos($return_page, '?') === false) {
			$return_page .= "?error=$error_id";
		} else {
			$return_page .= "&error=$error_id";
		}
			$return_page = preg_replace('@&+@iu', '&', $return_page);
			$return_page = str_replace("/?&", "/?", $return_page);
			header("Location: $return_page");
			exit;
	}
}


?>