<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__."/MyModell.php";
require_once __DIR__."/UserModell.php";
require_once __DIR__."/UserType.php";
require_once __DIR__ . "/SzamlaType.php";
use Pachel\db\dbClass;
use Pachel\db\Modell;



echo "<pre>";

//$d = new Select();

//echo $d->teszt;

dbClass::setConfig(__DIR__."/local-db-config.php");
$db = dbClass::instance();


$Szamlak = new MyModell($db,"p_szamlak");
$Users = new UserModell($db,"m_felhasznalok");
$szamlak = $Szamlak->search("László")->limit(2)->array();
print_r($szamlak);
$userek = $Users->search("László")->array();
print_r($userek);
$en = $Users->find(1);
echo $en->nev;


