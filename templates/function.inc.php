<?php

define(IS_AJAX, (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));
define(ROOT, $_SERVER['DOCUMENT_ROOT']);
define(TEMPROOT, ROOT . "/images/texasonshore/templates/");
/* ASSIST */
define(Merchant_orderstate_url, "https://test.paysecure.ru/orderstate/orderstate.cfm");
define(Merchant_ID, "506511");
define(Merchant_Login, "texasonshore");
define(Merchant_Password, "744E38Ljt7");
/* /ASSIST */
/* SHOP */
define(PROJECTS_PAGE, "/project/projects-for-sale/");
/* /SHOP */



require_once(TEMPROOT . "translate.php");
require_once(TEMPROOT . "class/class.LEASE.php");
require_once(TEMPROOT . "class/class.mayer_ImageTransform.php");
require_once(TEMPROOT . "class/class.MayerCRUD.php");
require_once(TEMPROOT . "functions.php");
?>