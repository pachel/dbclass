#dbClass
##Installation
Install width composer or dowload from this link: https://github.com/pachel/dbclass
```
composer require pachel/dbclass
```
##Init
```
$params = [
    "host" => "localhost",
    "dbname" => "dbname",
    "charset" => "utf8",
    "username" => "username",
    "password" => "password"
];
$DB = new dbClass();
$DB->connect($params);
```
or
```
$params = [
    "host" => "localhost",
    "dbname" => "dbname",
    "charset" => "utf8",
    "username" => "username",
    "password" => "password"
];
dbClass::instance()->connect($params);
```
or
```
$params = [
    "host" => "localhost",
    "dbname" => "dbname",
    "charset" => "utf8",
    "username" => "username",
    "password" => "password"
];
$DB = new dbClass($params);

```