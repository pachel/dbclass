<?php

namespace Pachel\db\Traits;

use Pachel\db\dbClass;

trait Exec
{
    protected string $query;
    /**
     * @var dbClass
     */
    protected dbClass $db;

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
                $c = 0;
                foreach ($this->db->parameters["fields"] as $field) {
                    if ($c > 0) {
                        $sql . +", ";
                    }
                    $sql .= $field;
                    $c++;
                }
            }
            $sql .= $this->db->parameters["fields"] . " ";
        }
        $sql .= "FROM `" . $this->db->parameters["table"] . "` ";
        $this->db->parameters["pdo_parameters"] = null;
        if (isset($this->db->parameters["where"]) && !empty($this->db->parameters["where"])) {
            if (is_array($this->db->parameters["where"])) {
                $sql .= "WHERE ";
                $c = 0;
                $where = $this->db->parameters["where"];
                foreach ($where as $key => $item) {
                    if ($c > 0) {
                        $sql .= " AND ";
                    }
                    $sql .= "`" . $key . "`=:" . $key;
                    $this->db->parameters["pdo_parameters"][$key] = $item;
                    $c++;
                }

            } else {
                $sql .= "WHERE " . $this->db->parameters["where"];
            }
            if (!empty($this->db->parameters["searchtext"])) {
                $sql.=" AND (`".implode("` LIKE '%".$this->db->parameters["searchtext"]."%' OR `",$this->db->parameters["searchfields"])."` LIKE '%".$this->db->parameters["searchtext"]."%'".")";

            }
        }
        else{
            if (!empty($this->db->parameters["searchtext"])) {
                $sql.=" WHERE (`".implode("` LIKE '%".$this->db->parameters["searchtext"]."%' OR `",$this->db->parameters["searchfields"])."` LIKE '%".$this->db->parameters["searchtext"]."%'".")";

            }
        }

        if (isset($this->db->parameters["limit"]) && !empty($this->db->parameters["limit"])) {
            $sql .= " LIMIT " . $this->db->parameters["limit"]["from"] . (!empty($this->db->parameters["limit"]["to"]) ? "," . $this->db->parameters["limit"]["to"] : "");
        }

        $this->query = $sql;
        echo $sql."\n";
    }

}
