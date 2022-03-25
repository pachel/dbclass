<?php
/**
 * Created by PhpStorm.
 * User: toth
 * Date: 23.05.2019
 * Time: 16:13
 */

namespace Pachel;

final class datamodell
{
    private $table;
    private $db;
    private $query,$params;
    /**
     * datamodell constructor.
     * @param $table
     * @param $db
     */
    public function __construct($table, &$db)
    {
        $this->table = $table;
        $this->db = &$db;
    }
    public function find($query,$params = []){
        $this->query = $query;
        $this->params = $params;
        return $this;
    }
    /**
     * asdasdasd as
     */
    /**
     * Select all rows from this table
     *
     * @param array $data
     * @return mixed
     */
    public function get_all($data = [])
    {
        return $this->db->select($this->table);
    }

    /**
     * Select only one row from this table
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->db->select($this->table, ["id" => $id])[0];
    }
    public function get_by_data($data = [])
    {
        // TODO: Implement get_by_data() method.
    }

    /**
     * @param $data
     * @param $id
     */
    public function updateById($data, $id)
    {
        $this->db->update($this->table,$data, ["id"=>$id]);
    }

    /**
     * @param $data
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * @param $id
     */
    public function deleteById($id)
    {
        return $this->db->delete($this->table, ["id"=>$id]);
    }
    public function orderBy($query){
        $this->query.=" ORDER BY ".$query;
        return $this;
    }
    //asdasd
    public function groupBy($query){
        $this->query.=" GROUP BY ".$query;
        return $this;
    }
    //asdas
    public function delete(){
        $this->db->toDatabase("DELETE FROM `".$this->table."` WHERE ".$this->query,$this->params);
    }

    public function row(){
        return $this->db->fromDatabase("SELECT *FROM `".$this->table."` WHERE ".$this->query,$this->params,"@line");
    }
    public function rows(){
        return $this->db->fromDatabase("SELECT *FROM `".$this->table."` WHERE ".$this->query,$this->params);
    }
    private function setQuery(){

    }
}