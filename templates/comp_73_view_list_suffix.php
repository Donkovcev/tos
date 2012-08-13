<?php
global $nc_l, $nc_translate; // перевод
/**** Выбираем все записи топика ****/
global $tags; // глобальный массив с ответами
global $topic_result; // глобальная строка, в которую мы потом запишем ответы
$tags = array();
$array = $db->get_results("SELECT m.Message_ID, m.User_ID, m.Created, m.Topic_ID, m.Message, m.Subject, m.date_display, m.parent_id, u.ForumName FROM Message73 as m, User as u WHERE m.Topic_ID = $topic AND m.User_ID = u.User_ID ORDER BY m.parent_id, m.Created", ARRAY_A);
$topic_num = $topic; // переменная с id топика нам еще понадобится

/**** Формируем многомерный массив ****/
if(is_array($array) && count($array) > 0) {
	foreach($array as $topic) {
		$tags[$topic['parent_id']][] = $topic; // распределяем ответы на главные и остальные (дочерние для других ответов)
	}
	
	/**** Формируем вывод записей, согласно странице ****/
	$total = count($tags[0]);
	$per_page = 5;
	if(!(isset($curPos) && is_integer($curPos) && (($curPos % $per_page) == 0)  &&  ($curPos < $total))) {
		$curPos = 0;
	}
	$needed = array_slice($tags[0], $curPos, $per_page);
	$tags[0] = $needed;
	/**** /Формируем вывод записей, согласно странице ****/
	
	topic_recursion(); // запуск рекурсии
}

echo $topic_result;

function topic_recursion($parent = 0, $level = 0) {
	global $tags, $topic_result;
	global $nc_l, $nc_translate; // перевод
	if($level < 5) ++$level;
	for($i=0; $i<count($tags[$parent]); $i++) {
$topic_result .= "
							<div class='item item-{$tags[$parent][$i]['Message_ID']} level-{$level} parent-{$tags[$parent][$i]['parent_id']}'>
								<div class='date'>{$tags[$parent][$i]['date_display']}</div>
								<div class='name'>
";
if($tags[$parent][$i]['User_ID'] == 0) {
	$topic_result .= $tags[$parent][$i]['Subject'];
} else {
	$topic_result .= $tags[$parent][$i]['ForumName'];
}
									
$topic_result .= "
								</div>
								<div class='text'>". nc_bbcode($tags[$parent][$i]['Message']) ."</div>
								<a class='answer' href='#{$tags[$parent][$i]['Message_ID']}' title=''>{$nc_translate[3][$nc_l]}</a>
								<div class='clear'></div>
							</div>
";
		if(isset($tags[$tags[$parent][$i]['Message_ID']])) {
			topic_recursion($tags[$parent][$i]['Message_ID'], $level);
		}
	}
}
/**** Форма для комментирования ****/
echo "
						<div id='answer-form'>
							<form name='adminForm' id='adminForm' enctype='multipart/form-data' method='post' action='".$SUB_FOLDER.$HTTP_ROOT_PATH."add.php'>
								<input name='admin_mode' type='hidden' value='".$admin_mode."'/>
								<input name='catalogue' type='hidden' value='".$catalogue."'/>
								<input name='cc' type='hidden' value='".$cc."'/>
								<input name='sub' type='hidden' value='".$sub."'/>
								<input name='posting' id='DataPostingField' type='hidden' value='1'/>
								<input name='curPos' type='hidden' value='".$curPos."'/>
								<input name='f_parent_id' type='hidden' value='0'/>
								<input name='f_Topic_ID' maxlength='12' size='12' type='hidden' value='$topic_num' />
";
// get topic object
$nc_forum2_reply = nc_forum2_reply::get_object();
echo "
								<table>
";
if(!$AUTH_USER_ID) {
	echo "								
									<tr ". ((isset($error) && ($error == 1 || $error == 2)) ? "class='required'" : "") ." >
										<td>
											<label for='name'>Your name<span class='required'>*</span> &nbsp;&nbsp;</label>
										</td>
										<td colspan='2'>
											<input type='text' value='' maxlength='255' id='name' name='f_Subject' />
										</td>
										<td>
	";
											if(isset($error) && ($error == 1 || $error == 2)) {
												echo "<span class='required'>{$nc_translate[4][$nc_l]}</span>";
											}
											echo "
										</td>
									</tr>
	";
}
echo "
									<tr ". ((isset($error) && ($error == 1 || $error == 3)) ? "class='required'" : "") .">
										<td>
											<label for='answer'>
												{$nc_translate[5][$nc_l]} <span class='required'>*</span>
											</label>
										</td>
										<td colspan='2'>
											<textarea id='f_Message' name='f_Message'></textarea>
											<script type='text/javascript' src='/netcat/editors/nc_UserEditor/lang/ru_utf8.js'></script>
											<script type='text/javascript' src='/netcat/editors/nc_UserEditor/nc_UserEditor.js'></script>
										</td>
										<td>
											";
											if(isset($error) && ($error == 1 || $error == 3)) {
												echo "<span class='required'>{$nc_translate[4][$nc_l]}</span>";
											}
											echo "
										</td>
									</tr>
";
if(!$AUTH_USER_ID) {
	echo "
									<tr ". ((isset($captcha) && $captcha == 1) ? "class='required'" : "") .">
										<td>
											<label for='code'>
											Code <span class='required'>*</span>
											</label>
										</td>
										<td>
											<div class='captcha-wrapper'>
												". nc_captcha_formfield() ."
											</div>
											<a class='update-captcha' href='#' title=''>{$nc_translate[6][$nc_l]}</a>
										</td>
										<td><input id='code' type='text' name='nc_captcha_code' /></td>
										<td>". ((isset($captcha) && $captcha == 1) ? "<span class='required'>{$nc_translate[7][$nc_l]}</span>" : "") ."</td>
									</tr>
	";
}
									echo "
									<tr>
										<td class='button-wrapper' colspan='3'>
											<a id='send_comment' class='publish' href='#' title=''>{$nc_translate[2][$nc_l]}</a>
											<br/>
											<input type='hidden' id='ForumMessagePreview' name='ForumMessagePreview' value='0'/>
											<div style='display: none;'>".nc_submit_button(NETCAT_MODERATION_BUTTON_ADD)."</div>
										</td>
										<td></td>
									</tr>
								</table>
							</form>
							<div class='clear'></div>
						</div>
				". opt(($totRows > $f_RowNum), "
				<div class='breadcrumbs'>
					<ul>
						". opt($prevLink, "<li class='prev'><a href='$prevLink' title=''>{$nc_translate[8][$nc_l]}</a></li>") ."
						". browse_messages($cc_env, 10) ."
						". opt($nextLink, "<li class='next'><a href='$nextLink' title=''>{$nc_translate[9][$nc_l]}</a></li>") ."
					</ul>
				</div>
				") ."
";

?>