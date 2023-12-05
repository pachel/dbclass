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


$result = $db->query("SELECT *FROM dolgozok")->line();
print_r($result);

$result = $db->query("SELECT *FROM dolgozok WHERE id=:id")->params(["id"=>13])->line();
print_r($result);

$result = $db->query("SELECT *FROM dolgozok WHERE id=?")->params([16])->line();
print_r($result);

$db->query("UPDATE dolgozok SET nev=? WHERE id=?")->params(["Tóth László",1])->exec();

$result = $db->query("SELECT *FROM dolgozok WHERE id=?")->params([1])->line();
print_r($result);

$k = new tt();
$k->nev = "asdasd";
$db->update("dolgozok",$k,["id"=>1]);
exit();
$data = [
    "name" => "Laszlo Toth",
    "email" => "pachel82@gmail.com"
];

if($db->fromDatabase("SELECT id FROM dolgozok WHERE id=:id",["id"=>1],"@simple") != 1 ){
    //$db->insert("users",$data);
}

$db->query()->line();
$users = $db->fromDatabase("SELECT * FROM dolgozok");
//print_r($users);

$users = $db->fromDatabase("SELECT * FROM dolgozok");
//print_r($users);


$user = $db->getModell("dolgozok");
print_r($user->getById(1));
print_r($user->find("tipus=?",[1])->orderBy("nev ASC")->rows());
$user->insert(["nev"=>"teszt"]);
$id = $db->last_insert_id();
$user->deleteById($id);

/*
$params = [
    "name" => "toth"
];
$result = $db->fromDatabase("SELECT * FROM users WHERE name LIKE :name OR name LIKE :name OR name LIKE :name",$params);
print_r($result);

*/
class tt{
    public string $nev;
}