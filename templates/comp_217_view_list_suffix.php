<?php
global $nc_l, $nc_translate; // перевод
echo "

				</div>
				<div class='clear'></div>
";
if($current_user['PermissionGroup_ID'] == 1) {
	echo "
				<div id='question-form' class='answerer-form'>
					<form name='adminForm' id='adminForm' enctype='multipart/form-data' method='post' action='/netcat/message.php'>
						<input name='admin_mode' type='hidden' value='$admin_mode' />
						<input name='catalogue' type='hidden' value='$catalogue' />
						<input name='cc' type='hidden' value='$cc' />
						<input name='sub' type='hidden' value='$sub' />
						<input name='message' type='hidden' value='0' />
						<input name='posting' type='hidden' value='1' />
						<input name='curPos' type='hidden' value='$curPos' />
						<input name='f_Parent_Message_ID' type='hidden' value='0' />
						<table>
							<tr>
								<td><label for='question'>{$nc_translate[5][$nc_l]}</label></td>
								<td><textarea id='question' name='f_answerer_text'></textarea></td>
							</tr>
							<tr>
								<td colspan='2'>
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
				

".($totRows > $f_RowNum
  ? "
				<div class='breadcrumbs'>
					<ul>
						". opt($prevLink, "<li class='prev'><a href='$prevLink' title=''>{$nc_translate[8][$nc_l]}</a></li>") ."
						". browse_messages($cc_env, 15) ."
						". opt($nextLink, "<li class='next'><a href='$nextLink' title=''>{$nc_translate[9][$nc_l]}</a></li>") ."
					</ul>
				</div>"
  : "")."
				<div class='clear'></div>




			</div>

";

?>