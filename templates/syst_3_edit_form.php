<?php
global $nc_l, $nc_translate; // перевод
$profile_photo = (($f_ForumAvatar && strlen($f_ForumAvatar) > 5) ? nc_file_path('User', $message, 'ForumAvatar', 'h_') : "/images/texasonshore/img/blank.gif");
$avaCheck = ($f_ForumAvatar && strlen($f_ForumAvatar) > 5) ? true : false;
echo "

			<div class='profile'>
				<h1 class='profile_title'>{$nc_translate[18][$nc_l]}</h1>
				". profileMenu() ."
				<div class='clear'></div>
				<form name='adminForm' id='profile-form' enctype='multipart/form-data' method='post' action='/netcat/message.php'>
					<input name='admin_mode' type='hidden' value='$admin_mode' />
					<input name='catalogue' type='hidden' value='$catalogue' />
					<input name='cc' type='hidden' value='$cc' />
					<input name='sub' type='hidden' value='$sub' />
					<input name='message' type='hidden' value='$message' />
					<input name='posting' type='hidden' value='1' />
					<input name='curPos' type='hidden' value='$curPos' />
					<input name='f_Parent_Message_ID' type='hidden' value='$f_Parent_Message_ID' />
					<input name='profile_photo_input' type='hidden' value='". $profile_photo ."' />
					<div class='profile-page'>

						<div class='left_side'>
							<div class='pict'>
								<img width='102' height='132' src='". ($profile_photo_input ? $profile_photo_input : $profile_photo) ."' alt='' />
								". ((!$profile_photo_input && ((!$f_ForumAvatar) || ($f_ForumAvatar && strlen($f_ForumAvatar) < 2))) ? "<a id='choose_image' href='#' title=''>{$nc_translate[79][$nc_l]}</a>" : "") ."
							</div>
							". (($profile_photo_input || ($f_ForumAvatar && strlen($f_ForumAvatar) > 5)) ? "<a id='choose_image' class='change_photo' href='#' title=''>{$nc_translate[80][$nc_l]}</a>" : "") ."
							<div class='profile-ava ". ($avaCheck ? "profile-ava-true" : "profile-ava-false") ."'>". nc_file_field("ForumAvatar", "size='1' style='width: 80px'", $classID, 0) ."</div>
						</div>
						<div class='right_side'>
							<table class='profile-info'>

								". registrationField('Login', $nc_translate[50][$nc_l], 1, 1) ."
								". registrationPasswordField('password', $nc_translate[51][$nc_l], 5, 1) ."
								". registrationPasswordField('password1', $nc_translate[85][$nc_l], 6, 1) ."
								". registrationField('ForumName', $nc_translate[64][$nc_l], 3, 1) ."
								". registrationField('Email', 'Email', 7, 1) ."
								<tr>
									<td class='width_120'>{$nc_translate[82][$nc_l]}</td>
									<td><textarea name='f_information'>$f_information</textarea></td>
								</tr>
								". registrationField('contacts', $nc_translate[83][$nc_l]) ."
								". registrationField('client_address_street', $nc_translate[66][$nc_l]) ."
								". registrationField('client_address_zip', $nc_translate[67][$nc_l]) ."
								". registrationField('client_address_city', $nc_translate[68][$nc_l]) ."
								". registrationField('client_address_country', $nc_translate[69][$nc_l]) ."
								". registrationField('client_phone', $nc_translate[70][$nc_l]) ."
								". registrationField('delivery_address_name', $nc_translate[71][$nc_l]) ."
								". registrationField('delivery_address_street', $nc_translate[72][$nc_l]) ."
								". registrationField('delivery_address_zip', $nc_translate[73][$nc_l]) ."
								". registrationField('delivery_address_city', $nc_translate[74][$nc_l]) ."
								". registrationField('delivery_address_country', $nc_translate[75][$nc_l]) ."
								". registrationField('payment_method', $nc_translate[76][$nc_l]) ."
								<!--". registrationField('fiscal_year', 'Fiscal Year') ."-->
								". registrationField('tax_code', $nc_translate[77][$nc_l]) ."
							</table>
							<!--". (((!$f_ForumAvatar) || ($f_ForumAvatar && strlen($f_ForumAvatar) < 2)) ? "<input size='2' id='photo_file' type='file' name='f_ForumAvatar' ACCEPT='image/*' value='' />" : "") ."-->
							<a id='reg_button' class='rbutton_4 edit_account' href='#' title=''>{$nc_translate[140][$nc_l]}</a>
							<input class='real_submit' type='submit' />
							<div class='clear'></div>
						</div>
						<div class='clear'></div>
					</div>
				</form>

				<div class='clear'></div>
			</div>

";


function registrationField($field, $name, $error = 0, $req = 0) {
	global $warnText;
	global ${"f_$field"};
	$result = "
						<tr  ". (($warnText && $warnText == $error) ? "class='required'" : "") .">
							<td class='width_120'><label for='$field'>$name ". ($req == 1 ? "<span class='required'>*</span>" : "") ."</label></td>
							<td><input id='$field' type='text' name='f_$field' value='". ${"f_$field"} ."' /></td>
						</tr>
	";
	return $result;
}

function registrationPasswordField($field, $name, $error = 0, $req = 0) {
	global $warnText;
	global ${"f_$field"};
	$result = "
						<tr  ". (($warnText && $warnText == $error) ? "class='required'" : "") .">
							<td class='width_120'><label for='$field'>$name ". ($req == 1 ? "<span class='required'>*</span>" : "") ."</label></td>
							<td><input id='$field' type='password' name='f_$field' value='". ${"f_$field"} ."' /></td>
						</tr>
	";
	return $result;
}



?>