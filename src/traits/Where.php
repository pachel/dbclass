<?php

namespace Pachel\db\Traits;

use Pachel\db\dbClass;

trait Where
{
    /**
     * @var string $query
     */
    protected string $query;
    /**
     * @var dbClass $db
     */
    protected dbClass $db;

    /**
     * --------------------------------------------------------------------------
     *
     * --------------------------------------------------------------------------
     * @param string $param
     * @return \Pachel\Classes\Where
     */
    public function where($param){
        $this->db->parameters["searchtext"] = null;
        $this->db->parameters["limit"] = null;
        $this->db->parameters["where"] = $param;

        return new \Pachel\Classes\Where($this->db);
    }
}
