<?php

namespace Pachel\db;

trait OrderBy
{
    /**
     * @return dbClass
     */
    public function orderby():dbClass
    {
        return $this;
    }
}