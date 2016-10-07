<?php
session_start();
if ($_GET['superid']=='1')
{
    $_SESSION['superid'] = '1';
}
if ($_GET['superid']=='0')
{
    unset($_SESSION['superid']);
}

$_SESSION['superid'] = '1';


//require the general classes
/*require("classes/loader.php");
require("classes/base.controller.php");
require("classes/base.model.php");
require("modules/hook/hook.controller.php");
require("modules/hook/hook.model.php");*/

require_once('classes/settings.php');
require_once("classes/loader.php");
require_once("classes/base.controller.php");
require_once("classes/base.model.php");
require_once("modules/hook/hook.controller.php");
require_once("modules/hook/hook.model.php");


Helper::sendUserData();

//create the controller and execute the action
$loader = new Loader($_GET, TRUE);
$controller = $loader->CreateController();
$controller->ExecuteAction();
?>

