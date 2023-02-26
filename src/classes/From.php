<?php


namespace Pachel\Classes;


use Pachel\db\dbClass;
use Pachel\db\Traits\Exec;
use Pachel\db\Traits\Limit;


class From
{
    /**
     * @var dbClass
     */
    protected dbClass $db;



    use Exec;
    use \Pachel\db\Traits\Where;
    use Limit;
    public function __construct(&$db)
    {
        $this->db = &$db;
    }

}