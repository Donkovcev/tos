<?php

if($current_user['PermissionGroup_ID'] == 1) {
	
	if(strlen(trim($f_answerer_text)) < 5) {
		$posting = 0;
		$error_id = 3;
	}
	
	if($posting == 0 && $error_id) {
		$return_page = preg_replace('@error=\d?@', '', $_SERVER['HTTP_REFERER']);

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