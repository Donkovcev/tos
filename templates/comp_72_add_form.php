<?php

// ".($warnText ? "<div class='warnText'>".$warnText."</div>" : "")."

echo "
			<div class='forum forum-main-wrapper'>
				<h1 class='title'>{$nc_translate[13][$nc_l]}</h1>
				<a class='create-new active' href='#' title=''>{$nc_translate[1][$nc_l]}</a>
				<div class='clear'></div>
				<div class='divider-dashed'></div>
				<div id='question-form'>
					<form name='adminForm' id='adminForm' enctype='multipart/form-data' method='post' action='".$SUB_FOLDER.$HTTP_ROOT_PATH."add.php'>
						<input name='admin_mode' type='hidden' value='".$admin_mode."'/>
						<input name='catalogue' type='hidden' value='".$catalogue."'/>
						<input name='cc' type='hidden' value='".$cc."'/>
						<input name='sub' type='hidden' value='".$sub."'/>
						<input name='posting' id='DataPostingField' type='hidden' value='1'/>
						<input name='curPos' type='hidden' value='".$curPos."'/>
						<input name='f_Parent_Message_ID' type='hidden' value='".$f_Parent_Message_ID."'/>
						<input type='hidden' id='ForumMessagePreview' name='ForumMessagePreview' value='0'/>
						<input type='hidden' name='f_Type' value='1' />
						<table>
";
if(!($AUTH_USER_ID && $current_user['ForumName'])) {
echo "
							<tr ". (($error_name && $error_name == 1) ? "class='required'" : "") .">
								<td><label for='name'>{$nc_translate[10][$nc_l]}<span class='required'>*</span></label></td>
								<td><input id='name' type='text' name='f_name' maxlength='255' value='". strip_tags($f_name) ."' /></td>
							</tr>
";
}
echo "
							<tr ". (($error_id && ($error_id == 1 || $error_id == 2)) ? "class='required'" : "") .">
								<td><label for='f_Subject'>{$nc_translate[11][$nc_l]}<span class='required'>*</span></label></td>
								<td><input id='f_Subject' type='text' name='f_Subject' maxlength='255' value='". strip_tags($f_Subject) ."' /></td>
							</tr>
							<tr ". (($error_id && ($error_id == 1 || $error_id == 3)) ? "class='required'" : "") .">
								<td><label for='question'>{$nc_translate[12][$nc_l]}<span class='required'>*</span></label></td>
								<td><textarea id='question' name='f_Message'>$f_Message</textarea></td>
							</tr>
							<tr>
								<td colspan='2'>
									<input class='real_submit' type='submit' value='publish' />
									<a id='send' href='#' title=''>{$nc_translate[2][$nc_l]}</a>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>

";

?>