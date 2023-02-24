<?php

use Pachel\Classes\Where;

/**
 * Created by PhpStorm.
 * User: toth
 * Date: 23.05.2019
 * Time: 16:13
 */
class BaseModell
{
    /**
     * @var \Pachel\db\dbClass $db
     */
    protected $db;

    use \Pachel\db\Traits\Exec;
    use \Pachel\db\Traits\Where;

    public function __construct($db, $table)
    {
        $this->db = $db;
        $this->db->parameters["table"] = $table;
    }
    public function all(){
        $d = new \Pachel\Classes\From($this->db);
        return $d->array();
    }


    public function find($id)
    {
        $this->db->setObject(true);
        $this->db->parameters["where"] = ["id"=>$id];
        $where = new Where($this->db);
        return  $where->line();

    }
}

