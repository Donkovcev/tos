<?php
	global $nc_l, $nc_translate; // перевод
?>
  <style type="text/css">
    .error {border:1px solid red;}
  </style>
			<div class='profile'>
				<h1 class='profile_title'><?php echo $nc_translate[18][$nc_l]; ?></h1>
<?php if ($AUTH_USER_ID && $AUTH_USER_ID == 79) {
	// debug
	//echo sendEmailAttachment();
} ?>

				<?php echo profileMenu(); ?>

				<div class='clear'></div>
				<div class='profile-page'>

<?php
//temp
$item = array();
$projects = array(); // Массив со всей необходимой информацией по каждому проекту
$projectsId = array();
/* Пишем id проектов, в которых пользователь участвует */
$not_need = "";
$temp = $db->get_results("SELECT DISTINCT(Id) FROM Message220 WHERE User_ID = $AUTH_USER_ID", ARRAY_A);
if(is_array($temp) && count($temp) > 0) {
	foreach($temp as $data) {
		$projectsId[$data['Id']] = $data['Id'];
		$not_need .= $data['Id'] .",";
	}
}
$not_need = substr($not_need, 0, strlen($not_need) - 1);
/* /Пишем id проектов, в которых пользователь участвует */


$projectsTemp = $db->get_results("SELECT Message_ID, Count, Price, company_proposal FROM Message192 WHERE name IS NOT NULL AND LENGTH(name) > 0 AND Subdivision_ID = 110 AND Checked = 1;", ARRAY_A);

foreach($projectsTemp as $data) {
	$projects[$data['Message_ID']]['Id'] = $data['Message_ID'];
	$projects[$data['Message_ID']]['total'] = $data['Count'];
	$projects[$data['Message_ID']]['price'] = $data['Price'];
	$projects[$data['Message_ID']]['proposal'] = $data['company_proposal'];
	$projects[$data['Message_ID']]['auctions'] = getSellAuctions($data['Message_ID']);

	$item = $db->get_var("SELECT SUM(Quantity) as Quantity FROM Message220 WHERE Id = $data[Message_ID] AND ProjectType = 1 AND Checked = 1 LIMIT 1;");

	if(is_null($item))
		$projects[$data['Message_ID']]['buyed'] = 0;
	else
		$projects[$data['Message_ID']]['buyed'] = $item;

	$projects[$data['Message_ID']]['available'] = $projects[$data['Message_ID']]['total'] - $projects[$data['Message_ID']]['buyed'];

	$projects[$data['Message_ID']]['best_sell'] = $db->get_var("SELECT Price FROM Message220 WHERE ProjectType = 2 AND Id = $data[Message_ID] AND auction = 1 AND Checked = 1 ORDER BY Price ASC LIMIT 1;");
	if(is_null($projects[$data['Message_ID']]['best_sell']))
		$projects[$data['Message_ID']]['best_sell'] = "-";

	$projects[$data['Message_ID']]['best_buy'] = $db->get_var("SELECT Price FROM Message220 WHERE ProjectType = 1 AND Id = $data[Message_ID] AND Checked = 1 ORDER BY Price DESC LIMIT 1;");
	if(is_null($projects[$data['Message_ID']]['best_buy']))
		$projects[$data['Message_ID']]['best_buy'] = "-";

	if(isset($projectsId[$data['Message_ID']])) {
		$projects[$data['Message_ID']]['reports'] = Reports($data['Message_ID']);
	}
}

// немного музыки
if ($_SESSION['easteregg'] == 13) {
	$yeah = '<audio autoplay><source src="/images/eggs/music.ogg" type="audio/ogg; codecs=vorbis">
    <source src="images/eggs/music.mp3" type="audio/mpeg"></audio>';
	echo $yeah; $_SESSION['easteregg'] = 0;
}

?>
						<div class='activity'>
						<div class='header'>
							<table>
								<tr>
									<td class='project'><?php echo $nc_translate[24][$nc_l]; ?></td>
									<td class='purchased'><?php echo $nc_translate[25][$nc_l]; ?></td>
									<td class='rate'><?php echo $nc_translate[26][$nc_l]; ?> <span>(<?php echo $nc_translate[27][$nc_l]; ?>)</span></td>
									<td class='actions'><?php echo $nc_translate[28][$nc_l]; ?></td>
									<td class='revenue'><?php echo $nc_translate[29][$nc_l]; ?> <span>(USD)</span></td>
								</tr>
							</table>
						</div>
<?php

$active = $db->get_results("SELECT m220.Message_ID, m192.name, m192.Price, m220.Id, m220.Quantity, m220.PriceAll, m220.ProjectType, m220.User_ID FROM Message220 as m220 LEFT JOIN Message192 as m192 ON (m220.Id=m192.Message_ID) WHERE m220.User_ID=$AUTH_USER_ID AND m220.ProjectType = 1 AND m192.name IS NOT NULL AND m220.Quantity > 0 AND m220.Confirmation = 1 AND m220.Checked = 1;", ARRAY_A);
if(count($active) > 0) {

?>
						<div class='display-table active-projects'>
							<h3><?php echo $nc_translate[30][$nc_l]; ?></h3>
							<div class='clear'></div>
							<table cellpadding='0' cellspacing='0'>
<?php
	foreach($active as $data) {
		echo "
								<tr>
									<td class='project'>
										<a class='name' href='/project/projects-for-sale/?buy-item=$data[Id]' title=''>$data[name]</a><br/>
										{$projects[$data['Id']]['reports']}
										<div class='clear'></div>
									</td>
									<td class='purchased'>
										<div class='quantity-wrapper'>
											$data[Quantity]
										</div>
									</td>
									<td class='rate'>
										<div class='display-rate'>
											{$nc_translate[31][$nc_l]} {$projects[$data['Id']]['proposal']}<br/>
											<a class='activity-description' href='#' title='{$nc_translate[32][$nc_l]}'>{$nc_translate[34][$nc_l]}</a> {$projects[$data['Id']]['best_sell']}<br/>
											<a class='activity-description' href='#' title='{$nc_translate[33][$nc_l]}'>{$nc_translate[35][$nc_l]}</a> {$projects[$data['Id']]['best_buy']}<br/>
										</div>
									</td>
									<td class='actions'>
		";
		if(strlen($projects[$data['Id']]['auctions']) > 0) {
			echo "
										<a class='small-rbutton-2 buy-link' href='#' title=''>{$nc_translate[35][$nc_l]}</a>
			";
		}
		echo "
										<a class='small-rbutton-2 sell-link' href='#{$data['Id']}-{$data['Message_ID']}' title=''>{$nc_translate[34][$nc_l]}</a>
		";
		if(strlen($projects[$data['Id']]['auctions']) == 0) {
			echo getCompanyOfferLink($projects[$data['Id']]['available']);
		}

		echo $projects[$data['Id']]['auctions'];
		if(strlen($projects[$data['Id']]['auctions']) == 0) {
			echo getCompanyOfferForm($projects[$data['Id']]['Id'], $projects[$data['Id']]['available'], $projects[$data['Id']]['price']);
		}

		echo "
									</td>
									<td class='revenue'>

									</td>
								</tr>
		";
	}

?>
							</table>
						</div>
						<div class='clear'></div>
<?php
}
	$sold = $db->get_results("
		SELECT m220.Message_ID, m192.name, m192.Price, m220.Id, SUM(m220.Quantity) AS Quantity, m220.PriceAll, m220.ProjectType, m220.User_ID, SUM(m220.revenue) AS revenue
		FROM Message220 AS m220
		LEFT JOIN Message192 AS m192 ON (m220.Id = m192.Message_ID)
		WHERE m220.User_ID = $AUTH_USER_ID
		AND m220.ProjectType = 2
		AND m220.Confirmation = 1
		AND m220.auction = 0
		AND m220.Checked = 1
		GROUP BY m220.IdBuying;
	", ARRAY_A);

	if(count($sold) > 0) {
?>

						<div class='display-table sold-projects'>
							<h3><?php echo $nc_translate[36][$nc_l]; ?></h3>
							<div class='clear'></div>
							<table cellpadding='0' cellspacing='0'>
<?php
	foreach($sold as $data) {
		echo "
								<tr>
									<td class='project'>
										<a class='name' href='/project/projects-for-sale/?buy-item=$data[Id]' title=''>$data[name]</a><br/>
										{$projects[$data['Id']]['reports']}
										<div class='clear'></div>
									</td>
									<td class='purchased'>
										<div class='quantity-wrapper'>
											$data[Quantity]
										</div>
									</td>
									<td class='rate'>
										<div class='display-rate'>
											{$nc_translate[31][$nc_l]} {$projects[$data['Id']]['proposal']}<br/>
											<a class='activity-description' href='#' title='{$nc_translate[33][$nc_l]}'>{$nc_translate[35][$nc_l]}</a> {$projects[$data['Id']]['best_buy']}<br/>
										</div>
									</td>
									<td class='actions'>
		";
		if(strlen($projects[$data['Id']]['auctions']) > 0) {
			echo "
										<a class='small-rbutton-2 buy-link' href='#' title=''>{$nc_translate[35][$nc_l]}</a>
										<div class='clear'></div>
			";
		}
		if(strlen($projects[$data['Id']]['auctions']) == 0) {
			echo getCompanyOfferLink($projects[$data['Id']]['available']);
		}
		echo $projects[$data['Id']]['auctions'];
		if(strlen($projects[$data['Id']]['auctions']) == 0) {
			echo getCompanyOfferForm($projects[$data['Id']]['Id'], $projects[$data['Id']]['available'], $projects[$data['Id']]['price']);
		}
		echo "
									</td>
									<td class='revenue'>
										$data[revenue]
									</td>
								</tr>
		";
	}
?>
							</table>

						</div>
						<div class='clear'></div>
<?php
}
$query = "SELECT Message_ID as Id, name FROM Message192 WHERE ". (strlen($not_need) > 0 ? "Message_ID NOT IN (". $not_need .") AND " : "") ." Price IS NOT NULL AND Price > 0 AND name IS NOT NULL AND LENGTH(name) > 0 AND Subdivision_ID = 110 AND Checked = 1;";
$array = $db->get_results($query, ARRAY_A);

if(!is_null($array) && count($array) > 0) {
?>
						<!-- OTHER PROJECTS -->
						<div class='display-table other-projects'>
							<h3><?php echo $nc_translate[37][$nc_l]; ?></h3>
							<div class='clear'></div>
							<table cellpadding='0' cellspacing='0'>
<?php
unset($data);
foreach($array as $data) {
	echo "
								<tr>
									<td class='project'>
										<a class='name' href='/project/projects-for-sale/?buy-item=$data[Id]' title=''>$data[name]</a>
										<div class='clear'></div>
									</td>
									<td class='purchased'>
										<div class='quantity-wrapper'></div>
									</td>
									<td class='rate'>
										<div class='display-rate'>
											{$nc_translate[31][$nc_l]} {$projects[$data['Id']]['proposal']}<br/>
											<a class='activity-description' href='#' title='{$nc_translate[33][$nc_l]}'>{$nc_translate[35][$nc_l]}</a> {$projects[$data['Id']]['best_buy']}<br/>
										</div>
									</td>
									<td class='actions'>
		";
		if(strlen($projects[$data['Id']]['auctions']) > 0) {
			echo "
										<a style='margin-left:15px;' class='small-rbutton-2 buy-link' href='#' title=''>{$nc_translate[35][$nc_l]}</a>
										<div class='clear'></div>
			";
		}
		if(strlen($projects[$data['Id']]['auctions']) == 0) {
			echo getCompanyOfferLink($projects[$data['Id']]['available']);
		}
		echo $projects[$data['Id']]['auctions'];
		if(strlen($projects[$data['Id']]['auctions']) == 0) {
			echo getCompanyOfferForm($projects[$data['Id']]['Id'], $projects[$data['Id']]['available'], $projects[$data['Id']]['price']);
		}
		echo "
									</td>
									<td class='revenue'></td>
								</tr>
	";
}

?>
							</table>
						</div>
						<div class='clear'></div>
						<!-- /OTHER PROJECTS -->
<?php
}
?>
						<!-- SELL FROM -->
						<div class='sell-form'>
							<div id="sell-shares-dialog" style="display:none;"></div>
							<div class='top'></div>
							<div class='middle'>
								<div class='inner'>
									<form action='/ajax/' method='post'>
										<input type='hidden' name='auction_action' value='2' />
										<input type='hidden' name='parent' value='0' />
										<input type='hidden' name='project' value='0' />
										<input type='hidden' name='max_shares' value='0' />
										<table>
											<tr class='shares-quantity'>
												<td><?php echo $nc_translate[38][$nc_l]; ?></td>
												<td><input type='text' name='quantity' class='check-available-sell' maxlength='30' value='' /></td>
											</tr>
											<tr class='shares-price'>
												<td><?php echo $nc_translate[39][$nc_l]; ?><span>(<?php echo $nc_translate[27][$nc_l]; ?>)</span></td>
												<td><input type='text' name='price' maxlength='30' value=''></td>
											</tr>
											<tr>
												<td colspan='2'>
													<input id='sell-project-submit' class='real_submit' type='submit' name='submit' value='<?php echo $nc_translate[34][$nc_l]; ?>' />
													<a id='sell-project-link' class='small-rbutton-2 fright' href='#' title=''><?php echo $nc_translate[34][$nc_l]; ?></a>
												</td>
											</tr>
										</table>
									</form>
									<a class='icon popup-close' href='#' title=''><?php echo $nc_translate[40][$nc_l]; ?></a>
								</div>
							</div>
							<div class='bottom'></div>
						</div>
						<!-- /SELL FROM -->

					</div>

				</div>
				<div class='clear'></div>
			</div>

<?php

function getSellAuctions($project_id) {// Получаем все заявки на продажу от пользователей по проектам
	global $nc_l, $nc_translate; // перевод
	global $db, $AUTH_USER_ID;
	$temp = "";
	$result = array();
	$result = $db->get_results("
		SELECT m220.Message_ID, m220.Quantity, m220.Price, m220.PriceAll, User.ForumName
		FROM Message220 AS m220
		LEFT JOIN User ON ( m220.User_ID = User.User_ID )
		LEFT JOIN Message192 AS m192 ON ( m220.Id = m192.Message_ID )
		WHERE m192.name IS NOT NULL
		AND m220.Confirmation =1
		AND m220.Id = $project_id
		AND m220.auction = 1
		AND m220.User_ID != $AUTH_USER_ID
		AND m220.Checked = 1
	", ARRAY_A);

	$res = $db->get_results("
		SELECT quantity, selling_id
		FROM Message234
		WHERE project_id = $project_id
		AND User_ID = $AUTH_USER_ID
		AND Checked = 1
	", ARRAY_A);

	$cart = array();
	if(!empty($res))
	{
		foreach($res as $row)
		{
			$cart[$row['selling_id']] = $row['quantity'];
		}
		
	}

	if(!is_null($result)) {
		$temp = "
										<!-- BUY FORM -->
										<div class='buy-form'>
											<form class='form' name='adminForm' enctype='multipart/form-data' method='post' action='/ajax/'>
											<input name='catalogue' type='hidden' value='1'>
											<input name='cc' type='hidden' value='363'>
											<input name='sub' type='hidden' value='355'>
											<input name='posting' type='hidden' value='1'>
											<input name='curPos' type='hidden' value='0'>
											<input name='auction_action' type='hidden' value='9'>
											

											<div class='top'></div>
											<div class='middle'>
												<div class='inner'>
														<table cellpadding='0' cellspacing='0'>
															<tr>
																<td></td>
																<td>{$nc_translate[38][$nc_l]}</td>
																<td>{$nc_translate[39][$nc_l]} ({$nc_translate[27][$nc_l]})</td>
																<td>{$nc_translate[41][$nc_l]}</td>
																<td>{$nc_translate[42][$nc_l]}</td>
															</tr>
		";
		$i = 0;
		$form = "";
		foreach($result as $item) {
			$quantity = $item['Quantity'];
			if((isset($cart[$item['Message_ID']]) && $cart[$item['Message_ID']] >= $quantity))
			{
				continue;
			}
			else
			{
				$quantity = intval($item['Quantity'] - $cart[$item['Message_ID']]); 
			}
			if($quantity > 0)
			{
				$form .= "
																<tr>
																	<td><input type='checkbox' name='f_project_id[$i]' style='margin-left:13px;margin-top: 2px;' value='$project_id' /></td>
																	<input name='f_quantity[$i]' value='$quantity' type='hidden'>
																	<input name='f_selling_id[$i]' value='$item[Message_ID]' type='hidden'>
																	<td>$quantity</td>
																	<td>$item[Price]</td>
																	<td>$item[PriceAll]</td>
																	<td>$item[ForumName]</td>
																</tr>
				";
				$i++;
			}
		}
		$temp .= $form;
		$temp .= "
														</table>
														<input class='real_submit' type='submit' name='submit' value='{$nc_translate[35][$nc_l]}' />
														<a class='small-rbutton-2 buy-project-link' href='#' title=''>{$nc_translate[35][$nc_l]}</a>
													</form>
													<div class='clear'></div>
													<a class='icon popup-close' href='#' title=''>{$nc_translate[40][$nc_l]}</a>
												</div>
											</div>

											<div class='bottom'></div>
										</div>
										<!-- /BUY FORM -->
		";

		if(!empty($form))
		{
			$result = $temp;
		}
		else
		{
			$result = "";
		}

	} else {
		$result = "";
	}

	return $result;
}
function getCompanyOfferLink($available) {
	global $nc_l, $nc_translate; // перевод

	$result = "";
	if($available > 0) {
		$result = "
										<a style='margin-left:15px;' class='small-rbutton-2 buy-p-link' href='#' title=''>{$nc_translate[35][$nc_l]}</a>
										<div class='clear'></div>
		";
	}
	return $result;
}
function getCompanyOfferForm($project_id, $available, $price) {
	global $nc_l, $nc_translate; // перевод

	$result = "";
	if($available > 0) {

		$result = "
										<!-- /COMPANY OFFER -->
										<div class='company-offer'>
											<div class='top'></div>
											<div class='middle'>
												<div class='inner'>
													<form action='/netcat/add.php' method='post'>
														<input name='admin_mode' type='hidden' value='' />
														<input name='catalogue' type='hidden' value='1' />
														<input name='cc' type='hidden' value='363' />
														<input name='sub' type='hidden' value='355' />
														<input name='posting' type='hidden' value='1' />
														<input name='curPos' type='hidden' value='0' />
														<input name='f_Parent_Message_ID' type='hidden' value='' />
														<input name='f_project_id' type='hidden' value='$project_id' />

														<table>
															<tr class='shares-quantity'>
																<td>{$nc_translate[43][$nc_l]}</td>
																<td class='available-shares'>$available</td>
															</tr>
															<tr class='shares-quantity'>
																<td>{$nc_translate[44][$nc_l]}</td>
																<td>$price</td>
															</tr>
															<tr class='shares-price'>
																<td>{$nc_translate[45][$nc_l]}</td>
																<td><input type='text' name='f_quantity' maxlength='10' value='' class='check-available'></td>
															</tr>
															<tr>
																<td colspan='2'>
																	<input class='real_submit' type='submit' name='submit' value='{$nc_translate[35][$nc_l]}' />
																	<a class='small-rbutton-2 fright submit-link' href='#' title=''>{$nc_translate[35][$nc_l]}</a>
																</td>
															</tr>
														</table>
													</form>
													<a class='icon popup-close' href='#' title=''>{$nc_translate[40][$nc_l]}</a>
												</div>
											</div>
											<div class='bottom'></div>
										</div>
										<!-- /COMPANY OFFER -->
		";
	}
	return $result;
/*
 *
 * 										<!-- /COMPANY OFFER -->
										<div class='company-offer'>
											<div class='top'></div>
											<div class='middle'>
												<div class='inner'>
													<form action='/ajax/' method='post'>
														<input type='hidden' name='auction_action' value='1' />
														<input type='hidden' name='project' value='$project_id' />
														<table>
															<tr class='shares-quantity'>
																<td>{$nc_translate[43][$nc_l]}</td>
																<td>$available</td>
															</tr>
															<tr class='shares-quantity'>
																<td>{$nc_translate[44][$nc_l]}</td>
																<td>$price</td>
															</tr>
															<tr class='shares-price'>
																<td>{$nc_translate[45][$nc_l]}</td>
																<td><input type='text' name='quantity' maxlength='10' value='' ></td>
															</tr>
															<tr>
																<td colspan='2'>
																	<input class='real_submit' type='submit' name='submit' value='{$nc_translate[35][$nc_l]}' />
																	<a class='small-rbutton-2 fright submit-link' href='#' title=''>{$nc_translate[35][$nc_l]}</a>
																</td>
															</tr>
														</table>
													</form>
													<a class='icon popup-close' href='#' title=''>{$nc_translate[40][$nc_l]}</a>
												</div>
											</div>
											<div class='bottom'></div>
										</div>
										<!-- /COMPANY OFFER -->
 *
 */
}

?>