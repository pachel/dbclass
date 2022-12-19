<?php

namespace Pachel\db;

use mysql_xdevapi\TableSelect;

trait Exec
{
    /**
     * @param $mode array
     * @return dbClass
     * @throws \Exception
     */
    public function exec($mode = null): dbClass
    {

        return $this->fromDatabase($this->generateQuery(),$this->parameters,$mode);
    }

    private function generateQuery()
    {
        $sql = "SELECT ".$this->selectFields." FROM ".$this->fromTables;
        return $sql;

    }


}