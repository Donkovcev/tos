<?php
// Random fact on main page via ajax

if (isset($random_fact)) {
	$random_fact = (int)$random_fact;
	if ($random_fact == 0) {
		echo "Error";
		exit();
	}

	$sql_fact = $db->get_var("SELECT facts FROM Message192 WHERE Message_ID = $random_fact LIMIT 1;");
	$sql_fact = explode("\n", $sql_fact);
	$sql_fact = $sql_fact[rand(0, count($sql_fact) - 1)];
	echo $sql_fact;
} else if (isset($captcha)) { // Captcha update for forum
	echo nc_captcha_formfield();
} else if (isset($_POST['subscribe'])) { // Subscribe in user profile
	$data = str_replace("\\", "", $_POST['subscribe']);
	$data = json_decode($data);

	$array = $db->get_var("SELECT subscribes FROM User WHERE User_ID = {$current_user['User_ID']} LIMIT 1");
	if (strlen($array) > 4) {
		$array = unserialize($array);
		if (is_array($array)) {
			if ($data->subscribe == 'off') {
				if (!isset($array[$data->project]))
					$array[$data->project] = $data->project;
			} else if ($data->subscribe == 'on') {
				if (isset($array[$data->project]))
					unset($array[$data->project]);
			}
			$array = serialize($array);
			$db->query("UPDATE User SET subscribes = '{$array}' WHERE User_ID = {$current_user['User_ID']}");
		} else {
			$array = serialize(array($data->project => $data->project));
			$db->query("UPDATE User SET subscribes = '{$array}' WHERE User_ID = {$current_user['User_ID']}");
		}
	} else {
		$array = serialize(array($data->project => $data->project));
		$db->query("UPDATE User SET subscribes = '{$array}' WHERE User_ID = {$current_user['User_ID']}");
	}
} else if (isset($auction_action)) {
	///} else if (isset($auction_action) && $AUTH_USER_ID) {
	/*
	  actions:
	  1 : buy project from company offer
	 */

	switch ($auction_action) {
		// покупка акций через projects for sale
		case 1:
			$project = (int)$project;
			$quantity = (int)$quantity;
			$cart = (int)$cart;

			if (!($project > 0 && $quantity > 0 && $cart > 0)) {
				activityRedirect();
			}

			$query = $db->get_var("SELECT Message_ID FROM Message234 WHERE Message_ID = $cart
				AND User_ID = $AUTH_USER_ID LIMIT 1");
			if (is_null($query)) activityRedirect();

			// Выбрать из базы цену
			$project_values = $db->get_results("SELECT Count, Price FROM Message192
				WHERE Message_ID = $project LIMIT 1;", ARRAY_A);
			if (is_null($project_values)) activityRedirect();
			$price = $project_values[0]['Price'];

			/* Проверяем сколько акций доступно для покупки */
			$shares_quantity = $project_values[0]['Count'];
			// Выбрать из базы цену
			$buyed_shares = $db->get_results("SELECT SUM(Quantity) as Quantity FROM Message220 WHERE Id = $project
				AND ProjectType = 1 LIMIT 1;", ARRAY_A);
			if (is_null($buyed_shares)) activityRedirect();
			$buyed_shares = $buyed_shares[0]['Quantity'];
			$avaible_shares = $shares_quantity - $buyed_shares;

			if ($avaible_shares < $quantity) {
				activityRedirect();
			}
			/* /Проверяем сколько акций доступно для покупки */


			$priceAll = $quantity * $price;

			$settings = array(
				'User_ID' => $AUTH_USER_ID,
				'Subdivision_ID' => 175,
				'Sub_Class_ID' => 233,
				'IP' => $_SERVER["REMOTE_ADDR"],
				'Confirmation' => 1,
				'Id' => $project,
				'Quantity' => $quantity,
				'Price' => $price,
				'ProjectType' => 1, // Покупка или продажа (1 или 2)
				'PriceAll' => $priceAll,
				'auction' => 0
			);


			$query = "INSERT INTO `Message220` (`Message_ID`, `User_ID`, `Subdivision_ID`, `Sub_Class_ID`,
				`Priority`, `Keyword`, `ncTitle`, `ncKeywords`, `ncDescription`, `Checked`, `TimeToDelete`,
				`TimeToUncheck`, `IP`, `UserAgent`, `Parent_Message_ID`, `Created`, `LastUpdated`, `LastUser_ID`,
				`LastIP`, `LastUserAgent`, `Confirmation`, `Id`, `Quantity`, `Price`, `ProjectType`, `PriceAll`,
				`IdBuying`, `auction`, `revenue`";

			$last_date_ownership = $db->get_var("SELECT last_date_ownership FROM Message220
				WHERE User_ID = $settings[User_ID] AND Id = $settings[Id] ORDER BY last_date_ownership DESC LIMIT 1;");
			if (!is_null($last_date_ownership)) {
				$query .= ", `last_date_ownership`";
			}

			$query .= ") VALUES (NULL, $settings[User_ID], $settings[Subdivision_ID], $settings[Sub_Class_ID], 1,
				'', NULL, NULL, NULL, 1, NULL, NULL, '$settings[IP]', '', 0, NOW(), NOW(), 0, NULL, NULL,
				 $settings[Confirmation], $settings[Id], $settings[Quantity], $settings[Price], $settings[ProjectType],
				 $settings[PriceAll], NULL, $settings[auction], 0";

			if (!is_null($last_date_ownership)) {
				$query .= ", '$last_date_ownership'";
			}

			$query .= ");";
			$db->query($query);
			
			$msgID = $db->insert_id;

			/* Delete from cart */
			global $AUTH_USER_ID;
			$db->query("DELETE FROM Message234 WHERE User_ID = $AUTH_USER_ID AND project_id = $project
				AND Message_ID = $cart LIMIT 1;");
			// удалить товар из корзины неавторизованного пользователя
			/* /Delete from cart */

			
			//$nc_core->event->execute("addMessage", 1, $settings['Subdivision_ID'], $settings['Sub_Class_ID'], 220, $msgID);
			

			if (strpos($_SERVER["HTTP_REFERER"], "ready-bore-projects") === false) {
				activityRedirect();
			} else {
				activityRedirect("/project/ready-bore-projects/");
			}
			break;
		// продажа акций пользователем из профиля
		case 2:
			$project = (int)$project;
			$quantity = (int)$quantity;
			$price = (int)$price;
			$parent = (int)$parent;

			if (!(is_integer($project) && $project > 0 && is_integer($quantity) && $quantity > 0
				&& is_integer($price) && $price > 0 && is_integer($parent) && $parent > 0)) {
				activityRedirect();
			}
			$priceAll = $quantity * $price;

			/* Проверяем сколько акций доступно для покупки */
			$owned_shares = $db->get_var("SELECT Quantity FROM Message220 WHERE User_ID = $AUTH_USER_ID
				AND Id = $project AND ProjectType = 1 AND Message_ID = $parent LIMIT 1;");
			$transaction_shares = $db->get_var("SELECT SUM(Quantity) as Quantity FROM Message220
				WHERE User_ID = $AUTH_USER_ID AND IdBuying = $parent AND auction = 1 AND ProjectType = 2 LIMIT 1;");

			$avaible_shares = $owned_shares - $transaction_shares;

			if ($avaible_shares < $quantity) {
				activityRedirect();
			}
			/* /Проверяем сколько акций доступно для покупки */

			$old_price = $db->get_var("SELECT Price FROM Message220 WHERE ProjectType = 1
				AND Message_ID = $parent LIMIT 1");
			$old_total = $old_price * $quantity;
			$revenue = $priceAll - $old_total;

			$settings = array(
				'User_ID' => $AUTH_USER_ID,
				'Subdivision_ID' => 175,
				'Sub_Class_ID' => 233,
				'IP' => $_SERVER["REMOTE_ADDR"],
				'Confirmation' => 1,
				'Id' => $project,
				'Quantity' => $quantity,
				'Price' => $price,
				'ProjectType' => 2, // Покупка или продажа (1 или 2)
				'PriceAll' => $priceAll,
				'IdBuying' => $parent,
				'auction' => 1,
				'revenue' => $revenue
			);


			// Кузя, сюда
			// отправка email пользователю и админу
            $userName = $db->get_var("SELECT ForumName FROM User WHERE User_ID=".$AUTH_USER_ID);
            $userEmail = $db->get_var("SELECT Email FROM User WHERE User_ID=".$AUTH_USER_ID);
            $projectName = $db->get_var("SELECT name FROM Message192 WHERE Message_ID=".$project);
            $spamFromEmail = $db->get_var("SELECT `Value` FROM `Settings` WHERE `Key`='SpamFromEmail'");

            $mailer = new CMIMEMail();
            $mailer->mailbody("",'Вам отправлен запрос на проверку стоимости акции по проекту <a href="http://'.$current_catalogue['Domain'].'/project/projects-for-sale/?buy-item='.$project.'">'.$projectName.'</a>
              пользователем '.$userName.'. Пожалуйста, подтвердите его запрос');
            //$mailer->send($spamFromEmail, $userEmail, $userEmail,'Запрос отправлен на обработку','tos-invest');
            $mailer->send($spamFromEmail,'','','Новый запрос на продажу','tos-invest');

			$query = "INSERT INTO `Message220` (`Message_ID`, `User_ID`, `Subdivision_ID`, `Sub_Class_ID`,
				`Priority`, `Keyword`, `ncTitle`, `ncKeywords`, `ncDescription`, `Checked`, `TimeToDelete`,
				`TimeToUncheck`, `IP`, `UserAgent`, `Parent_Message_ID`, `Created`, `LastUpdated`, `LastUser_ID`,
				`LastIP`, `LastUserAgent`, `Confirmation`, `Id`, `Quantity`, `Price`, `ProjectType`, `PriceAll`,
				`IdBuying`, `auction`, `revenue`) VALUES (NULL, $settings[User_ID], $settings[Subdivision_ID],
				$settings[Sub_Class_ID], 1, '', NULL, NULL, NULL, 0, NULL, NULL, '$settings[IP]', '', 0, NOW(),
				NOW(), 0, NULL, NULL, $settings[Confirmation], $settings[Id], $settings[Quantity], $settings[Price],
				$settings[ProjectType], $settings[PriceAll], $settings[IdBuying], $settings[auction],
				$settings[revenue]);";
				
				//echo $query;
				//exit();

			$db->query($query);
			activityRedirect();
			break;
		// покупка акций, которые продает пользователь 
		// not working code: it's just double code !!!!!!!
		case 3:
			$project = (int)$project;
			if (!(is_integer($project) && $project > 0)) {
				activityRedirect();
			}

			foreach ($_POST['buy'] as $transaction_id) {
				$transaction_id = (int)$transaction_id;
				if (!(is_integer($transaction_id) && $transaction_id > 0)) {
					activityRedirect();
				}

				$query = "SELECT * FROM Message220 WHERE Message_ID = $transaction_id AND ProjectType = 2
				AND auction = 1 AND Id = $project AND User_ID != $AUTH_USER_ID LIMIT 1;";
				$buyer = $db->get_row($query, ARRAY_A);

				auctionCheckQueryResult($buyer);

				$query = "SELECT * FROM Message220 WHERE Message_ID = $buyer[IdBuying] AND ProjectType = 1 LIMIT 1;";
				$owner = $db->get_row($query, ARRAY_A);

				auctionCheckQueryResult($owner);

				$owner['Quantity_old'] = $owner['Quantity'];
				$owner['Quantity'] = $owner['Quantity'] - $buyer['Quantity'];

				$revenue = $buyer['revenue'];
				$owner['PriceAll'] = $buyer['Price'] * $owner['Quantity_old'];

				if ($owner['Quantity'] == 0) {
					$query = "UPDATE Message220 SET LastUpdated = NOW(), Price = $buyer[Price],
					PriceAll = $owner[PriceAll], ProjectType = 2, auction = 0, revenue = $revenue
					WHERE Message_ID = $owner[Message_ID] LIMIT 1;";
					$db->query($query);
				} else {
					$owner['PriceAll'] = $owner['Price'] * $owner['Quantity'];
					$query = "UPDATE Message220 SET LastUpdated = NOW(), Quantity = $owner[Quantity],
					PriceAll = $owner[PriceAll] WHERE Message_ID = $owner[Message_ID] LIMIT 1;";
					$db->query($query);
					$query = "UPDATE Message220 SET LastUpdated = NOW(), auction = 0
					WHERE Message_ID = $transaction_id AND ProjectType = 2 AND auction = 1 AND Id = $project
					AND User_ID != $AUTH_USER_ID;";
					$db->query($query);
				}


				$settings = array(
					'User_ID' => $AUTH_USER_ID,
					'Subdivision_ID' => 175,
					'Sub_Class_ID' => 233,
					'IP' => $_SERVER["REMOTE_ADDR"],
					'Confirmation' => 1,
					'Id' => $project,
					'Quantity' => $buyer['Quantity'],
					'Price' => $buyer['Price'],
					'ProjectType' => 1,
					'PriceAll' => ($buyer['Quantity'] * $buyer['Price']),
					'IdBuying' => 0,
					'auction' => 0,
					'revenue' => 0
				);


				$query = "INSERT INTO `Message220` (`Message_ID`, `User_ID`, `Subdivision_ID`, `Sub_Class_ID`,
					`Priority`, `Keyword`, `ncTitle`, `ncKeywords`, `ncDescription`, `Checked`, `TimeToDelete`,
					`TimeToUncheck`, `IP`, `UserAgent`, `Parent_Message_ID`, `Created`, `LastUpdated`, `LastUser_ID`,
					`LastIP`, `LastUserAgent`, `Confirmation`, `Id`, `Quantity`, `Price`, `ProjectType`, `PriceAll`,
					`IdBuying`, `auction`, `revenue`) VALUES (NULL, $settings[User_ID], $settings[Subdivision_ID],
					$settings[Sub_Class_ID], 1, '', NULL, NULL, NULL, 1, NULL, NULL, '$settings[IP]', '', 0, NOW(),
					NOW(), 0, NULL, NULL, $settings[Confirmation], $settings[Id], $settings[Quantity], $settings[Price],
					$settings[ProjectType], $settings[PriceAll], $settings[IdBuying], $settings[auction],
					$settings[revenue]);";
				$db->query($query);

				$buyer = null;
				$owner = null;
			}

			activityRedirect();
			break;
		case 4:
			echo updateCartQuantity($mw_quantity, $mw_cart_id);
			break;
		case 5:
			$mw_cart_id = (int)$mw_cart_id;
			$mw_order = (int)$mw_order;
			$db->query("UPDATE Message234 SET checked_item = $mw_order WHERE User_ID = $AUTH_USER_ID
				AND Message_ID = $mw_cart_id;");
			exit();
			break;
		// удаление товара из сессии у неавторзованного пользователя
		case 6:
			//if (!isset($AUTH_USER_ID) OR $AUTH_USER_ID === 0 AND isset($mw_project_id) AND $mw_project_id !== 0) {
			if (!isset($AUTH_USER_ID) OR $AUTH_USER_ID === 0) {
				foreach ($_SESSION['cart'] as $key => $cart) {
					if ($_SESSION['cart'][$key]['project'] == $mw_project_id) {
						//unset($_SESSION['cart'][$key]);
						unset($_SESSION['cart'][$key]);
						//session_write_close();
					}
				}
			}
			// и из БД у авторизованного
			$db->query("DELETE FROM Message234 WHERE User_ID = $AUTH_USER_ID AND Message_ID = $mw_cart_id
				AND project_id = $mw_project_id;");
			break;
		// обновление количества товаров в базе при изменении кол-ва выделенных товаров в корзине
		case 7:
			$mw_project_id = (int)$mw_project_id;
			$mw_quantity = (int)$mw_quantity;
			$db->query("UPDATE Message234 SET `quantity` = $mw_quantity WHERE `OrderNumber` = $mw_order
				AND `project_id` = $mw_project_id;");
			//echo $mw_project_id, '   ', $mw_quantity, '   ', $mw_order;
			exit();
			break;
		// покупка акций, которые продает пользователь со складыванием их в корзину
		case 8: 
			$mw_project_id = (int)$mw_project_id;
			$mw_quantity = (int)$mw_quantity;
			$db->query("UPDATE Message234 SET `quantity` = $mw_quantity WHERE `OrderNumber` = $mw_order
				AND `project_id` = $mw_project_id;");
			//echo $mw_project_id, '   ', $mw_quantity, '   ', $mw_order;
			exit();
			break;
		
		//покупка акций одного проекта сразу у нескольких пользователей из раздела my activity - other projects
		case 9: 
			if(is_array($f_project_id) && !empty($f_project_id) && $AUTH_USER_ID)
			{
				foreach($f_project_id as $key => $id)
				{
					file_get_contents('http://'.$current_catalogue['Domain'] .'/netcat/add.php?catalogue='.$_POST['catalogue'].'&cc='.$_POST['cc'].'&sub='.$_POST['sub'].'&curPos='.$_POST['curPos'].'&posting=1&f_project_id='.$f_project_id[$key].'&f_quantity='.$f_quantity[$key].'&f_selling_id='.$f_selling_id[$key].'&user_id='.$AUTH_USER_ID.'&hash=58ca817f854ae9197c483fe7c6990897');
				}
			}
			shoppingCartRedirect();
			break;

		case 12:
			echo sendEmailAttachment($filepath, $file);
			exit();
			break;
			
		
		default:
			break;
	}
}

// проверка на наличие зарегистированного пользователя с таким же Login
if (isset($_POST['validation']) && $_POST['validation'] == 'reg' && isset($_POST['f_Login'])) {
	$registrant = $_POST['f_Login'];
	$res = $db->get_var("SELECT User_ID FROM User WHERE Login = '" . $registrant . "'");
	if ($res) {
		// пользователь есть
		die('false');
	} else {
		die('true');
	}
}
// запрос курса доллара из корзины
if (isset($_POST['request']) && $_POST['request'] == 'getCurrencyRate') {
	echo getExchangeRate();
}

/*function activityRedirect($link = "/profile/activity/")
{
	header("Location: $link");
	exit();
}*/

function shoppingCartRedirect($link = "/profile/shopping-cart/")
{
	header("Location: $link");
	exit();
}

function auctionCheckQueryResult($query)
{
	if (!(is_array($query) && count($query) > 0)) {
		activityRedirect();
	}
}

function addSharesToCart()
{

}
?>