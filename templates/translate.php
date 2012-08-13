<?php
	global $nc_l, $nc_translate;
	if(strpos($_SERVER['SERVER_NAME'], 'ru.') !== false) {
		$nc_l = 'ru';
	} else {
		$nc_l = 'en';
	}

	$nc_translate = array(
		1 => array('en' => 'create a new post', 'ru' => 'создать новый топик'),
		2 => array('en' => 'publish', 'ru' => 'отправить'),
		3 => array('en' => 'answer', 'ru' => 'ответить'),
		4 => array('en' => 'Fill in this field', 'ru' => 'Заполните это поле'),
		5 => array('en' => 'Answer', 'ru' => 'Ответ'),
		6 => array('en' => 'Update code', 'ru' => 'Обновить'),
		7 => array('en' => 'required', 'ru' => 'обязательно'),
		8 => array('en' => 'Previous', 'ru' => 'Назад'),
		9 => array('en' => 'Next', 'ru' => 'Вперед'),
		10 => array('en' => 'Your name', 'ru' => 'Ваше имя'),
		11 => array('en' => 'Title', 'ru' => 'Заголовок'),
		12 => array('en' => 'Post', 'ru' => 'Сообщение'),
		13 => array('en' => 'New post', 'ru' => 'Новый топик'),
		14 => array('en' => 'Code', 'ru' => 'Код'),
		15 => array('en' => 'My activity', 'ru' => 'Мои активы'),
		16 => array('en' => 'My subscribe', 'ru' => 'Мои подписки'),
		17 => array('en' => 'My account', 'ru' => 'Мой профиль'),
		18 => array('en' => 'Private Office', 'ru' => 'Личный кабинет'),
		19 => array('en' => 'If you would like to edit your subscribe, please, check necessary', 'ru' => 'Если вы захотите отписаться, пожалуйста, снимите флажок с ненужных'),
		20 => array('en' => 'save my subscribe', 'ru' => 'сохранить настройки'),
		21 => array('en' => 'FAQ', 'ru' => 'FAQ'),
		22 => array('en' => 'Question', 'ru' => 'Вопрос'),
		23 => array('en' => 'send', 'ru' => 'отправить'),
		24 => array('en' => 'PROJECT', 'ru' => 'ПРОЕКТ'),
		25 => array('en' => 'SHARES PURCHASED', 'ru' => 'КУПЛЕННЫЕ АКЦИИ'),
		26 => array('en' => 'RATE', 'ru' => 'СТАВКА'),
		27 => array('en' => 'USD', 'ru' => 'USD'),
		28 => array('en' => 'ACTIONS', 'ru' => 'ДЕЙСТВИЯ'),
		29 => array('en' => 'REVENUE', 'ru' => 'ПРИБЫЛЬ'),
		30 => array('en' => 'ACTIVE', 'ru' => 'АКТИВЫ'),
		31 => array('en' => 'Сompany\'s proposal', 'ru' => 'Предложение компании'),
		32 => array('en' => 'the maximum competitive price for sale', 'ru' => 'самая низкая цена для продажи'),
		33 => array('en' => 'most favorable price for the purchase of', 'ru' => 'самая высокая цена для покупки'),
		34 => array('en' => 'Sell', 'ru' => 'Продать'),
		35 => array('en' => 'Buy', 'ru' => 'Купить'),
		36 => array('en' => 'SOLD', 'ru' => 'ПРОДАННЫЕ'),
		37 => array('en' => 'OTHER PROJECTS', 'ru' => 'ДРУГИЕ ПРОЕКТЫ'),
		38 => array('en' => 'Shares', 'ru' => 'Акции'),
		39 => array('en' => 'Price', 'ru' => 'Цена'),
		40 => array('en' => 'close', 'ru' => 'закрыть'),
		41 => array('en' => 'Total', 'ru' => 'Всего'),
		42 => array('en' => 'Holder', 'ru' => 'Держатель'),
		43 => array('en' => 'Available shares', 'ru' => 'Акции в наличии'),
		44 => array('en' => '1 share price', 'ru' => 'Стоимость одной акции'),
		45 => array('en' => 'Quantity', 'ru' => 'Количество'),
		46 => array('en' => 'Become a partner', 'ru' => 'Стать партнером'),
		48 => array('en' => 'Logout', 'ru' => 'Выйти'),
		49 => array('en' => 'Member login', 'ru' => 'Авторизация'),
		50 => array('en' => 'Login', 'ru' => 'Логин'),
		51 => array('en' => 'Password', 'ru' => 'Пароль'),
		52 => array('en' => 'remember me', 'ru' => 'запомнить'),
		53 => array('en' => 'Registration', 'ru' => 'Регистрация'),
		54 => array('en' => 'Forgot password?', 'ru' => 'Забыли пароль?'),
		55 => array('en' => 'News', 'ru' => 'Новости'),
		56 => array('en' => 'Archive', 'ru' => 'Архив'),
		58 => array('en' => 'Texas Onshore AB in Sweden', 'ru' => 'Texas Onshore AB in Sweden'),
		59 => array('en' => 'Texas Onshore AB', 'ru' => 'Texas Onshore AB'),
		60 => array('en' => 'Phone', 'ru' => 'Телефон'),
		61 => array('en' => 'Investor relations', 'ru' => 'Акционеры'),
		62 => array('en' => 'Registration a new customer', 'ru' => 'Регистрация нового пользователя'),
		63 => array('en' => 'Please, fill in all the fields.', 'ru' => 'Пожалуйста, заполните все поля.'),
		64 => array('en' => 'Name', 'ru' => 'Имя'),
		65 => array('en' => 'E-mail', 'ru' => 'E-mail'),
		66 => array('en' => 'Client address - street name', 'ru' => 'Адрес клиента - улица'),
		67 => array('en' => 'Client address - zip code', 'ru' => 'Адрес клиента - индекс'),
		68 => array('en' => 'Client address - city name', 'ru' => 'Адрес клиента - город'),
		69 => array('en' => 'Client address - country', 'ru' => 'Адрес клиента - страна'),
		70 => array('en' => 'Client phone number', 'ru' => 'Телефон клиента'),
		71 => array('en' => 'Delivery address - Name', 'ru' => 'Адрес доставки - Имя'),
		72 => array('en' => 'Delivery address - street name', 'ru' => 'Адрес доставки - улица'),
		73 => array('en' => 'Delivery address - zip code', 'ru' => 'Адрес доставки - индекс'),
		74 => array('en' => 'Delivery address - city name', 'ru' => 'Адрес доставки - город'),
		75 => array('en' => 'Delivery address - country', 'ru' => 'Адрес доставки - страна'),
		76 => array('en' => 'Payment method', 'ru' => 'Способ оплаты'),
		77 => array('en' => 'Tax Code', 'ru' => 'Код налога'),
		78 => array('en' => 'join us', 'ru' => 'отправить'),
		79 => array('en' => 'New photo', 'ru' => 'Добавить фотографию'),
		80 => array('en' => 'Change photo', 'ru' => 'Изменить<br>фотографию'),
		81 => array('en' => 'edit my subscribe', 'ru' => 'редактировать подписки'),
		82 => array('en' => 'More information', 'ru' => 'Подробней'),
		83 => array('en' => 'Contacts', 'ru' => 'Контакты'),
		84 => array('en' => 'edit my account', 'ru' => 'изменить данные'),
		85 => array('en' => 'Confirm password', 'ru' => 'Подтвердите пароль'),
		86 => array('en' => 'reports', 'ru' => 'отчеты'),
		87 => array('en' => 'Quarter', 'ru' => 'Кварталы'),
		88 => array('en' => '1st', 'ru' => '1й'),
		89 => array('en' => '2nd', 'ru' => '2й'),
		90 => array('en' => '3d', 'ru' => '3й'),
		91 => array('en' => '4th', 'ru' => '4й'),
		92 => array('en' => 'print', 'ru' => 'печатать'),
		93 => array('en' => 'save', 'ru' => 'сохранить'),
		94 => array('en' => 'Board of Directors', 'ru' => 'Совет директоров'),
		95 => array('en' => 'Management Team', 'ru' => 'Члены правления'),
		96 => array('en' => 'Biography', 'ru' => 'Биография'),
		97 => array('en' => 'More information', 'ru' => 'Подробней'),
		98 => array('en' => 'Press releases', 'ru' => 'Пресс релизы'),
		99 => array('en' => 'kb', 'ru' => 'кб'),
		100 => array('en' => 'Glossary', 'ru' => 'Словарь'),
		101 => array('en' => 'Sales', 'ru' => 'Проекты'),
		102 => array('en' => 'Facts', 'ru' => 'Факты'),
		103 => array('en' => 'Text if all sold.', 'ru' => 'Текст если все продано'),
		104 => array('en' => 'Text if user didn\'t login.', 'ru' => 'Текст, если пользователь не авторизован.'),
		105 => array('en' => 'Download', 'ru' => 'Скачать'),
		106 => array('en' => 'From PROSPECTUS TO THE PRODUCING WELL - A Guide', 'ru' => 'Руководство'),
		107 => array('en' => 'Sales', 'ru' => 'Продажи'),
		108 => array('en' => 'Another fact', 'ru' => 'Другой факт'),
		109 => array('en' => 'Hello', 'ru' => 'Привет'),
		//110 => array('en' => 'Date', 'ru' => 'Дата'),
		111 => array('en' => 'Date', 'ru' => 'Дата'),
		112 => array('en' => 'Topic name', 'ru' => 'Тема'),
		113 => array('en' => 'Update', 'ru' => 'Обновлен'),
		114 => array('en' => 'Answer', 'ru' => 'Ответы'),
		115 => array('en' => 'Forum', 'ru' => 'Форум'),
		116 => array('en' => 'Back to topic list', 'ru' => 'Назад к списку тем'),
		117 => array('en' => 'Board', 'ru' => 'Совет директоров'),
		118 => array('en' => 'Shopping cart', 'ru' => 'Корзина'),
		119 => array('en' => 'Increase', 'ru' => 'Прибавить'),
		120 => array('en' => 'Decrease', 'ru' => 'Уменьшить'),
		//121 => array('en' => 'Where are no shares in your cart', 'ru' => 'Корзина пуста'),
		121 => array('en' => 'You have no shares, please buy.', 'ru' => 'Корзина пуста'),
		122 => array('en' => 'Sold Projects', 'ru' => 'Проданные проекты'),
		123 => array('en' => 'Documents are in Sweden', 'ru' => 'Документы в Швеции'),
		124 => array('en' => 'Your cart', 'ru' => 'Корзина'),
		125 => array('en' => 'Would you like to pay?', 'ru' => 'Продолжить покупку'),
		126 => array('en' => 'Please, fill in all fields', 'ru' => 'Это поле обязательно для заполнения'),
		127 => array('en' => 'Please enter at least {0} characters.', 'ru' => 'Пожалуйста, введите не менее {0} знаков.'),
		129 => array('en' => 'It must be an email!', 'ru' => 'Введите корректный email!'),
		//130 => array('en' => '3-D Survey', 'ru' => 'ТРЕХМЕРНАЯ СЕЙСМИЧЕСКАЯ РАЗВЕДКА'),
		131 => array('en' => 'It must equal password!', 'ru' => 'Значение не совпадает с паролем'),
		132 => array('en' => 'Password was sent on your email, please, check it.<br/>', 'ru' => 'Вам на почту отправлено письмо с вашим паролем, пожалуйста проверьте<br/>'),
		133 => array('en' => 'Your registration is succesfull.', 'ru' => 'Вы успешно зарегистрированы.'),
		134 => array('en' => 'You have no shares, please <a href="/project/projects-for-sale/">buy</a>', 'ru' => 'Корзина пуста, <a href="/project/projects-for-sale/">купить</a>'),
		135 => array('en' => 'Available shares', 'ru' => 'Доступные акции'),
		136 => array('en' => 'Quiсk subscribe', 'ru' => 'Подписка'),
		137 => array('en' => 'If you like to get fresh news please, enter your email: ', 'ru' => 'Для получения новостей о проектах введите свой email: '),
		138 => array('en' => '/images/texasonshore/img/subscribe.png', 'ru' => '/images/texasonshore/img/subscribe_rus.png'),
		139 => array('en' => 'Sorry, this email has already exist', 'ru' => 'Этот email уже используется'),
		140 => array('en' => 'Save changes', 'ru' => 'Сохранить изменения'),
		141 => array('en' => 'Confrm password', 'ru' => 'Повторите пароль'),
		142 => array('en' => 'Sorry, this login has already exist', 'ru' => 'Извините, такой пользователь уже существует'),
		//confirm_mail_body
		'confirm_mail_body' => array(
			'en' => "
Hello, %USER_LOGIN
<br><br>
You successfully registered on Texas Onshore AB web-site <a href='http://www.tos-invest.com'>http://www.tos-invest.com</a><br><br>
Login: 	%USER_LOGIN<br>
Password: 	%PASSWORD<br><br>

Please, click the link below to activate your account: <a href='%CONFIRM_LINK'>%CONFIRM_LINK</a><br><br>

Best regards Texas Onshore AB.<br>
			", 'ru' => "
Здравствуйте, %USER_LOGIN
<br><br>
Вы успешно прошли регистрацию на сайте <a href='http://www.ru.tos-invest.com'>http://www.tos-invest.com</a><br><br>
Логин: 	%USER_LOGIN<br>
Пароль: 	%PASSWORD<br><br>

Пожалуйста, нажмите на ссылку внизу, чтобы активировать вашу учетную запись: <a href='%CONFIRM_LINK'>%CONFIRM_LINK</a><br>

С наилучшими пожеланиями Texas Onshore AB.<br>
		"),
		//confirm_mail_subject
		'confirm_mail_subject' => array(
			'en' => "Registration on %SITE_NAME",
			'ru' => "Подтверждение регистрации на сайте %SITE_NAME",
		),
		//subscribe_confirm_mail_body
		'subscribe_confirm_mail_body' => array(
			'en' => "
Hello, this is Taxes Onshore AB,
<br><br>
To confirm your subscribe please go to <a href='%LINK%'>this link.</a>
<br>
If your activity on our web-site was wrong, you shouldn’t do anything!
<br><br>
Best regards, <a href='http://www.tos-invest.com'>www.tos-invest.com</a>
			", 'ru' => "
Здравствуйте, Вас приветсвует компания Taxes Onshore AB,
<br><br>
Чтобы подтвердить подписку, перейдите по <a href='%LINK%'>ссылке.</a>
			"),
		//subscribe_confirm_mail_subject
		'subscribe_confirm_mail_subject' => array(
			'en' => "Subscribe www.tos-invest.com",
			'ru' => "Подписка ru.tos-invest.com",
		),
		//subscribe_text_subscribe
		'subscribe_text_subscribe' => array(
			'en' => "
Congratulations! <br>
Now you subscribe to our new projects. <br>
Have a good day! <br>
			", 'ru' => "
Поздравляем!<br>
Теперь вы подписаны на новые проекты компании. Отписаться от рассылки вы всегда можете из письма рассылки.<br>
			",
		),
		//subscribe_text_unsubscribe
		'subscribe_text_unsubscribe' => array(
			'en' => "
You successfully unsubscribe. <br>
			", 'ru' => "
Вы успешно отписались от рассылки.
			",
		),
	);

	// {$nc_translate[10][$nc_l]}
?>