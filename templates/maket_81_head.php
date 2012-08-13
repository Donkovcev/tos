<?php

global $nc_l, $nc_translate; // перевод
if (($REQUEST_URI == '/netcat/modules/auth/') && isset($IsAuthorized) && $IsAuthorized == 0 && isset($_POST['AUTH_USER']) && isset($_POST['AUTH_PW'])) {
	$t_login = mysql_real_escape_string($_POST['AUTH_USER']);
	$t_pass = mysql_real_escape_string($_POST['AUTH_PW']);
	$log_valid = $db->get_var("SELECT User_ID FROM User WHERE Login = '$t_login' LIMIT 1;");
	$nc_valid = "";
	if (is_null($log_valid)) {
		$nc_valid = 1;
	} else {
		$nc_valid = 2;
	}
}
echo "<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <title>Texas Onshore AB</title>
  <link rel='stylesheet' type='text/css' href='/images/texasonshore/styles/style.css'>
  <link rel='icon' href='/favicon.ico' type='image/x-icon'>
  <link rel='shortcut icon' href='/favicon.ico' type='image/x-icon'>
  <!--[if lte IE 7]>
  <link rel='stylesheet' type='text/css' href='/images/texasonshore/styles/style-ie7.css'>
  <![endif]-->
</head>
<body>
  <div id='page' class='home'>
    <div id='wrapper'>
      <div id='layout'>
        <div id='header'>
          <a href='/' id='logo' title=''>{$nc_translate[59][$nc_l]}</a>
		  " . showCart() . "
		  " . projectForSaleLink() . "
		  <a class='button-relation' href='/investors/investor-relations/'>{$nc_translate[61][$nc_l]}</a>
";
if (!checkAuth()) {
	echo "<a class='become-partner' href='/profile/registration/' title=''>{$nc_translate[46][$nc_l]}</a>";
}
echo "
		  " . languageButton() . "
		  <div class='clear'></div>
          " . s_browse_level(0, $browse_sub[0]) . "
		  <div class='clear'></div>
        </div><!-- #header -->
        <div id='content'>
		
	

		

";
?>