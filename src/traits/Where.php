<?php

namespace Pachel\db;

trait Where
{
    /**
     * @return dbClass
     */
    public function where():dbClass
    {
        return $this;
    }
}