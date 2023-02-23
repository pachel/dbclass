<?php
error_reporting(E_ALL);
ini_set("display_errors",true);
require_once __DIR__."/../vendor/autoload.php";

use Pachel\db\dbClass;
use Pachel\db\Modell;

dbClass::setConfig(__DIR__."/local-db-config.php");

$db = dbClass::instance();
$db->select()->from("teszt")->exec();


