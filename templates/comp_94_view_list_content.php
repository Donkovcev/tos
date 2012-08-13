<?php
//var_dump($f_mailer_id);
	// выборка рассылок, на которые подписан пользователь или на которые у него есть право на подписку
	if ($f_subscribe ||  $nc_subscriber->check_rights($f_mailer_id)) {
	  // начало категориий (Подписан или возможно подписаться)
		if ($cur_subscribe != $f_subscribe) {
			$cur_subscribe = $f_subscribe;
		}
		$projects_subscribe = unserialize($current_user['subscribes']);
		
		if(isset($edit)) {
			echo "<li><label><input class='".($f_subscribe ? "subscribed" : "not-subscribed") ."' type='checkbox' name='subscribe_".$f_mailer_id."' value='".($f_subscribe ? "-1" : "1") ."' />$f_name</label>\r\n";
			
			if($f_name == 'New projects') {
				$another_res = $db->get_results("SELECT Message_ID, name FROM Message192 WHERE name IS NOT NULL AND LENGTH(name) > 1 AND Sub_Class_ID = 191 ORDER BY name;", ARRAY_A);
				echo "<ul>\r\n";
				
				if (!empty($another_res)) {
					foreach ($another_res as $item) {
						echo "<li><label><input ". (isset($projects_subscribe[$item['Message_ID']]) ? "checked=checked" : "") ." class='subscribed' type='checkbox' name='new_projects[]' value='{$item['Message_ID']}' />{$item['name']}</label></li>";
					}
				}
				
				echo "</ul>\r\n";
			}
			echo "</li>\r\n";
		
		} else {
			if($f_subscribe) {
				echo "<li>$f_name\r\n";
				
				if($f_name == 'New projects') {
					/*$res = $db->get_results("SELECT Message_ID, name FROM Message192 WHERE name IS NOT NULL AND LENGTH(name) > 1 AND Sub_Class_ID = 191 ORDER BY name;", ARRAY_A);*/
					echo "<ul>\r\n";
					if (!empty($another_res)) {
						foreach ($another_res as $item) {
							if(!isset($projects_subscribe[$item['Message_ID']])) {
								echo "<li>{$item['name']}</li>";						
							}
						}
					}
					
					echo "</ul>\r\n";
				}
				echo "</li>\r\n";			
			}
		}
	}
?>