<?php

namespace Pachel\db\Traits;

use Pachel\db\dbClass;

trait Limit
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
     * @return \Pachel\Classes\Limit
     */
    public function limit($from=null,$to=null):\Pachel\Classes\Limit{
        $this->db->parameters["limit"] = ["from"=>$from,"to"=>$to];
        return new \Pachel\Classes\Limit($this->db);
    }
}
