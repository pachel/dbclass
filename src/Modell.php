<?php


namespace Pachel\db;


use http\Params;

class Modell extends dbClass
{
    protected dbClass $db;
    protected string $table;
    public function __construct(string $table = NULL)
    {
        if(!is_null($table)){
            $this->table = $table;
        }
        $this->db = parent::instance();
    }
}