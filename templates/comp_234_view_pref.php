<?php
	global $nc_l, $nc_translate; // перевод
?>
  <style type="text/css">
    .error {border:1px solid red;} 
  </style>
			<div class='profile'>
				<h1 class='profile_title'><?php echo $nc_translate[18][$nc_l]; ?></h1>
				<ul class='profile_menu'>
					<li class='item-0'><a href='#' title=''><?php echo $nc_translate[15][$nc_l]; ?></a></li>
					<li class='active  item-1'><a href='/profile/shopping-cart/' title=''><?php echo $nc_translate[118][$nc_l]; ?></a></li>
					<li><a href='/profile/mysubscribers/' title=''><?php echo $nc_translate[16][$nc_l]; ?></a></li>
					<li><a href='/profile/profile_<?php echo $AUTH_USER_ID; ?>.html' title=''><?php echo $nc_translate[17][$nc_l]; ?></a></li>
				</ul>
				<div class='clear'></div>
				<div class='profile-page'>
				
				</div>
			</div>