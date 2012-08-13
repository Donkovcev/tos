<?php

if ($f_ForumName) {
  if ( !nc_preg_match("/^[а-яa-zА-Я0-9_,. -]+$/i", $f_ForumName) ) {
    //$warnText = "Неверный формат поля \"Имя пользователя\", используйте буквы, цифры, знак подчёркивания, дефис или пробел.";
	$warnText = 3;
    $posting = 0;
  } elseif ($db->get_var("SELECT User_ID FROM User WHERE '$f_ForumName' IN ($AUTHORIZE_BY, ForumName) AND User_ID != ".$current_user[User_ID])) {
    //$warnText = "Имя пользователя <b>$f_ForumName</b> занят другим пользователем";
    $warnText = 3;
	$posting = 0;
  }
}
/*
if($f_ForumSignature) {
  if( $f_ForumSignature && !nc_preg_match("/^[а-яa-zА-Я 0-9_,.-]+$/i", $f_ForumSignature) ) {
    $warnText = "неверный формат поля \"Подпись в форуме\", используйте буквы, цифры, знак подчёркивания, дефис или пробел.";
    $posting = 0;
  }
}
*/
if ($f_Email) {
  if ($db->get_var("SELECT User_ID FROM User WHERE Email = '$f_Email' AND User_ID != ".$message)) {
    $warnText = 7;
    $posting = 0;
  }
}

if(strlen($f_Login) < 4) {
    $warnText = 1;
    $posting = 0;
}
if(strlen($f_ForumName) < 4) {
    $warnText = 3;
    $posting = 0;
}


if(isset($f_password) && (strlen($f_password) > 4) && (isset($current_user['User_ID']))) {
	if(isset($f_password1) && $f_password1 == $f_password) {
		$f_password = trim($f_password);
		$db->query("UPDATE `User` SET `Password` = MD5('$f_password') WHERE User_ID = {$current_user['User_ID']} LIMIT 1;");
	}
	else {
		$warnText = 6;
		$posting = 0;		
	}
}
elseif (strlen($f_password) <= 4) {
	$warnText = 5;
	$posting = 0;		
}
else {
	$warnText = 5;
	$posting = 0;		
}

?>