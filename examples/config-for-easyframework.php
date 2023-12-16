<?php
$c = [
    "PDBCLASS" => [
        "SERVER" => [
            "host" => "localhost",
            "dbname" => "dbclass_test",
            "charset" => "utf8",
            "username" => "root",
            "password" => "",
            "saveClassDir" => __DIR__ . "/../Models/",
            "modelDir" => __DIR__ . "/../inc/Models/",
            "default_result_mode" => dbClass::DB_RESULT_TYPE_OBJECT
        ],
        "OPTIONS" => [
            \PDO::MYSQL_ATTR_COMPRESS => true,
            \PDO::ATTR_PERSISTENT => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false
        ]
    ]
];
