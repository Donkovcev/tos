<?php

/*
ob_start();
*/
	if(strlen($current_user['subscribes']) > 4) {
		$subscribes = unserialize($current_user['subscribes']);
		if(is_array($subscribes)) {
			if(isset($subscribes[$f_RowID])) {
				$posting = 0;
			} else {
			}
		}
	}

?>