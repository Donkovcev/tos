<?php
/**
 *
 * @param string $file
 * @return string
 */
function template_dir($file = "") {
	return TEMPROOT . $file;
}

/**
 *
 * @param string $file
 * @return string
 */
function base_dir($file = "") {
	return ROOT . "/images/texasonshore/" . $file;
}

/**
 *
 * @return string
 */
function template_url() {
	return "http://" . $_SERVER['HTTP_HOST'] . "/images/texasonshore/";
}

/**
 * Яваскрипт для фронтэнда
 * @return string
 */
function jsInit() {
	$result = "
		<script type='text/javascript' src='/images/texasonshore/js/jquery-1.7.1.min.js'></script>
		<script type='text/javascript' src='/images/texasonshore/js/jquery.lightbox-0.5.pack.js'></script>
		<script type='text/javascript' src='/images/texasonshore/js/jquery.form.js'></script>
		<script type='text/javascript' src='/images/texasonshore/js/jquery-ui.min.js'></script>
		<script type='text/javascript' src='/images/texasonshore/js/jquery.validate.js'></script>
		<script type='text/javascript' src='/images/texasonshore/js/additional-methods.js'></script>
		<script type='text/javascript' src='/images/texasonshore/js/jquery.settings.js?q=15'></script>
		<script type='text/javascript' src='/images/texasonshore/js/jquery.uniform.min.js'></script>
	";
	$result .= jsProfileValidate();
	$result .= jsRegistrationValidate();
	$result .= jsTopicValidate();
	$result .= jsAnswerValidate();
	$result .= jsInputUniform();
	return $result;
}

/**
 *
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @return string
 */
function jsProfileValidate() {
	global $nc_l, $nc_translate;
	ob_start();
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#profile-form").validate({
				wrapper: "div",
				errorClass: "error",
				rules: {
					f_Login: {
						required: true,
						minlength: 4
					},
					f_password: {
						required: true,
						minlength: 4
					},
					f_password1: {
						required: true,
						minlength: 4, 
						equalTo: "#password"
					},
					f_ForumName: {
						required: true,
						minlength: 4
					},
					f_Email: {
						required: true,
						email: true
					}
				},
				messages: {
					f_Login: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>"
					},
					f_password: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>"
					},
					f_password1: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>",
						equalTo: "<?php echo $nc_translate[131][$nc_l]; ?>"
					},
					f_ForumName: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>"
					},
					f_Email: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						email: "<?php echo $nc_translate[129][$nc_l]; ?>"
					}
				}
			});
		});
	</script>
	<?php
	$script = ob_get_contents();
	ob_end_clean();

	return $script;
}

/**
 *
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @return string
 */
function jsRegistrationValidate() {
	global $nc_l, $nc_translate;
	ob_start();
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#registration-form").validate({
				wrapper: "div",
				errorClass: "error",
				rules: {
					f_Login: {
						required: true,
						minlength: 4,
						remote: {
							url: "/ajax/",
							type: "post",
							data: {
								validation: 'reg'
							}
						}
					},
					Password1: {
						required: true,
						minlength: 4
					},
					Password2: {
						required: true,
						minlength: 4, 
						equalTo: "#password"
					},
					f_ForumName: {
						required: true,
						minlength: 4,
					},
					f_Email: {
						required: true,
						email: true
					}
				},
				messages: {
					f_Login: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>",
						remote: "<?php echo $nc_translate[142][$nc_l]; ?>"
					},
					Password1: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>"
					},
					Password2: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>",
						equalTo: "<?php echo $nc_translate[131][$nc_l]; ?>"
					},
					f_ForumName: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>",
					},
					f_Email: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						email: "<?php echo $nc_translate[129][$nc_l]; ?>"
					}
				}
			});
		});
	</script>
	<?php
	$script = ob_get_contents();
	ob_end_clean();

	return $script;
}

/**
 *
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @return string
 */
function jsTopicValidate() {
	global $nc_l, $nc_translate;
	ob_start();
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#question-form form").validate({
				wrapper: "div",
				errorClass: "error",
				rules: {
					f_name: {
						required: true,
						minlength: 4
					},
					f_Subject: {
						required: true
					},
					f_Message: {
						required: true
					}
				},
				messages: {
					f_name: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>",
						minlength: "<?php echo $nc_translate[127][$nc_l]; ?>"
					},
					f_Subject: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>"
					},
					f_Message: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>"
					}
				}
			});
		});
	</script>
	<?php
	$script = ob_get_contents();
	ob_end_clean();
	return $script;
}

/**
 *
 * @global string $nc_l
 * @global array $nc_translate
 * @return type
 */
function jsAnswerValidate() {
	global $nc_l, $nc_translate;
	ob_start();
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#answer-form form").validate({
				wrapper: "div",
				errorClass: "error",
				rules: {
					f_Subject: {
						required: true,
						minlength: 4
					},
					f_Message: {
						required: true,
						minlength: 4
					},
					nc_captcha_code: {
						required: true,
						minlength: 5
					}
				},
				messages: {
					f_Subject: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>"
					},
					f_Message: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>"
					},
					nc_captcha_code: {
						required: "<?php echo $nc_translate[126][$nc_l]; ?>"
					}
				}
			});
		});
	</script>
	<?php
	$script = ob_get_contents();
	ob_end_clean();
	return $script;
}

/**
 *
 * @global string $nc_l
 * @global array $nc_translate
 * @return type
 */
function jsInputUniform() {
	global $nc_l, $nc_translate;
	ob_start();
	?>
	<script type="text/javascript">
		$(function(){ $(".purchased-checkbox").uniform(); });
	</script>
	<?php
	$script = ob_get_contents();
	ob_end_clean();
	return $script;
}

/**
 * Возвращает код кнопки для смены языка
 * @global string $nc_l Язык: ru или en
 * @return string
 */
function languageButton() {
	global $nc_l;
	$result = "";
	if(strpos($_SERVER['REQUEST_URI'], 'bad-browser') == false) {
		$result .= "
			<noscript>
				<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=/bad-browser/'>
			</noscript>	
		";	
	}

	if ($nc_l == 'en') {
		$result .= "
			  <ul id='lang' class='eng'>
				<li><a href='http://ru.tos-invest.com/'><span>Rus</span></a></li>
			  </ul>
		";
	} else {
		$result .= "
			  <ul id='lang' class='rus'>
				<li><a href='http://tos-invest.com/'><span>Eng</span></a></li>
			  </ul>
		";
	}
	return $result;
}

/**
 * Информация о файле
 * @param string $file
 * @param string $info
 * @return string
 */
function FileInfo($file, $info) {
	$file = explode(":", $file);
	return $file[$info];
}

/**
 * Личный кабинет пользователя, отчеты
 * @global nc_Db $db подключение базы данных
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @param int $id
 * @return string
 */
function Reports($id) {
	global $db, $nc_l, $nc_translate; // перевод
	$Reports = "";
	$quarter = array();
	$temp = "";
	$count = 1;
	// посмотрим есть ли отчеты
	if ($db->get_var("SELECT COUNT(*) as n FROM Message192 WHERE Checked=1 AND Parent_Message_ID=$id AND IsReports=1") > 0) {
		// наполним массив месяцами
		$res = $db->get_results("SELECT Message_ID, Reports as ReportsLink, ReportsQuarter FROM Message192 WHERE Checked = 1 AND Parent_Message_ID = $id AND IsReports= 1 ORDER BY ReportsQuarter ASC;", ARRAY_A);
		foreach ($res as $report) {
			$quarter[$report['ReportsQuarter']][] = $report['ReportsLink'];
			$quarter['link'][$report['ReportsLink']] = $report['Message_ID'];
		}

		$first = "";
		$second = "";
		$third = "";
		$fouth = "";

		if (array_key_exists('1', $quarter)) {
			$first = "active";
		} elseif (array_key_exists('2', $quarter)) {
			$second = "active";
		} elseif (array_key_exists('3', $quarter)) {
			$third = "active";
		} elseif (array_key_exists('4', $quarter)) {
			$fouth = "active";
		}

		$Reports .= "
										<a class='reports' href='#' title=''>{$nc_translate[86][$nc_l]}</a>
										<!-- POPUP -->
										<div class='popup-statistics'>
											<div class='top'></div>
											<div class='middle'>
												<div class='inner'>
													<ul class='navigation'>
														<li class='label'>{$nc_translate[87][$nc_l]}</li>
														<li class='" . (array_key_exists('1', $quarter) ? "$first" : "inactive") . "'><a href='#first' title=''>{$nc_translate[88][$nc_l]}</a></li>
														<li class='" . (array_key_exists('2', $quarter) ? "$second" : "inactive") . "'><a href='#second' title=''>{$nc_translate[89][$nc_l]}</a></li>
														<li class='" . (array_key_exists('3', $quarter) ? "$third" : "inactive") . "'><a href='#third' title=''>{$nc_translate[90][$nc_l]}</a></li>
														<li class='" . (array_key_exists('4', $quarter) ? "$fouth" : "inactive") . "'><a href='#fouth' title=''>{$nc_translate[91][$nc_l]}</a></li>
													</ul>


		";
		
		foreach ($quarter as $i => $v) {
			switch ($i) {
				case '1':
					$temp = "first";
					break;
				case '2':
					$temp = "second";
					break;
				case '3':
					$temp = "third";
					break;
				case '4':
					$temp = "fourth";
					break;
			}
			$Reports .= "
													<div class='tab $temp " . ($count == 1 ? "selected-tab" : "") . "'>
														<table class='files'>
";

			foreach ($v as $item) {
				$Reports .= "
															<tr>
																<td>" . FileInfo($item, 0) . " (" . nc_bytes2size(FileInfo($item, 2)) . ")</td>
																<td>
																<a class='icon print' target='_blank' href='/project/projects-for-sale/ready-bore-projects_". $quarter['link'][$item] .".html?template=91' title=''>{$nc_translate[92][$nc_l]}</a>
																	<!--<a class='icon print' href='/netcat_files/" . FileInfo($item, 3) . "' title='' target='_blank'>{$nc_translate[93][$nc_l]}</a>-->
																</td>
																<td><a class='icon save' href='/netcat_files/" . FileInfo($item, 3) . "' title='' target='_blank'>{$nc_translate[93][$nc_l]}</a></td>
																<td><a class='icon email' href='#' title=''>email</a></td>
															</tr>
";
			}

			$Reports .= "
														</table>
													</div>
";
			$count++;
		}
		$Reports .= "
													<a class='icon popup-close' href='#' title=''>{$nc_translate[40][$nc_l]}</a>
												</div>
											</div>
											<div class='bottom'></div>
										</div>
										<!-- /POPUP -->
										<div class='clear'></div>
";
	}
	return $Reports;
}

/**
 * Личный кабинет пользователя, количество доступных-купленных процентов
 * @global nc_Db $db подключение базы данных
 * @param int $id
 * @param int $userid
 * @return int
 */
function CountPercent($id, $userid) {
	global $db;
	// проценты +
	$PercentPlus = $db->get_var("SELECT Quantity FROM `Message220` WHERE `User_ID`='$userid' AND `Message_ID`='$id' AND `ProjectType`='1'");
	// проценты -
	$PercentMinys = $db->get_var("SELECT sum(Quantity) FROM Message220 WHERE User_ID=$userid AND IdBuying=$id AND ProjectType=2");
	// Сколько доступно
	return $PercentPlus - $PercentMinys;
}

/**
 *
 * @global nc_Db $db подключение базы данных
 * @param int $id
 * @param int $userid
 * @return int
 */
function CountRevenue($id, $userid) {
	global $db;
	// Сколько заработали (продавая)
	$RevenuePlus = $db->get_var("SELECT sum(PriceAll) FROM `Message220` WHERE `User_ID`='$userid' AND `IdBuying`='$id' AND `ProjectType`='2'");
	// Сколько потратили (покупая)
	$RevenueMinys = $db->get_var("SELECT PriceAll FROM `Message220` WHERE `User_ID`='$userid' AND `Message_ID`='$id' AND `ProjectType`='1'");
	return $RevenuePlus - $RevenueMinys;
}

/**
 * Проверяет, авторизован ли пользователь или нет
 * @global int $AUTH_USER_ID id пользователя
 * @return boolean
 */
function checkAuth() {
	global $AUTH_USER_ID;
	if (isset($AUTH_USER_ID) && $AUTH_USER_ID > 0)
		return true;
	else
		return false;
}

/**
 * Возвращает меню для пользовательского профиля
 * @global int $AUTH_USER_ID id пользователя
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @global int $classID id компонента
 * @return string
 */
function profileMenu() {
	global $AUTH_USER_ID, $nc_l, $nc_translate, $classID;
	$result = "";
	$result .= "
		<ul class='profile_menu'>
	";
	if (checkAuth()) {
		$result .= "<li class='item-0 " . ($classID == 221 ? "active" : "") . "'><a href='/profile/activity/' title=''>{$nc_translate[15][$nc_l]}</a></li>\r\n";
	}
	$result .= "<li class='item-1  " . ($classID == 234 ? "active" : "") . " " . (!checkAuth() ? "item-0" : "") . "'><a href='/profile/shopping-cart/' title=''>{$nc_translate[118][$nc_l]}</a></li>\r\n";
	if (checkAuth()) {
		$result .= "
				<li class='item-2 " . ($classID == 94 ? "active" : "") . "'><a href='/profile/mysubscribers/' title=''>{$nc_translate[16][$nc_l]}</a></li>
				<li class='item-3 " . ($classID == 26 ? "active" : "") . "'><a href='/profile/profile_$AUTH_USER_ID.html' title=''>{$nc_translate[17][$nc_l]}</a></li>
		";
	}
	$result .= "
		</ul>
	";
	
	
	return $result;
}

/**
 * Формирует код корзины, которая отображается в шапке на сайте
 * @global nc_Db $db подключение базы данных
 * @global int $AUTH_USER_ID id пользователя
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @return string
 */
function showCart() {
	global $db, $AUTH_USER_ID, $nc_l, $nc_translate;
	$cart_result = array();
	$result = "
		<div class='cart-wrapper'>
	";
	if (checkAuth()) {
		$cart = $db->get_results("SELECT m234.project_id, m234.quantity, m192.name FROM Message234 as m234 LEFT JOIN Message192 as m192 ON (m192.Message_ID = m234.project_id) WHERE m234.User_ID = $AUTH_USER_ID ORDER BY m234.Created ASC", ARRAY_A);
		if (!is_null($cart) && count($cart) > 0) {
			foreach ($cart as $item) {
				$cart_result[] = array('name' => $item['name'], 'quantity' => $item['quantity'], 'project' => $item['project_id']);
			}
		}
	} else if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
		foreach ($_SESSION['cart'] as $item) {
			$p = $db->get_var("SELECT name FROM Message192 WHERE Message_ID = $item[project]");
			$cart_result[] = array('name' => $p, 'quantity' => $item['quantity'], 'project' => $item['project']);
		}
	}
	$cart_quantity = count($cart_result);
	$result .= "
		<div class='cart " . ($cart_quantity > 0 ? "full" : "blank") . "'>
			<a href='/profile/shopping-cart/' title=''><div class='meta'>
				{$nc_translate[124][$nc_l]}
				" . ($cart_quantity > 0 ? "<span>(" . $cart_quantity . ")</span>" : "") . "
			</div></a>
			<div class='cart-block loged'>
				<div class='block-body'>
					<table>
	";
	if ($cart_quantity > 0) {
		foreach ($cart_result as $item) {
			$result .= "
							<tr>
								<td><a href='" . PROJECTS_PAGE . "?item={$item['project']}' title=''>{$item['name']}</a></td>
								<td>{$item['quantity']}</td>
							</tr>
			";
		}
	}
	$result .= "
					</table>
				</div>
			</div>
		</div>
	";
	$result .= "
		<div class='clear'></div>
		</div>
	";
	return $result;
}

/**
 * Проверка, есть ли в сессии покупки в корзине, если есть, то добавление их в базу и очистка сессии
 * @global nc_Db $db подключение базы данных
 * @global int $AUTH_USER_ID id пользователя
 */
function checkCart() {
	global $db, $AUTH_USER_ID;
	if (checkAuth() && isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
		foreach ($_SESSION['cart'] as $item) {

			
			// Проверяем есть ли у пользователя уже такой проект в корзине
			$checkExist = $db->get_var("SELECT quantity FROM Message234 WHERE User_ID = $AUTH_USER_ID AND project_id = $item[project]");
			
			if(is_null($checkExist)) {
				$query = "INSERT INTO `Message234` (`Message_ID`, `User_ID`, `Subdivision_ID`, `Sub_Class_ID`, `Priority`, `Keyword`, `ncTitle`, `ncKeywords`, `ncDescription`, `Checked`, `TimeToDelete`, `TimeToUncheck`, `IP`, `UserAgent`, `Parent_Message_ID`, `Created`, `LastUpdated`, `LastUser_ID`, `LastIP`, `LastUserAgent`, `project_id`, `quantity`, `price`, `action_id`, `OrderNumber`) VALUES
				(NULL, $AUTH_USER_ID, 355, 363, 1, '', '', '', '', 1, NULL, NULL, '', '', 0, NOW(), NOW(), $AUTH_USER_ID, NULL, NULL, $item[project], $item[quantity], $item[price], NULL, '$item[OrderNumber]');";
				
				$db->query($query);
			} else {
			
				$db->query("UPDATE Message234 SET quantity = quantity + $item[quantity] WHERE User_ID = $AUTH_USER_ID AND project_id = $item[project] LIMIT 1");
			
			}
			
			
		}
		unset($_SESSION['cart']);
	}
}

/**
 * Диалоговое окно, в случае, если пользователь купил акции в незарегистрированном виде, а потом авторизовался
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @return string
 */
function showCartModal() {
	global $nc_l, $nc_translate;
	$result = "";
	if (isset($_SESSION['confirmation']) && checkAuth()) {
		$result .= "
			<div class='ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable ui-resizable'>
			   <div class='ui-dialog-content ui-widget-content' id='dialog'>
				  {$nc_translate[125][$nc_l]}
			   </div>
			</div>
		";
		unset($_SESSION['confirmation']);
	}
	return $result;
}

/**
 * Возвращает кнопку на страницу регистрации
 * @global string $nc_l Язык: ru или en
 * @global array $nc_translate массив с текстом для перевода
 * @return string
 */
function becomePartnerLink() {
	global $nc_l, $nc_translate;
	$result = "";
	if (!checkAuth()) {
		$result .= "
			<div class='become-partner'>
				<div class='l'></div>
				<a href='/profile/registration/' title=''>{$nc_translate[46][$nc_l]}</a>
				<div class='r'></div>
			</div>
		";
	}
	return $result;
}

/**
 * Безопасный редирект, делает редирект на указанную страницу с exit() или без него
 * @param string $url Адрес, на который редиректить
 * @param bool $exit Делать exit() или нет, по умолчанию true
 */
function safe_redirect($url, $exit = true) {
	if (!headers_sent()) {
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $url);
		header("Connection: close");
	}

	print '<html>';
	print '<head><title>Redirecting you...</title>';
	print '<meta http-equiv="Refresh" content="0;url=' . $url . '" />';
	print '</head>';
	print '<body onload="location.replace(\'' . $url . '\')">';
	print 'You should be redirected to this URL:<br />';
	print "<a href=" . $url . ">$url</a><br /><br />";

	print 'If you are not, please click on the link above.<br />';

	print '</body>';
	print '</html>';

	if ($exit)
		exit;
}

/**
 * Вызывается в случае изменения проекта, сохраняя его старые значения
 * @global nc_Db $db подключение базы данных
 * @global int $AUTH_USER_ID id пользователя
 * @param string $text
 * @param type $message
 */
function historyUpdate($text, $message = null) {
	global $db, $AUTH_USER_ID;
	$query = "";

	if (is_null($message)) {
		$message = $db->get_var("SELECT Message_ID FROM Message192 ORDER BY Message_ID DESC LIMIT 1;");
	}


	$query .= "INSERT INTO `Message224` (`Message_ID`, `User_ID`, `Subdivision_ID`, `Sub_Class_ID`, `Priority`, `Keyword`, `ncTitle`, `ncKeywords`, `ncDescription`, `Checked`, `TimeToDelete`, `TimeToUncheck`, `IP`, `UserAgent`, `Parent_Message_ID`, `Created`, `LastUpdated`, `LastUser_ID`, `LastIP`, `LastUserAgent`, `projectID`, `description`) VALUES
	(NULL, $AUTH_USER_ID, 182, 243, 1, '', '', '', '', 1, NULL, NULL, '$_SERVER[REMOTE_ADDR]', '$_SERVER[HTTP_USER_AGENT]', 0, NOW(), NOW(), 0, NULL, NULL, $message,
	'" . $db->escape($text) . "');";

	$db->query($query);
}

/**
 * Функция возвращает хлебные крошки для внутренних страниц
 * @global array $current_sub Параметры текущего раздела
 * @global string $REQUEST_URI Текущая страница
 * @global array $browse_path_1 Параметры для html отображения хлебных крошек
 * @global array $browse_path Параметры для html отображения хлебных крошек
 * @return string
 */
function mw_breadcrumbs() {
	global $current_sub, $REQUEST_URI, $browse_path_1, $browse_path;
	ob_start();
	if (in_array($current_sub['Subdivision_ID'], array(107, 108)) && preg_match('@_\d\d?\.html@i', $REQUEST_URI)) {
		echo s_browse_path($browse_path_1);
	} else {
		echo s_browse_path($browse_path);
	}

	$breadcrumbs = ob_get_contents();
	ob_end_clean();

	if (in_array($current_sub['Hidden_URL'], array('/investors/why-invest-in-wi/'))) {
		$breadcrumbs = preg_replace('@(<a.*?>.*?<\/a>.*?<span.*?>.*?<\/span>).*?<a.*?>(.*?)<\/a>@is', '$1<em>$2</em>', $breadcrumbs);
	} else if(in_array($current_sub['Hidden_URL'], array('/project/projects-for-sale/'))) {
		$breadcrumbs = preg_replace('@<a href=\'\/project\/projects-for-sale\/.+?>(.*?)</a>.*?</em>@is', '<em>$1</em>', $breadcrumbs);
	}

	return $breadcrumbs;
}

/**
 * Функция для обрезки текста по длине
 * @param type $text Текст для обработки
 * @param type $maxchar Сколько знаков оставить
 * @param type $end Как закончить, в случае, если текст на
 * входе длиннее, по умолчанию '...'
 * @return string
 */
function substrwords($text, $maxchar, $end = '...') {
	if (strlen($text) > $maxchar || $text == '') {
		$words = preg_split('/\s/', $text);
		$output = '';
		$i = 0;
		while (1) {
			$length = strlen($output) + strlen($words[$i]);
			if ($length > $maxchar) {
				break;
			} else {
				$output .= " " . $words[$i];
				++$i;
			}
		}
		$output .= $end;
	} else {
		$output = $text;
	}
	return $output;
}

/**
 * Функция для обработки текста для компонента Person, обрезает html теги и
 * длину текста с помощью функции substrwords
 * @param type $text Текст для обработки
 * @param type $length Желаемая длина текста, по умолчанию 180 знаков
 * @return string
 */
function personTextProcess($text, $length = 180) {
	$result = "";
	$result .= substrwords(trim(str_replace('&nbsp;', '', strip_tags($text))), $length);
	return $result;
}

/**
 * Функция для формирования текста комментария при отправке заказа в систему Assist
 * @param type $OrderNumber Уникальный номер заказа, хранится в Message234, колонка OrderNumber
 * @return string
 */
function AssistText($OrderNumber) {
	$result = "";
	$result .= "Оплата заказа '$OrderNumber'";

	return $result;
}

/**
 * Проверка статуса оплаты в системе Assist
 * @param string $Ordernumber Уникальный номер заказа, хранится в Message234, колонка OrderNumber
 * @return string Возвращает полученный xml
 */
function checkAssistStatus($Ordernumber) {
	$result = "";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, Merchant_orderstate_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "Ordernumber=" . $Ordernumber . "&Merchant_ID=" . Merchant_ID . "&Login=" . Merchant_Login . "&Password=" . Merchant_Password . "&Format=3");
	$out = curl_exec($curl);
	$result .= $out;
	curl_close($curl);
	return $result;
}

/**
 * Вытаскивает данные из строки от Assist в формате xml
 * @param string $Ordernumber Уникальный номер заказа, хранится в Message234, колонка OrderNumber
 * @return array Возвращает массив из двух значений:
 * status - статус заказа
 * billnumber - номер заказа в системе ассист (номер возвращается с лишним окончанием на конце после точки)
 */
function getAssistStatusAttr($Ordernumber) {
	$status;
	$billnumber;
	$amount;
	$currency;
	$check = true;
	$xml = checkAssistStatus($Ordernumber);

	preg_match('@<orderstate>(.*?)<\/orderstate>@is', $xml, $status);
	$status = $status[1];
	preg_match('@<billnumber>(.+?)<\/billnumber>@is', $xml, $billnumber);
	$billnumber = $billnumber[1];
	preg_match('@<orderamount>(.+?)<\/orderamount>@is', $xml, $amount);
	$amount = floor($amount[1]);
	preg_match('@<ordercurrency>(.+?)<\/ordercurrency>@is', $xml, $currency);
	$currency = $currency[1];
	
	if(trim($currency) != 'USD')  $check = false;

	return array('status' => $status, 'billnumber' => $billnumber, 'orderamount' => $amount, 'ordercurrency' => $currency, 'check' => $check);
}

/**
 * Покупка акций на сайте, срабатывает после получения положительного статуса от ассиста
 * @global nc_Db $db подключение базы данных
 * @global int $AUTH_USER_ID id пользователя
 * @param int $project Message_ID из таблицы Message192, id проекта
 * @param int $quantity Сколько акций хочет пользователь
 * @param int $cart Message_ID из таблицы Message234, id заказа пользователя
 */
function buyAuctions($project, $quantity, $cart) {
	global $db, $AUTH_USER_ID;

	$project = (int) $project;
	$quantity = (int) $quantity;
	$cart = (int) $cart;

	if (!($project > 0 && $quantity > 0 && $cart > 0)) {
		activityRedirect();
	}

	$row = $db->get_results("SELECT Message_ID, selling_id FROM Message234 WHERE Message_ID = $cart AND User_ID = $AUTH_USER_ID LIMIT 1", ARRAY_A);
	
	if (empty($row))
		activityRedirect();

	if(empty($row[0]['selling_id']))
	{
	//покупка пользователем у фирмы
		$project_values = $db->get_results("SELECT Count, Price FROM Message192 WHERE Message_ID = $project LIMIT 1;", ARRAY_A); // Выбрать из базы цену
		if (is_null($project_values))
			activityRedirect();
		$price = $project_values[0]['Price'];

		/* Проверяем сколько акций доступно для покупки */
		$shares_quantity = $project_values[0]['Count'];
		$buyed_shares = $db->get_results("SELECT SUM(Quantity) as Quantity FROM Message220 WHERE Id = $project AND ProjectType = 1 LIMIT 1;", ARRAY_A); // Выбрать из базы цену
		if (is_null($buyed_shares))
			activityRedirect();
		$buyed_shares = $buyed_shares[0]['Quantity'];
		$avaible_shares = $shares_quantity - $buyed_shares;

		if ($avaible_shares < $quantity) {
			activityRedirect();
		}
	}
	else
	{
	//покупка пользователем у пользователя
		$project_values = $db->get_results("SELECT Price, Quantity FROM Message220 WHERE Message_ID = ".$row[0]['selling_id']." AND ProjectType = 2 AND auction = 1 LIMIT 1;", ARRAY_A);
		
		if (empty($project_values))
			activityRedirect();
			
		$price = $project_values[0]['Price'];
		if ($project_values[0]['Quantity'] != $quantity) {
			activityRedirect();
		}
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

	$query = "INSERT INTO `Message220` (`Message_ID`, `User_ID`, `Subdivision_ID`, `Sub_Class_ID`, `Priority`, `Keyword`, `ncTitle`, `ncKeywords`, `ncDescription`, `Checked`, `TimeToDelete`, `TimeToUncheck`, `IP`, `UserAgent`, `Parent_Message_ID`, `Created`, `LastUpdated`, `LastUser_ID`, `LastIP`, `LastUserAgent`, `Confirmation`, `Id`, `Quantity`, `Price`, `ProjectType`, `PriceAll`, `IdBuying`, `auction`, `revenue`";

	$last_date_ownership = $db->get_var("SELECT last_date_ownership FROM Message220 WHERE User_ID = $settings[User_ID] AND Id = $settings[Id] ORDER BY last_date_ownership DESC LIMIT 1;");
	if (!is_null($last_date_ownership)) {
		$query .= ", `last_date_ownership`";
	}

	$query .= ") VALUES (NULL, $settings[User_ID], $settings[Subdivision_ID], $settings[Sub_Class_ID], 1, '', NULL, NULL, NULL, 1, NULL, NULL, '$settings[IP]', '', 0, NOW(), NOW(), 0, NULL, NULL, $settings[Confirmation], $settings[Id], $settings[Quantity], $settings[Price], $settings[ProjectType], $settings[PriceAll], NULL, $settings[auction], 0";

	if (!is_null($last_date_ownership)) {
		$query .= ", '$last_date_ownership'";
	}

	$query .= ");";
	$db->query($query);

	/* Delete from cart */
	$db->query("DELETE FROM Message234 WHERE User_ID = $AUTH_USER_ID AND project_id = $project AND Message_ID = $cart LIMIT 1;");
	/* /Delete from cart */
	
	if(!empty($row[0]['selling_id']))
	{
		$query = "SELECT * FROM Message220 WHERE Message_ID = ".$row[0]['selling_id'];
		$buyer = $db->get_row($query, ARRAY_A);
		$query = "SELECT * FROM Message220 WHERE Message_ID = $buyer[IdBuying] AND ProjectType = 1 LIMIT 1;";
		$owner = $db->get_row($query, ARRAY_A);
		$owner['Quantity_old'] = $owner['Quantity'];
		$owner['Quantity'] = $owner['Quantity'] - $buyer['Quantity'];
		$revenue = $buyer['revenue'];
		$owner['PriceAll'] = $buyer['Price'] * $owner['Quantity_old'];

		if ($owner['Quantity'] == 0)
		{
			$query = "UPDATE Message220 SET LastUpdated = NOW(), Price = $buyer[Price],
			PriceAll = $owner[PriceAll], ProjectType = 2, auction = 0, revenue = $revenue
			WHERE Message_ID = $owner[Message_ID] LIMIT 1;";
			$db->query($query);
			$db->query("DELETE FROM Message220 WHERE Message_ID = ".$row[0]['selling_id']);
		}
		else
		{
			$owner['PriceAll'] = $owner['Price'] * $owner['Quantity'];
			$query = "UPDATE Message220 SET LastUpdated = NOW(), Quantity = $owner[Quantity],
			PriceAll = $owner[PriceAll] WHERE Message_ID = $owner[Message_ID] LIMIT 1;";
			$db->query($query);
			$query = "UPDATE Message220 SET LastUpdated = NOW(), auction = 0
			WHERE Message_ID = ".$row[0]['selling_id']." AND ProjectType = 2 AND auction = 1;";
			$db->query($query);
		}
	}
	/* Set sold-status for project and add new records to sold-projects table in db*/
	else if ($avaible_shares - $quantity <= 0)
	{
	
		$db->query("UPDATE Message192 SET Checked = 0 WHERE Message_ID = $project OR Parent_Message_ID = $project;");
		$project_values = $db->get_results("SELECT * FROM Message192 WHERE Message_ID = $project LIMIT 1;", ARRAY_A);
		if(!empty($project_values))
		{
			$settings = array(
			'User_ID' => $AUTH_USER_ID,
			'Subdivision_ID' => 111,
			'Sub_Class_ID' => 242,
			'IP' => $_SERVER["REMOTE_ADDR"],
			);
			$main_query = "INSERT INTO `Message223` (`Message_ID`, `User_ID`, `Subdivision_ID`, `Sub_Class_ID`, `Priority`, `Keyword`, `ncTitle`, `ncKeywords`, `ncDescription`, `Checked`, `TimeToDelete`, `TimeToUncheck`, `IP`, `UserAgent`, `Parent_Message_ID`, `Created`, `LastUpdated`, `LastUser_ID`, `LastIP`, `LastUserAgent`, `name`, `text`, `facts`, `photo`, `photo_small`, `photo_main`, `name_rus`, `text_rus`, `facts_rus`) VALUES ";
			
			$project_values = $project_values[0];
			$query = $main_query."(NULL, $settings[User_ID], $settings[Subdivision_ID], $settings[Sub_Class_ID], $project_values[Priority], '$project_values[Keyword]', '$project_values[ncTitle]', '$project_values[ncKeywords]', '$project_values[ncDescription]', 1, '$project_values[TimeToDelete]', '$project_values[TimeToUncheck]', '$settings[IP]', '', 0, NOW(), NOW(), 0, '$project_values[LastIP]', '$project_values[LastUserAgent]', '$project_values[name]', '$project_values[text]', '$project_values[facts]', '$project_values[photo]', '$project_values[photo_small]', '$project_values[photo_main]', '$project_values[name_rus]', '$project_values[text_rus]', '$project_values[facts_rus]')";
			$db->query($query);
			
			if($sold_project_id = $db->insert_id)
			{
				$project_values = $db->get_results("SELECT * FROM Message192 WHERE Parent_Message_ID = $project;", ARRAY_A);
				$query = "";
				foreach($project_values as $project_value)
				{
					$query .= "(NULL, $settings[User_ID], $settings[Subdivision_ID], $settings[Sub_Class_ID], $project_value[Priority], '$project_value[Keyword]', '$project_value[ncTitle]', '$project_value[ncKeywords]', '$project_value[ncDescription]', 1, '$project_value[TimeToDelete]', '$project_value[TimeToUncheck]', '$settings[IP]', '', $sold_project_id, NOW(), NOW(), 0, '$project_value[LastIP]', '$project_value[LastUserAgent]', '$project_value[name]', '$project_value[text]', '$project_value[facts]', '$project_value[photo]', '$project_value[photo_small]', '$project_value[photo_main]', '$project_value[name_rus]', '$project_value[text_rus]', '$project_value[facts_rus]'),";
				}
				if(!empty($query))
				{
					$query = $main_query.substr($query, 0, -1);
					$db->query($query);
				}
			}
		}
	}
	$_SESSION['fuckyeah'] = 13;
}

function activityRedirect($link = "/profile/activity/")
{
	header("Location: $link");
	exit();
}

/**
 * Проверка переменных и проверка статуса в системе ASSIST, если статус Approved - действие по покупке акций
 * @global nc_Db $db подключение базы данных
 * @global int $AUTH_USER_ID id пользователя
 */
function buyProjectAuctions() {
	global $db, $AUTH_USER_ID;
	if (isset($_GET['billnumber']) && isset($_GET['ordernumber']) && $AUTH_USER_ID) {
		$ordersum = 0; // сумма заказа
	
		$ordernumber = $db->escape($_GET['ordernumber']);
		$checkS = $db->get_results("SELECT * FROM Message234 WHERE User_ID = $AUTH_USER_ID AND OrderNumber = '$ordernumber' AND checked_item = 1;", ARRAY_A);
		if (!is_null($checkS) && count($checkS) > 0) {
			$info = getAssistStatusAttr($_GET['ordernumber']);
			if ($info['status'] === 'Approved') {
				foreach ($checkS as $check) {
					$ordersum += $check['quantity'] * $check['price'];
				}
				//echo '$ordersum ' . $ordersum . "<br>\r\n";
				//echo '$info[orderamount] ' .  . "<br>\r\n";
				if($ordersum == $info['orderamount']) {
					foreach ($checkS as $check) {
						buyAuctions($check['project_id'], $check['quantity'], $check['Message_ID']);
					}				
				}
				safe_redirect('/profile/activity/');
			}
			
		}
	}
}

/**
 * Функция для обновления колличества акций в корзине с помощью ajax запроса
 * используется на странице корзины
 * @global nc_Db $db подключение базы данных
 * @global int $AUTH_USER_ID id пользователя
 * @param int $quantity Колличество акций для покупки
 * @param int $cart_id id заказа (хранятся в Message234 -> Message_ID)
 * @param int $project_id id проекта (хранятся в Message192 -> Message_ID)
 * @return int Возвращает $quantity, если столько акций доступно для покупки, 0,
 * если произошла ошибка или максимально возможное колличество акций для покупки,
 * если $quantity больше него.
 */
function updateCartQuantity($quantity, $cart_id) {
	global $db, $AUTH_USER_ID;
	$result = 0;

	$quantity = (int) $quantity;
	$cart_id = (int) $cart_id;

	$check = $db->get_var("SELECT quantity FROM Message234 WHERE User_ID = $AUTH_USER_ID AND Message_ID = $cart_id LIMIT 1;");

	if (!is_null($check) && $quantity > 0 && $quantity != $check) {
		// Выбираем project_id
		$project_id = $db->get_var("SELECT project_id FROM Message234 WHERE User_ID = $AUTH_USER_ID AND Message_ID = $cart_id LIMIT 1;");
	
	
		// Смотрим сколько всего акций
		$project_quantity = $db->get_var("SELECT Count FROM Message192 WHERE Message_ID = $project_id LIMIT 1;");

		// Смотрим сколько акций куплено
		$buyed_shares = $db->get_var("SELECT SUM(Quantity) as Quantity FROM Message220 WHERE Id = $project_id AND ProjectType = 1 LIMIT 1;");
		if (is_null($buyed_shares))
			$buyed_shares = 0;

		$avaible_shares = $project_quantity - $buyed_shares;

		if ($avaible_shares < $quantity) {
			$result = $avaible_shares;
		} else {
			$result = $quantity;
		}

		$db->query("UPDATE Message234 SET quantity = $result WHERE User_ID = $AUTH_USER_ID AND Message_ID = $cart_id");
	} else if (!is_null($check) && $quantity > 0 && $quantity == $check) {
		$result = $quantity;
	}

	return $result;
}

/**
 * Функция возвращает ссылку в шапке для перехода на страницу покупки проектов
 * @return string
 */
function projectForSaleLink() {
	return "<a class='project-for-sale' href='/project/projects-for-sale/' title='Projects for sale'>Projects for sale</a>";
}

/**
 * Функция для вывода html кода в шапке на страницах второго уровня
 * @global string $nc_l
 * @global array $nc_translate
 * @global array $browse_sub
 * @return string
 */
function htmlHeader() {
	global $nc_l, $nc_translate, $browse_sub;
	$result = "";
	ob_start();
	echo "
          <a href='/' id='logo'>Texas Onshore AB</a>
          " . showCart() . "
          " . projectForSaleLink() . "
    ";
	if (strpos($_SERVER[REQUEST_URI], '/investors/investor-relations/') === false) {
		echo "<a class='button-relation' href='/investors/investor-relations/' title=''>{$nc_translate[61][$nc_l]}</a>";
	} else {
		echo "<a class='button-relation inactive-link' href='#' title=''>{$nc_translate[61][$nc_l]}</a>";
	}
	if(!checkAuth()) {
		echo "<a class='become-partner' href='/profile/registration/' title=''>{$nc_translate[46][$nc_l]}</a>";
	}
	echo "
          " . languageButton() . "
          <div class='clear'></div>
          " . s_browse_level(0, $browse_sub[0]) . "
	      <!-- #nav -->
    ";
	$result = ob_get_contents();
	ob_end_clean();

	return $result;
}

// Проверяет сколько акций доступно для покупки 
function getAvailableSharesCount($project, $selling_id=0) {
	global $db;
	if($selling_id == 0)
	{
		$project_values = $db->get_results("SELECT Count, Price FROM Message192 WHERE Message_ID = $project LIMIT 1;", ARRAY_A);
		$shares_quantity = $project_values[0]['Count'];
		$buyed_shares = $db->get_results("SELECT SUM(Quantity) as Quantity FROM Message220 WHERE Id = $project AND ProjectType = 1 LIMIT 1;", ARRAY_A); // Выбрать из базы цену
		if (is_null($buyed_shares)) return false;
		$buyed_shares = $buyed_shares[0]['Quantity'];
		$avaible_shares = $shares_quantity - $buyed_shares;
	}
	else
	{
		$count = $db->get_var("SELECT Quantity FROM Message220 WHERE Message_ID = $selling_id;");
		$avaible_shares = !empty($count) ? $count : 0;
	}
	return $avaible_shares;
}

// возвращает количество товаров в корзине
function getProductsQuatityInCart() {
	global $db, $AUTH_USER_ID;
	// если пользователь авторизован - берем содержание корзины из базы
	if (isset($AUTH_USER_ID) && $AUTH_USER_ID != 0) {
		$query = $db->get_var("SELECT COUNT(*) FROM Message234 WHERE User_ID = $AUTH_USER_ID;");
		return $query;
	// у неавторизованных пользователей корзина лежит в $_SESSION['cart']
	} else {
		if (isset($_SESSION['cart'])) {
			$count = count($_SESSION['cart']);
			if ($count > 0) {
				return $count;
			} else {
				return 0;
			}
		}
	}
}

// возвращает текущий язык сайта
function getCurrentSiteLanguage() {
	global $nc_l;
	if ($nc_l == 'ru') {
		return 'ru';
	} else if ($nc_l == 'en') {
		return 'en';
	} else {
		return FALSE;
	}
}

// возвращает класс валюты для вывода в корзине
function getDefaultCurrency() {
	$lang = getCurrentSiteLanguage();
	if ($lang == 'ru') {
		return 'rub';
	} else if ($lang == 'en') {
		return 'usd';
	} else {
		return '';
	}
}

/* возвращает поправочный коэффициент для вывода цены товара в корзине
*  в зависимости от текущей валюты.
*  Если рубли - вернет курс доллара, если доллары - вернет 1
*/
function getExchangeRateByCurrency() {
	global $db;
	// взять курс доллара из настроек сайта
	$rate = $db->get_var("SELECT `exchange_rate` FROM `Catalogue` WHERE `Catalogue_ID` = 1;");
	$currency = getDefaultCurrency();
	if ($currency == 'rub') {
		//return 30;
		return $rate;
	} else if ($currency == 'usd') {
		return 1;
	} else {
		// выводить в случае ошибки
		return 1;
	}
}

function getExchangeRate() {
	global $db;
	// взять курс доллара из настроек сайта
	$rate = $db->get_var("SELECT `exchange_rate` FROM `Catalogue` WHERE `Catalogue_ID` = 1;");
	return $rate;
}

// отправка файла отчета на email
function sendEmailAttachment($filePath, $file) {
	if (!$filePath) {
		return 'error';
	}
	global $db, $AUTH_USER_ID;
	if ($AUTH_USER_ID) {
		$email = $db->get_var("SELECT Email FROM User WHERE User_ID = $AUTH_USER_ID;");
	}

	$filePath = "../.." . $filePath;
	$spamFromEmail = $db->get_var("SELECT `Value` FROM `Settings` WHERE `Key` = 'SpamFromEmail'");
	$mailer = new CMIMEMail();
	$mailer->attachFile($filePath, $file, "application/octet-stream");
	$mailer->send($email, $spamFromEmail, $spamFromEmail, 'Файл отчета','tos-invest');
	return TRUE;
}

?>