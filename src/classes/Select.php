<?php


namespace Pachel\Classes;



class Select
{
    /**
     * @var dbClass
     */
    private $db;


    public function __construct($db)
    {
        $this->db = &$db;
    }

    public function from($table)
    {
        $this->db->parameters["table"] = $table;
        return new From($this->db);

    }
}