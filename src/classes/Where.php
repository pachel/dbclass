<?php


namespace Pachel\Classes;



use Pachel\db\dbClass;
use Pachel\db\Traits\Exec;

class Where
{
    /**
     * @var dbClass
     */
    protected $db;

    use Exec;

    /**
     * Where constructor.
     * @param dbClass $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }


}