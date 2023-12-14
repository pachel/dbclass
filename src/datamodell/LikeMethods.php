<?php

namespace Pachel\dbClass\dataModel\Traits;

trait LikeMethods
{
    public function __call($name, $arguments)
    {
        $arguments = array_merge([$name],$arguments);
        return $this->class->_like(...$arguments);
    }
}