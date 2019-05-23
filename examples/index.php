<?php
error_reporting(E_ALL);
ini_set("display_errors",true);

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/inc/config.php";

//$db = Pachel\dbClass::instance();


$data = [
    "name" => "Laszlo Toth",
    "email" => "pachel82@gmail.com"
];

if($db->fromDatabase("SELECT id FROM users WHERE id=:id",["id"=>1],"@simple") != 1 ){
    $db->insert("users",$data);
}
$users = $db->fromDatabase("SELECT id,name,email FROM users");
print_r($users);

//$users = Pachel\dbClass::instance()->fromDatabase("SELECT id,name,email FROM users");
$users = $db->fromDatabase("SELECT id,name,email FROM users");
print_r($users);


$user = $db->getModell("users");

//print_r($user->get_all());

//$user->insert($data);


print_r($user->get_by_id(1));


