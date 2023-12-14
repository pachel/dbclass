<?php

namespace Pachel\dbClass\dataModel\Traits;

trait setget
{

    public function __get($name)
    {
        if(property_exists($this,$name)){
            return $this->{$name};
        }
    }
    public function __set($name, $value)
    {
        if(property_exists($this,$name)){
            $this->{$name} = $value;
        }
    }
}