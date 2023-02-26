<?php


namespace Pachel\Classes;



use Pachel\db\dbClass;
use Pachel\db\Traits\Exec;
use Pachel\db\Traits\Limit;

class Where
{
    /**
     * @var dbClass
     */
    protected dbClass $db;

    use Exec;
    use Limit;
    /**
     * Where constructor.
     * @param dbClass $db
     */
    public function __construct(&$db)
    {
        $this->db = &$db;
    }


}