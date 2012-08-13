<?php

global $nc_l, $nc_translate; // перевод
echo "
			<div class='faq'>
				<h1>{$nc_translate[21][$nc_l]}</h1>
";
if(!$AUTH_USER_ID || $current_user['PermissionGroup_ID'] != 1) {
echo "
				<div id='question-form'>
					<form name='adminForm' id='adminForm' enctype='multipart/form-data' method='post' action='/netcat/add.php'>
						<input name='admin_mode' type='hidden' value='$admin_mode' />
						<input name='catalogue' type='hidden' value='$catalogue' />
						<input name='cc' type='hidden' value='$cc' />
						<input name='sub' type='hidden' value='$sub' />
						<input name='posting' type='hidden' value='1' />
						<input name='curPos' type='hidden' value='$curPos' />
						<input name='f_Parent_Message_ID' type='hidden' value='$f_Parent_Message_ID' />
						<table>
						
";
if(!$AUTH_USER_ID && !$current_user['ForumName']) {
	echo "
							<tr>
								<td><label for='name'>{$nc_translate[10][$nc_l]}<span class='required'>*</span></label></td>
								<td colspan='2'><input id='name' type='text' name='f_questioning_name' maxlength='255' /></td>
							</tr>
	";
}
echo "							
							
							<tr>
								<td><label for='question'>{$nc_translate[22][$nc_l]}<span class='required'>*</span></label></td>
								<td colspan='2'><textarea id='question' name='f_questioning_text'></textarea></td>
							</tr>
							". opt(($current_cc['UseCaptcha'] && $MODULE_VARS['captcha']), "
							<tr>
								<td><label for='code'>{$nc_translate[14][$nc_l]}</label></td>
								<td>
									<div class='captcha-wrapper'>
										". nc_captcha_formfield() ."
									</div>
									<!--<a class='update-captcha' href='#' title=''>{$nc_translate[6][$nc_l]}</a>-->
								</td>
								<td><input id='code' type='text' name='nc_captcha_code' style='width: 114px;' /></td>
							</tr>
") ."
							<tr>
								<td colspan='3'>
									<a id='send' href='#' title=''>{$nc_translate[23][$nc_l]}</a>
									<div style='display: none;'><input type='submit' value='{$nc_translate[23][$nc_l]}' /></div>
								</td>
							</tr>
						</table>
					</form>
				</div>
";
}
echo "
				<div class='questions'>
";

?>