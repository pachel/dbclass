<?php

namespace Pachel\db\Traits;

use Pachel\db\dbClass;

trait Exec
{
    protected $query;
    /**
     * @var dbClass
     */
    protected $db;

    public function array(): array
    {
        $this->makeSqlQuery();
        return $this->fromDb();
    }

    public function line()
    {
        $this->makeSqlQuery();
        return $this->fromDb("@line");
    }

    public function simple(): string
    {
        $this->makeSqlQuery();
        return (string)$this->fromDb("@simple");
    }

    public function group($by): string
    {
        $this->makeSqlQuery();
        return $this->fromDb("@group", $by);
    }

    private function fromDb($type = null, $group = null)
    {

        if (!isset($this->db->parameters["pdo_parameters"]) || empty($this->db->parameters["pdo_parameters"])) {
            return $this->db->fromDatabase($this->query, $type, [], $group);
        } else {

            return $this->db->fromDatabase($this->query, $type, $this->db->parameters["pdo_parameters"], $group);
        }
    }

    private function makeSqlQuery()
    {
        $sql = "SELECT ";
        if (!isset($this->db->parameters["fields"]) || is_null($this->db->parameters["fields"])) {
            $sql .= "* ";
        } else {
            if (is_array($this->db->parameters["fields"])) {
                //TODO: Tömbös mezőnevek kezelése
                foreach ($this->db->parameters["fields"] as $field) {

                }
            }
            $sql .= $this->db->parameters["fields"] . " ";
        }
        $sql .= "FROM `" . $this->db->parameters["table"] . "` ";
        $this->db->parameters["pdo_parameters"] = null;
        if (isset($this->db->parameters["where"]) && !empty($this->db->parameters["where"])) {
            if(is_array($this->db->parameters["where"])){
                $sql.="WHERE ";
                $c = 0;
                $where = $this->db->parameters["where"];
                foreach ($where AS $key=>$item){
                    if($c>0){
                        $sql.=" AND ";
                    }
                    $sql.="`".$key."`=:".$key;
                    $this->db->parameters["pdo_parameters"][$key]=$item;
                    $c++;
                }

            }
            else{
                $sql.="WHERE ".$this->db->parameters["where"];
            }
        }

        $this->query = $sql;

    }
}
