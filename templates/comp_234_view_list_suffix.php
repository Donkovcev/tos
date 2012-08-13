							</form>
			<tr class='footer-row'>
				<td id='first-footer-col'></td>
				<td id='footer-sum'>
					<div class='valute' >
						<button class="currency <?php echo getDefaultCurrency(); ?>"></button>
					</div>
					<div class='cost'>
						<p>0</p>
					</div>
					<div class='footer-rate-control'>
						<div class='buy-btn'>
							<form id="__t"action="<? if(isset($_SESSION['cart'])) { echo '/profile/registration/'; } else { echo 'https://test.paysecure.ru/pay/order.cfm'; /*echo 'http://teslitsky.info/assist.php';*/ } ?>" method="post">
							<input type="hidden" name="Merchant_ID" value="<?php echo Merchant_ID; ?>" />
							<input type="hidden" name="OrderNumber" value="<?php global $OrderNumber; echo $OrderNumber; ?>" />
							<input type="hidden" name="OrderAmount" value="" />
							<input type="hidden" name="OrderComment" value="<?php echo AssistText($OrderNumber); ?>" />
							<input type="hidden" name="AssistIDPayment" value="0" />
							<input type="hidden" name="OrderCurrency" value="USD" />
							<input type="hidden" name="Language" value="<?php echo ($current_catalogue['Domain'] == 'tos-invest.com' ? "EN" : "RU"); ?>" />
							<input type="hidden" name="URL_RETURN" value="http://<?php echo $current_catalogue['Domain']; ?>/profile/shopping-cart/" />
							<input type="hidden" name="URL_RETURN_OK" value="http://<?php echo $current_catalogue['Domain']; ?>/profile/shopping-cart/" />
							<input class="small-rbutton-2 <?php echo ($current_catalogue['Domain'] == 'ru.tos-invest.com' ? "width-40" : ""); ?>" type="submit" name="submit" value="<?php echo $nc_translate[35][$nc_l]; ?>">
						</div>
						<a class='small-rbutton-del'></a>
						</form>
					</div>
					<div class="clear"></div>
				</td>
				<td class="available"></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
	<br>
	<?php
	if($current_catalogue['Domain'] == 'tos-invest.com') {
		echo "I agree to the <a href='". $current_catalogue['agreement'] ."' title=''>terms of this contract</a>";
	} else {
		echo "Я согласен с <a href='". $current_catalogue['agreement'] ."' title=''>условиями соглашения</a>";
	}
	?>
					<div class='clear'></div>
<?php
	if ($AUTH_USER_ID == 79) {
		//error_reporting(E_ALL);
		echo 'debug info:<br>';
		print_r(getDefaultCurrency());
		var_dump(getExchangeRateByCurrency());
	}
?>
<script type="text/javascript">
	window.onload = function(){
		//jQuery(document).ready(function(e){
			jQuery('#__t').submit(function(e){
				var r = $(this).find('input[name=OrderAmount]');
				var val = parseInt(r.val());
				if(isNaN(val) || val<=0){
					alert('Неверное значение суммы');
					e.preventDefault();
				}
			});
		//})
	}
</script>