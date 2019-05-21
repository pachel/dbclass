<?php
require_once __DIR__."/../vendor/autoload.php";

$db = require __DIR__."/inc/config.php";

if($db->fromDatabase("SELECT id FROM users WHERE id=:id",["id"=>1],"@simple") != 1 ){
    $data = [
        "name" => "Laszlo Toth",
        "email" => "pachel82@gmail.com"
    ];
    $db->arrayToDatabase($data,"users");
}
$data = $db->fromDatabase("SELECT id,name,email FROM users");
print_r($data);