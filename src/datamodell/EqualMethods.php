<?php

namespace Pachel\dbClass\dataModel\Traits;

trait EqualMethods
{
    public function __call($name, $arguments)
    {
        $arguments = array_merge([$name],$arguments);
        return $this->class->_equal(...$arguments);
    }

}