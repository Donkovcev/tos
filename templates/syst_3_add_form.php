<?php

/**
 *
 * @global type $warnText
 * @global type $nc_l
 * @global type $nc_translate
 * @param type $field
 * @param type $name
 * @param type $error
 * @param type $required
 * @param type $additional_required
 * @return string
 */
function registrationField($field, $name, $error = 0, $required = 0) {
	global $warnText, ${"f_" . $field};
	global $nc_l, $nc_translate;
	
	// 		<tr " . (($warnText && $warnText == $error) ? "class='required'" : "") . ">
	
	$result = "
		<tr>
			<td><label for='$field'>$name " . ($required === 1 ? "<span class='required'>*</span>" : "") . "</label></td>
			<td class='field-td'>
				<input id='$field' type='text' name='f_$field' value='${"f_" . $field}' />
				" . (($field == 'Email' && $warnText == 4) ? "<div class='error-wrapper'><label for='f_$field' class='error' style=''>{$nc_translate[139][$nc_l]}</label></div>" : "") . "
			</td>
			<td></td>
		</tr>
";

	return $result;
}

global $nc_l, $nc_translate; // перевод
if (checkAuth()) safe_redirect('/');
echo "
" . ( $nc_core->get_settings('deny_reg', 'auth') ? NETCAT_MODULE_AUTH_SELFREG_DISABLED : "
			<div class='registration'>
				<h1>{$nc_translate[62][$nc_l]}</h1>
				<form id='registration-form' enctype='multipart/form-data' method='post' action='/netcat/add.php'>
					<input name='admin_mode' type='hidden' value='$admin_mode' />
					<input name='catalogue' type='hidden' value='$catalogue' />
					<input name='cc' type='hidden' value='$cc' />
					<input name='sub' type='hidden' value='$sub' />
					<input name='posting' type='hidden' value='1' />
					<input name='curPos' type='hidden' value='$curPos' />
					<input name='Password2' type='hidden' value='' />
					<table class='reg'>
						" . registrationField('Login', $nc_translate[50][$nc_l], 1, 1) . "
						<tr " . (($warnText && $warnText == 2) ? "class='required'" : "") . ">
							<td><label for='password'>{$nc_translate[51][$nc_l]}<span class='required'>*</span></label></td>
							<td class='field-td'><input id='password' type='password' name='Password1' value='' /></td>
							<td>" . (($warnText && $warnText == 2) ? "<span class='required'>{$nc_translate[63][$nc_l]}</span>" : "") . "</td>
						</tr>
						<tr " . (($warnText && $warnText == 2) ? "class='required'" : "") . ">
							<td><label for='password2'>{$nc_translate[141][$nc_l]}<span class='required'>*</span></label></td>
							<td class='field-td'><input id='password2' type='password' name='Password2' value='' /></td>
							<td>" . (($warnText && $warnText == 2) ? "<span class='required'>{$nc_translate[63][$nc_l]}</span>" : "") . "</td>
						</tr>
						" . registrationField('ForumName', $nc_translate[64][$nc_l], 3, 1) . "
						" . registrationField('Email', $nc_translate[65][$nc_l], 4, 1) . "
						" . registrationField('client_address_street', $nc_translate[66][$nc_l]) . "
						" . registrationField('client_address_zip', $nc_translate[67][$nc_l]) . "
						" . registrationField('client_address_city', $nc_translate[68][$nc_l]) . "
						" . registrationField('client_address_country', $nc_translate[69][$nc_l]) . "
						" . registrationField('client_phone', $nc_translate[70][$nc_l]) . "
						" . registrationField('delivery_address_name', $nc_translate[71][$nc_l]) . "
						" . registrationField('delivery_address_street', $nc_translate[72][$nc_l]) . "
						" . registrationField('delivery_address_zip', $nc_translate[73][$nc_l]) . "
						" . registrationField('delivery_address_city', $nc_translate[74][$nc_l]) . "
						" . registrationField('delivery_address_country', $nc_translate[75][$nc_l]) . "
						" . registrationField('payment_method', $nc_translate[76][$nc_l]) . "
						<!--" . registrationField('fiscal_year', 'Fiscal Year') . "-->
						" . registrationField('tax_code', $nc_translate[77][$nc_l]) . "


						<tr>
							<td></td>
							<td>
								<a id='reg_button' class='rbutton_4 reg-button-margin' href='#' title=''>{$nc_translate[78][$nc_l]}</a>
								<input class='real_submit' type='submit' name='submit1' value='{$nc_translate[78][$nc_l]}' />
							</td>
							<td></td>
						</tr>
					</table>
				</form>
				<div class='clear'></div>
			</div>
" );
?>