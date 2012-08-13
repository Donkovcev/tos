<?php

echo "
						</ul>
";
		if(isset($edit)) {
echo "
						<a id='reg_button' class='rbutton_4 edit_subscribe' href='#' title=''>{$nc_translate[20][$nc_l]}</a>
						<input class='real_submit' type='submit' value='{$nc_translate[20][$nc_l]}' />
";			
		} else {
echo "
						<a href='?edit' class='rbutton_4' title='' style='float: left;'>{$nc_translate[81][$nc_l]}</a>
";			
		}
echo "

						".($current_user['UserType'] == 'pseudo' ? "<input type='hidden' name='auth_hash' value='$auth_hash' />" : "")."
						<input type='hidden' name='redirect_url' value='/profile/mysubscribers/' />
					</form>
					<div class='clear'></div>
				</div>
				
				<div class='clear'></div>
			</div>

";

?>