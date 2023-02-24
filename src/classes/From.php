<?php


namespace Pachel\Classes;


use Pachel\db\dbClass;
use Pachel\db\Traits\Exec;


class From
{
    /**
     * @var dbClass
     */
    protected $db;



    use Exec;
    use \Pachel\db\Traits\Where;
    public function __construct(&$db)
    {
        $this->db = &$db;
    }



}