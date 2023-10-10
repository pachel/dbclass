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
    use ResetAll;
    /**
     * --------------------------------------------------------------------------
     *
     * --------------------------------------------------------------------------
     * @param string $param
     * @return \Pachel\Classes\Where
     */
    public function where($param){
        $this->resetAllParameter();
        $this->db->parameters["where"] = $param;

        return new \Pachel\Classes\Where($this->db);
    }
}
