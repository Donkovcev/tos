<?php

/*

".opt( !$totRows && $nc_status != 1, "Нет рассылок")."
".opt( $nc_status == 1, "На указанный e'mail отправлен код подтверждения")."
".opt( $nc_status == 2, "Неверный email")."
".opt( $nc_status == 3, "Не выбрана рассылка")."
".opt( $nc_status == 4, "Неправильно введены символы, изображенные на картинке")."
".opt( $nc_status == 5, "Письмо с подтверждением подписки Вам выслано повторно")."

*/


global $nc_l, $nc_translate;
echo "
			<div class='profile'>
				<h1 class='profile_title'>{$nc_translate[18][$nc_l]}</h1>
";

echo profileMenu();

echo "

				<div class='clear'></div>

				<div class='profile-page'>
					<p class='message'>{$nc_translate[19][$nc_l]}</p>
					<form action='".$SUB_FOLDER.$HTTP_ROOT_PATH."modules/subscriber/index.php' method='post'>
					<ul class='subscribe ". (isset($edit) ? "subscribe-checkboxes" : "") ."'>
";
?>