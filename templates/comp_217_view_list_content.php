<?php
global $nc_l, $nc_translate; // перевод
echo "
					<div class='item'>
						<div class='name'>
";
if($f_UserID == 0) {
	echo $f_questioning_name;
} else {
	$questioning_name = $db->get_var("SELECT `ForumName` FROM `User` WHERE `User_ID` = $f_UserID LIMIT 1;");
	echo $questioning_name;
}							
echo "
						</div>
						<div class='text'>
							$f_questioning_text
							<div class='clear'></div>
						</div>
";
if($f_answerer_text) {
	$user_name = $db->get_var("SELECT `ForumName` FROM `User` WHERE `User_ID` = $f_LastUserID LIMIT 1;");
	echo "
						<div class='item'>
							<div class='answer'>{$nc_translate[5][$nc_l]}</div>
							<div class='name'>$user_name</div>
							<div class='text'>
								$f_answerer_text
								<div class='clear'></div>
							</div>							
						</div>
	";
} else if($current_user['PermissionGroup_ID'] == 1) {
	echo "
						<a class='answer' href='#$f_RowID' title=''>{$nc_translate[3][$nc_l]}</a>
						<div class='clear'></div>
	";
}
echo "
					</div>
";

?>