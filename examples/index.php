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



$teszt = $db->from("p_szamlak")->where(["statusz"=>1])->limit(2,2)->array();
//print_r($teszt);

$Users = new MyModell($db,"p_szamlak");

$keresos = $Users->search("2021-12-01")->limit(0,2)->array();
print_r($keresos);


$en = $db->from("m_felhasznalok")->where(["id"=>1])->line();

print_r($en);

if($szamla = $Users->find(1754)){

    echo "ifelve:".$szamla->sorszam;
}
