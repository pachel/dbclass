<?php

namespace Pachel\db\Traits;

use Pachel\db\dbClass;

trait Where
{
    protected $query;
    /**
     * @var dbClass
     */
    protected $db;

    public function where($param){
        $this->db->parameters["where"] = $param;
        return new \Pachel\Classes\Where($this->db);
    }
}
