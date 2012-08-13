<?php

if (strlen($f_Login) < 4) {
	$warnText = 1;
	$posting = 0;
}

if (strlen($Password1) < 4) {
	$warnText = 2;
	$posting = 0;
}

if (strlen($Password2) < 4) {
	$warnText = 2;
	$posting = 0;
}

if ($Password2 !== $Password1) {
	$warnText = 2;
	$posting = 0;
}

if ($f_ForumName) {
	if (!nc_preg_match("/^[а-яa-z 0-9_,.-]+$/i", $f_ForumName)) {
		$posting = 0;
		$warnText = 3;
	} elseif ($db->get_var("SELECT User_ID FROM User WHERE '$f_ForumName' IN ($AUTHORIZE_BY, ForumName)")) {
		$posting = 0;
		$warnText = 3;
	}
}

if ($f_Email) {
	if ($db->get_var("SELECT User_ID FROM User WHERE Email = '$f_Email'")) {
		$warnText = 4;
		$posting = 0;
	}
	if(!filter_var($f_Email, FILTER_VALIDATE_EMAIL)) {
		$warnText = 1;
		$posting = 0;	
	}
}




?>