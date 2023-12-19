<?php
error_reporting(E_ALL);
ini_set("display_errors",true);

use Pachel\dbClass;

require_once __DIR__."/../vendor/autoload.php";

require __DIR__."/inc/dolgozokModel.php";
require __DIR__."/inc/__users.php";

if(file_exists(__DIR__."/inc/dev_config.php")){
    require_once __DIR__ . "/inc/dev_config.php";
}
else {
    require_once __DIR__ . "/inc/config.php";
}
/*
$vezeteknevek = ["Fekete","Fehér","Barna","Sárga","Kék","Lila","Rózsaszín","Piros","Zöld"];
$keresztnevek = ["Sanyi","Géza","Ildi","Imi","Feri","Laci","Gizi","Piros","Sanya","Niki","Réka","Lili","Anna"];
for($x=0;$x<50;$x++){
    $nev = $vezeteknevek[mt_rand(0,count($vezeteknevek)-1)]." ".$keresztnevek[mt_rand(0,count($keresztnevek)-1)];
    echo "INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('".$nev."','".mt_rand(0,10)."','".str_replace(" ","@",$nev).".fake');\n";
}*/
//$db = Pachel\dbClass::instance();
$db = new dbClass();
$db->settings()->connect($db_config,$db_options);
$db->settings()->setResultmodeToObject();

/**
 * @var _line33_index_php_bf69f[] $d
 */
$d = $db->query("SELECT * FROM __users WHERE type=1")->rows();
print_r($d);
foreach ($d AS $f){
    echo $f->type."\n";
    echo $f->name."\n";
}
exit();
/**
 * @var __usersDataModel $user
 */
$user = new stdClass();

$usersModel = new __usersModel($db);
$d = $usersModel->getById(2);
echo $d->name;

$e = $usersModel->equal()->type(1);
print_r($e);
$e = $usersModel->equal()->id(42);
print_r($e);
$e = $usersModel->like()->email("lila");
print_r($e);
$e = $usersModel->like()->name("Barna");
print_r($e);

$user = $usersModel->select(["type"=>1])->rows();
foreach ($user AS $sd){

}



exit();
//$result = $db->query("SELECT *FROM dolgozok")->line();
//print_r($result);

$result = $db->query("SELECT *FROM dolgozok WHERE id=:id")->params(["id"=>13])->line();
print_r($result);

$result = $db->query("SELECT *FROM dolgozok WHERE id=? AND atirt=?")->params(16,0)->line();
print_r($result);

$result = $db->query("SELECT *FROM dolgozok")->rows();
print_r($result);

exit();
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
