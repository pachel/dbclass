<?php


namespace Pachel\Classes;



use Pachel\db\dbClass;
use Pachel\db\Traits\Exec;


class Limit
{
    /**
     * @var dbClass
     */
    protected dbClass $db;

    use Exec;

    /**
     * Where constructor.
     * @param dbClass $db
     */
    public function __construct(&$db)
    {
        $this->db = &$db;
    }


}