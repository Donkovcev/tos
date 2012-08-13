<?php

$f_Type = 1;
if ($f_Closed) {
  switch ($cc_settings['closed']) {
    case 'auth':
      if (!$AUTH_USER_ID) $f_Closed = 0;
    break;
    case 'moders':
    case 'admins':
      if ( !( is_object($perm) && $perm->isSubClass($cc, MASK_MODERATE | MASK_ADMIN) ) ) $f_Closed = 0;
    break;
  }
}
if(!($AUTH_USER_ID && $current_user['ForumName']) && (!$f_name || strlen($f_name) < 4)) {
	$posting = 0;
	$error_name = 1;
}
if(!$f_Subject && !$f_Message) {
  $error_id = 1;
  $posting = 0;
} else if(!$f_Subject && $f_Message) {
  $error_id = 2;
  $posting = 0;
} else if($f_Subject && !$f_Message) {
  $error_id = 3;
  $posting = 0;
}

?>