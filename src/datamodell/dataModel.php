<?php
/**
 * Created by PhpStorm.
 * User: toth
 * Date: 23.05.2019
 * Time: 16:13
 */

namespace Pachel\dbClass\dataModel;


use Pachel\dbClass;
use Pachel\dbClass\dataModel\Callbacks\equalCallback;
use Pachel\dbClass\dataModel\Traits\setget;

abstract class dataModel
{
    /**
     *
     * @var string|null $_tablename
     */
    protected  $_tablename = "";
    /**
     *
     * @var string $_primary
     */
    protected  $_primary = "id";
    /**
     * A SELECT lekérdezésben láthatatlan mezők nevei
     * @var array $_not_visibles
     */
    protected  $_not_visibles = [];

    protected  $_classname = dataModel::class;
    protected  $_modelclass = "";

    /**
     *
     * @var string $_safefield
     */
    protected $_safefield = null;
    /**
     * @var bool $_safemode
     */
    protected $_safemode = false;

    protected $_likeclass;
    protected $_equalclass;
    protected $_eqclass;
    protected $_upclass;

    private $up_data = [
      "params" => [],
      "where"=>[],
      "nxt"=>false
    ];

    /**
     * @var dbClass $db
     */
    protected  $db;

    protected $_data_tmp;

    public function __call(string $name, array $arguments)
    {
        if(method_exists($this,$name)) {
            return $this->$name(...$arguments);
        }
        else{
            return $this->select([$name=>$arguments[0]]);
        }
    }
    public function __construct(&$db)
    {
        if (empty($this->_tablename)) {
            new Exception("Nincs Táblanév definiálva!");
        }
        $this->_classname = get_called_class();
        if($db != null) {
            $this->db = &$db;
        }
    }

    use setget;
    /**
     * Select only one row from this table
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->db->query("SELECT *FROM `".$this->_tablename."` WHERE `".$this->_primary."`=?")->params($id)->line();
    }
    public function update($data){
        $this->_data_tmp = $data;
        return new dbClass\dataModel\callBacks\DMupdateCallback($this);
    }
    protected function _update($where)
    {
        return $this->db->update($this->_tablename, $this->_data_tmp,$where);
    }
    protected function select($where){
        $this->_data_tmp = $where;
        return new dbClass\dataModel\callBacks\selectCallback($this);
        //return $this->db->select($this->_tablename,$where);
    }
    /**
     * @param $data
     * @param $id
     */
    public function updateById($data, $id)
    {
        $this->db->update($this->_tablename,$data, [$this->_primary=>$id]);
    }

    /**
     * @param $data
     */
    public function insert($data)
    {
        return $this->db->insert($this->_tablename, $data);
    }

    /**
     * @param $id
     */
    public function deleteById($id)
    {
        return $this->db->delete($this->_tablename, [$this->_primary=>$id]);
    }

    /**
     * @return mixed
     */
    public function lastInsertId(){
        return $this->db->last_insert_id();
    }
    protected  function _like($field,$value,$one = false){
        if($one){
            return $this->db->query("SELECT *FROM `".$this->_tablename."` WHERE `".$field."` LIKE ?")->params("%".$value."%")->line();
        }
        else{
            return $this->db->query("SELECT *FROM `".$this->_tablename."` WHERE `".$field."` LIKE ?")->params("%".$value."%")->rows();
        }

    }
    protected  function _equal($field,$value,$one = false){
        if($one){
            return $this->db->query("SELECT *FROM `" . $this->_tablename . "` WHERE `" . $field . "`=?")->params($value)->line();
        }
        else {
            return $this->db->query("SELECT *FROM `" . $this->_tablename . "` WHERE `" . $field . "`=?")->params($value)->rows();
        }
    }
    private $_parameters = [];
    protected function _eq($field,$value){
        $this->_parameters[$field] = $value;
        return new $this->_eqclass($this);
    }

    /**
     * @param array|object $where
     * @return void
     */
    public function delete($where){
        return $this->db->delete($this->_tablename,$where);
    }
    protected function like(){
        return new $this->_likeclass($this);
    }

    /**
     * Több feltételes lekérdezés
     * @return mixed
     */
    protected function eq(){
        return new $this->_eqclass($this);
    }

    /**
     *
     * @return mixed
     */
    protected function up(){
        $this->up_data = [
            "params" => [],
            "where"=>[],
            "nxt"=>false,
        ];
        return new $this->_upclass($this);
    }
    protected function _up($name,$value){
        if($this->up_data["nxt"]){
            $this->up_data["where"][$name] = $value;
        }
        else {
            $this->up_data["params"][$name] = $value;
        }
        return new $this->_upclass($this);
    }
    protected function _where(){
        $this->up_data["nxt"] = true;
        return new $this->_upclass($this);
    }
    protected function equal(){
        return new $this->_equalclass($this);
    }
    protected function _exec(){
        $ret = $this->db->update($this->_tablename,$this->up_data["params"],$this->up_data["where"]);
        $this->up_data =[
            "params" => [],
            "where"=>[],
            "nxt"=>false
        ];
        return $ret;
        //return $this->db->toDatabase("SELECT *FROM `".$this->_tablename."` WHERE ".$where, $type,$params);
    }
    //s
    protected function _get(string $type)
    {
        switch ($type) {
            case "line":
                $type = "@line";
                break;
            case "simple":
                $type = "@simple";
                break;
            case "array":
                $type = "@array";
                break;
            case "assoc":
                $type = "@assoc";
                break;
            default:
                $type = "@row";
        }
        $params = [];
        if(!empty($this->_parameters)) {
            $where = $this->db->get_where($this->_parameters, $params);
            $this->_parameters = [];
        }
        else{
            $where = $this->db->get_where($this->_data_tmp, $params);
        }
        return $this->db->fromDatabase("SELECT *FROM `".$this->_tablename."` WHERE ".$where, $type,$params);
    }
}