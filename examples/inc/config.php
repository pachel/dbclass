<?php
/**
 * Created by PhpStorm.
 * User: toth
 * Date: 21.05.2019
 * Time: 10:33
 */

use Pachel\dbClass;

$db_options = array(
    \PDO::MYSQL_ATTR_COMPRESS   => true,
    \PDO::ATTR_PERSISTENT       => false,
    \PDO::ATTR_ERRMODE          => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_EMULATE_PREPARES => false
);
$db_config = [
    "host" => "localhost",
    "dbname" => "dbclass_test",
    "charset" => "utf8",
    "username" => "dbclass",
    "password" => "dbclass"
];

//dbClass::instance()->connect($db_config,$db_options);
$db = new dbClass();
$db->connect($db_config,$db_options);