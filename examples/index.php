<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__."/MyModell.php";
require_once __DIR__."/UserType.php";
use Pachel\db\dbClass;
use Pachel\db\Modell;


abstract class Teszt implements ArrayAccess
{
    private $container;

    public function __construct()
    {
        $this->container = [
            "host" => "localhost",
            "charset" => "UTF8",
            "dbname" => null,
            "username" => null,
            "password" => null
        ];
    }

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return (isset($this->container[$offset]) ? $this->container[$offset] : null);
    }

    public function offsetSet($offset, $value): void
    {
        if(!isset($this->container[$offset])){
            throw new Exception("Nemlétező paraméter: ".$offset);
        }
        $this->container[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }
}

final class TEszt2 extends Teszt
{

}
trait SelectTrait{
    public $teszt="d";
}
trait FromtTrait{
    use SelectTrait;
    public $tables;




}

class Select{

    use FromtTrait;
    public function __construct()
    {

    }

}

//$d = new Select();

//echo $d->teszt;

dbClass::setConfig(__DIR__."/local-db-config.php");
$db = dbClass::instance();



//$teszt = $db->select()->from("p_szamlak")->where()->line();

$Users = new MyModell($db,"p_szamlak");
//$gecet = $Users->where(["statusz"=>0])->array();
//print_r($gecet);
$szamla = $Users->find(1754);

echo $szamla->sorszam."\n";
echo $szamla->beerkezes;




