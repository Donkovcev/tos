<?php global $nc_l, $nc_translate; ?>
			<div class='profile'>
				<h1 class='profile_title'><?php echo $nc_translate[18][$nc_l]; ?></h1>
				<?php echo profileMenu(); ?>

				<div class='clear'></div>
				<div class='profile-page'>
					<div class='left_side'>
						<div class='pict'>
							<img width='102' height='132' src='<?php echo (($f_ForumAvatar && strlen($f_ForumAvatar) > 5) ? nc_file_path('User', $message, 'ForumAvatar', 'h_') : "/images/texasonshore/img/blank.gif"); ?>' alt='' />
						</div>
					</div>
					<div class='right_side' style='float: none;'>
						<table class='profile-info'>
						<?php
							registrationField('Login', $nc_translate[50][$nc_l]);
							registrationField('ForumName', $nc_translate[64][$nc_l]);
						?>
							<tr>
								<td class='width_120'><?php echo $nc_translate[82][$nc_l]; ?></td>
								<td>
									<em>
										<?php echo $f_information; ?>
									</em>
								</td>
							</tr>
						<?php
                            /*
                            $test = new LEASE_expense(1);

                            $test->insert();
                            */

							registrationField('contacts', $nc_translate[83][$nc_l]);
							registrationField('client_address_street', $nc_translate[66][$nc_l]);
							registrationField('client_address_zip', $nc_translate[67][$nc_l]);
							registrationField('client_address_city', $nc_translate[68][$nc_l]);
							registrationField('client_address_country', $nc_translate[69][$nc_l]);
							registrationField('client_phone', $nc_translate[70][$nc_l]);
							registrationField('delivery_address_name', $nc_translate[71][$nc_l]);
							registrationField('delivery_address_street', $nc_translate[72][$nc_l]);
							registrationField('delivery_address_zip', $nc_translate[73][$nc_l]);
							registrationField('delivery_address_city', $nc_translate[74][$nc_l]);
							registrationField('delivery_address_country', $nc_translate[75][$nc_l]);
							registrationField('payment_method', $nc_translate[76][$nc_l]);
							//registrationField('fiscal_year', 'Fiscal Year');
							registrationField('tax_code', $nc_translate[77][$nc_l]);
						?>
						</table>
						<a class='rbutton_4 edit_account' href='/profile/change/' title=''><?php echo $nc_translate[84][$nc_l]; ?></a>
						<div class='clear'></div>
					</div>
					<div class='clear'></div>
				</div>
				<div class='clear'></div>
			</div>
<?php
function registrationField($field, $name) {
	global ${"f_$field"};
	$field = ${"f_$field"};
	if(strlen($field) > 0) {
		echo "
							<tr>
								<td class='width_120'>$name</td>
								<td>$field</td>
							</tr>
		";
	}
}
?>