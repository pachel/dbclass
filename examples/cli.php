<?php
error_reporting(E_ALL);
ini_set("display_errors",true);

use Pachel\dbClass;

require_once __DIR__."/../vendor/autoload.php";
if(file_exists(__DIR__."/inc/dev_config.php")){
    require_once __DIR__ . "/inc/dev_config.php";
}
else {
    require_once __DIR__ . "/inc/config.php";
}

//$db = Pachel\dbClass::instance();
$db = new dbClass();
$db->connect($db_config,$db_options);
$db->settings()->setResultmodeToObject();

$db->settings()->generateModelClass("__users", __DIR__ . "/../temp/__users.php");