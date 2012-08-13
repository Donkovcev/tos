<?php global $nc_l, $nc_translate; // перевод ?>
<?php

global $OrderNumber;
if(isset($_GET['ordernumber'])) {
	print_r(getAssistStatusAttr($_GET['ordernumber']));
} else {
	// Пишем случайный OrderNumber для пользователя в каждый его товар в корзине.
	$OrderNumber = md5($f_price . $f_project_id . strtotime("now"));
	$db->query("UPDATE Message234 SET OrderNumber = '$OrderNumber', checked_item = 0 WHERE User_ID = '$AUTH_USER_ID';");
	
}

buyProjectAuctions();
?>
			<div class='profile'>
				<h1 class='profile_title'><?php echo $nc_translate[18][$nc_l]; ?></h1>
				<?php echo profileMenu(); ?>
				<div class='clear'></div>
				<div class='profile-page'>
<?php 
/*
						<div class='activity shopping-cart'>
						<div class='header'>
							<table>
								<tr>
									<td class='project'><?php echo $nc_translate[24][$nc_l]; ?></td>
									<td class='purchased'><?php echo $nc_translate[25][$nc_l]; ?></td>
									<td class='rate'></td>
								</tr>
							</table>
						</div>
*/
?>
<!--
						<div class='display-table active-projects'>
							<table cellpadding='0' cellspacing='0'>
-->
	<div class="activity shopping-cart">

		<div class="header">
			<table>
				<tr>
					<td class="project"><?php echo $nc_translate[24][$nc_l]; ?></td>
					<td class="purchased"><?php echo $nc_translate[25][$nc_l]; ?></td>
					<!-- <td class="avaliable"><?php echo $nc_translate[135][$nc_l]; ?></td> -->
					<td class="rate">
						<div class='buy-btn'>
                            <form action="<? if(isset($_SESSION['cart'])) { echo '/profile/registration/'; } else { echo 'https://test.paysecure.ru/pay/order.cfm'; } ?>" method="post">
							<input type="hidden" name="Merchant_ID" value="<?php echo Merchant_ID; ?>" />
							<input type="hidden" name="OrderNumber" value="<?php echo $OrderNumber; ?>" />
							<input type="hidden" name="OrderAmount" value="" />
							<input type="hidden" name="OrderComment" value="<?php echo AssistText($OrderNumber); ?>" />
							<input type="hidden" name="AssistIDPayment" value="0" />
							<input type="hidden" name="OrderCurrency" value="USD" />
							<input type="hidden" name="Language" value="<?php echo ($current_catalogue['Domain'] == 'tos-invest.com' ? "EN" : "RU"); ?>" />
							<input type="hidden" name="URL_RETURN" value="http://<?php echo $current_catalogue['Domain']; ?>/profile/shopping-cart/" />
							<input type="hidden" name="URL_RETURN_OK" value="http://<?php echo $current_catalogue['Domain']; ?>/profile/shopping-cart/" />
							<input class="small-rbutton-2 <?php echo ($current_catalogue['Domain'] == 'ru.tos-invest.com' ? 'width-40' : ''); ?>" type="submit" name="submit" value="<?php echo $nc_translate[35][$nc_l]; ?>">
							</form>
						</div>
						<a class='small-rbutton-del' href='#' title=''></a>
					</td>
					<td class="available">
						<?php echo $nc_translate[135][$nc_l]; ?>
					</td>
				</tr>
			</table>
		</div>
	
	<div class="display-table active-projects">
		<table cellpadding="0" cellspacing="0">
<?php
	$query = $db->get_var("SELECT COUNT(*) FROM Message234 WHERE User_ID = $AUTH_USER_ID;");
	if(is_null($query)) {
		echo $nc_translate[121][$nc_l];
	}
	// Отображение для незарегистрированного пользователя
?>
<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
<?php foreach($_SESSION['cart'] as $item) { ?>
<?php $project = $db->get_row("SELECT Message_ID, name FROM Message192 WHERE Message_ID = $item[project] LIMIT 1;", ARRAY_A); ?>
	<tr class="first-row">
		<td class="project first-column">
			<a class="name" href="http://tos-invest.com/project/ready-bore-projects/#buy-item-<?php echo $project['Message_ID']; ?>" title="<?php echo $project['name']; ?>"><?php echo $project['name']; ?></a><br>
			<div class='clear'></div>
		</td>
		<td class='purchased'>
			<div class='quantity-wrapper'>
				<div class='quantity-field'>
					<input type='text' name='buy_quantity' readonly value='<?php echo $item['quantity']; ?>' />
					<input type="hidden" name="price" value="<?php echo $item['price']; ?>">
					<input type="hidden" name="project_id" value="<?php echo $item['project'] ?>">
					<input type="hidden" name="OrderNumber" value="<?php echo $item['OrderNumber'] ?>">
					<a class='increase' href='#+' title='<?php echo $nc_translate[119][$nc_l]; ?>'><?php echo $nc_translate[119][$nc_l]; ?></a>
					<a class='decrease' href='#-' title='<?php echo $nc_translate[120][$nc_l]; ?>'><?php echo $nc_translate[120][$nc_l]; ?></a>
				</div>
			</div>
			<div class='valute'>
				<button class="currency <?php echo getDefaultCurrency(); ?>"></button>
			</div>
			<div class='cost'>
				<p><?php echo $item['quantity']*$item['price']*getExchangeRateByCurrency(); ?></p>
			</div> 
			<div class='purchased-check'>
				<input type="checkbox" class='purchased-checkbox'>
			</div>
			<div class="clear"></div>
		</td>
		<td class="available">
			<?php echo getAvailableSharesCount($project['Message_ID']); ?>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php /* /Отображение для незарегистрированного пользователя */ ?>

<?php
	/*
	$query = $db->get_var("SELECT COUNT(*) FROM Message234 WHERE User_ID = $AUTH_USER_ID;");
	if(is_null($query)) {
		echo $nc_translate[121][$nc_l];
	}
	// Отображение для незарегистрированного пользователя
?>
<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>

					<div class='display-table active-projects'>
						<table cellpadding='0' cellspacing='0'>

<?php foreach($_SESSION['cart'] as $item) { ?>
<?php $project = $db->get_row("SELECT Message_ID, name FROM Message192 WHERE Message_ID = $item[project] LIMIT 1;", ARRAY_A); ?>
							<tr>
								<td class='project'>
									<a class='name' href='/project/ready-bore-projects/#buy-item-<?php echo $project['Message_ID']; ?>' title=''><?php echo $project['name']; ?></a><br/>
									<div class='clear'></div>
								</td>
								<td class='purchased'>
									<div class='quantity-wrapper'>
										<div class='quantity-field'>
											<input type='text' name='buy_quantity' value='<?php echo $item['quantity']; ?>' />
											<a class='increase' href='#+' title='<?php echo $nc_translate[119][$nc_l]; ?>'><?php echo $nc_translate[119][$nc_l]; ?></a>
											<a class='decrease' href='#-' title='<?php echo $nc_translate[120][$nc_l]; ?>'><?php echo $nc_translate[120][$nc_l]; ?></a>
										</div>
									</div>
								</td>
								<td class='rate'>
									<a class='small-rbutton-2' href='/profile/registration/' title=''><?php echo $nc_translate[35][$nc_l]; ?></a>
								</td>
							</tr>
<?php } ?>
						</table>
					</div>
					<div class='clear'></div>
					</div>
				</div>
			</div>
<?php } ?>
<?php */ ?>
<?php /* Отображение для незарегистрированного пользователя */ ?>
						<form id='cart_middle' method='post'>