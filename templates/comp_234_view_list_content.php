<?php
	global $nc_l, $nc_translate;
	global $OrderNumber;
	$project = $db->get_var("SELECT name FROM Message192 WHERE Message_ID = $f_project_id");
	$project_params = $db->get_row("SELECT Message_ID, name FROM Message192 WHERE Message_ID = $f_project_id", ARRAY_A);
?>

			<tr class="first-row">
				<td class="project first-column">
					<a class="name" href="http://tos-invest.com/project/projects-for-sale/?buy-item=<?php echo $f_project_id; ?>" title="<?php echo $project; ?>"><?php echo $project; ?></a><br>
					<div class="clear"></div>
				</td>
				<td class="purchased">
					<div class="quantity-wrapper">
						<div class="quantity-field">
							<input type="text" name="buy_quantity" value="<?php echo $f_quantity; ?>" <?if($f_selling_id):?> disabled="disabled"<?endif;?>>
							<input type="hidden" name="price" value="<?php echo $f_price; ?>">
							<input type="hidden" name="cart_id" value="<?php echo $f_RowID; ?>">
							<input type="hidden" name="project_id" value="<?php echo $f_project_id ?>">
							<input type="hidden" name="OrderNumber" value="<?php echo $OrderNumber ?>">
							<input type="hidden" name="auth" value="<?php echo (($AUTH_USER_ID && $AUTH_USER_ID > 0) ? "1" : "0"); ?>">
							<?if(!$f_selling_id):?>
							<a class='increase' href='#+' title='<?php echo $nc_translate[119][$nc_l]; ?>'><?php echo $nc_translate[119][$nc_l]; ?></a>
							<a class='decrease' href='#-' title='<?php echo $nc_translate[120][$nc_l]; ?>'><?php echo $nc_translate[120][$nc_l]; ?></a>
							<?endif;?>
						</div>
					</div>
					<div class='valute'>
						<button class="currency <?php echo getDefaultCurrency(); ?>"></button>
					</div>
					<div class='cost'>
						<p><?php echo $f_price*$f_quantity*getExchangeRateByCurrency(); ?></p>
					</div> 
					<div class='purchased-check'>
						<input type="checkbox" class="purchased-checkbox" style="opacity: 0; ">
					</div>
					<div class="clear"></div>
				</td>
				<td class="available">
					<?php echo getAvailableSharesCount($project_params['Message_ID'], $f_selling_id); ?>
				</td>
			</tr>


<?php
/*
				<tr>
					<td class='project'>
						<a class='name' href='/project/ready-bore-projects/?buy-item=<?php echo $f_project_id; ?>' title=''><?php echo $project; ?></a><br/>
						<div class='clear'></div>
					</td>
					<td class='purchased'>
						<div class='quantity-wrapper'>
							<div class='quantity-field'>
								<input type='text' name='buy_quantity' value='<?php echo $f_quantity; ?>' />
								<input type='hidden' name='price' value='<?php echo $f_price; ?>' />
								<input type='hidden' name='cart_id' value='<?php echo $f_RowID; ?>' />
								<input type='hidden' name='project_id' value='<?php echo $f_project_id ?>' />
								<input type='hidden' name='auth' value='<?php echo (($AUTH_USER_ID && $AUTH_USER_ID > 0) ? "1" : "0"); ?>' />
								<a class='increase' href='#+' title='<?php echo $nc_translate[119][$nc_l]; ?>'><?php echo $nc_translate[119][$nc_l]; ?></a>
								<a class='decrease' href='#-' title='<?php echo $nc_translate[120][$nc_l]; ?>'><?php echo $nc_translate[120][$nc_l]; ?></a>
							</div>
						</div>
					</td>
					<td class='rate'>
						<form action="https://test.paysecure.ru/pay/order.cfm" method="post" />
							<input type="hidden" name="Merchant_ID" value="<?php echo Merchant_ID; ?>" />
							<input type="hidden" name="OrderNumber" value="<?php echo $f_OrderNumber; ?>" />
							<input type="hidden" name="OrderAmount" value="" />
							<input type="hidden" name="OrderComment" value="<?php echo AssistText($f_OrderNumber); ?>" />
							<input type="hidden" name="AssistIDPayment" value="0" />
							<input type="hidden" name="OrderCurrency" value="USD" />
							<input type="hidden" name="Language" value="<?php echo ($current_catalogue['Domain'] == 'tos-invest.com' ? "EN" : "RU"); ?>" />
							<input type="hidden" name="URL_RETURN" value="http://<?php echo $current_catalogue['Domain']; ?>/profile/shopping-cart/" />
							<input type="hidden" name="URL_RETURN_OK" value="http://<?php echo $current_catalogue['Domain']; ?>/profile/shopping-cart/" />
							<input class='small-rbutton-2 <?php echo ($current_catalogue['Domain'] == 'ru.tos-invest.com' ? "width-40" : ""); ?>' type='submit' name='submit' value='<?php echo $nc_translate[35][$nc_l]; ?>' />
						</form>
					</td>
				</tr>
*/
?>
