<?php


use Pachel\Classes\From;
use Pachel\Classes\Where;
use Pachel\db\dbClass;

use Pachel\db\Traits\Exec;
use Pachel\db\Traits\Limit;

/**
 * Created by PhpStorm.
 * User: toth
 * Date: 23.02.2023
 * Time: 16:13
 */
class BaseModell
{
    /**
     * @var dbClass $db
     */
    protected dbClass $db;

    protected $SearchableFields = "all";

    protected string $userDefinedType = "";

    use Exec;
    use \Pachel\db\Traits\Where;
    use Limit;

    /**
     * --------------------------------------------------------------------------
     *  Kezdő maraméterként szükség van a db objektumra, és a tábla nevére,
     *  amiből az adatokat szeretnénk kinyerni
     * --------------------------------------------------------------------------
     * @param Pachel\db\dbClass $db
     * @param string $table
     */
    public function __construct($db, $table)
    {
        $this->db = $db;
        $this->db->parameters = [];
        $this->db->parameters["table"] = $table;
    }

    /**
     * --------------------------------------------------------------------------
     * A tábla összes adatát visszaadja egy tömb fomájában, vagy
     *  objektumkként, attól függően, hogy hogyan lett paraméterezve
     *  a config állomány!
     * --------------------------------------------------------------------------
     * @return array
     */
    public function all()
    {
        $d = new From($this->db);
        return $d->array();
    }


    /**
     * --------------------------------------------------------------------------
     * ID alapján ad vissza egy objektumot, ami a tábla összes mezőjét
     * tartalmazza.
     * --------------------------------------------------------------------------
     * @param int $id
     * @return object User defined object
     */
    public function find($id)
    {
        $this->db->setObject(true);
        $this->db->parameters["where"] = ["id" => $id];
        $where = new Where($this->db);
        return $where->line();

    }

    /**
     * --------------------------------------------------------------------------
     *
     * --------------------------------------------------------------------------
     * @param string $searchtext
     * @return \Pachel\Classes\Search
     */
    public function search($text):\Pachel\Classes\Search
    {
        $this->db->parameters["searchtext"] = $text;
        $this->db->parameters["searchfields"] = $this->getFields();
        //print_r($this->db->parameters["searchfields"]) ;
        return new \Pachel\Classes\Search($this->db);

    }

    private function getFields(): array
    {
        if($this->SearchableFields == "all"){
            $ret = [];
            $vars = get_class_vars($this->userDefinedType);
            foreach ($vars AS $key => $value){
                $ret[] = $key;
            }
            return $ret;
        }
        return $this->SearchableFields;
    }
}

