<?php

namespace Pachel\db;

trait From
{

    /**
     * @return dbClass
     */
    public function from($table):dbClass
    {

        $this->fromTables = $table;
        return $this;
    }
}