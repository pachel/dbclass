<?php

namespace Pachel\db;

trait Select
{

    public function select($fields = null):dbClass
    {
        if(empty($fields)){
            $this->selectFields = "*";
        }
        return $this;
    }
}