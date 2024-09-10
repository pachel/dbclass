<?php

namespace Pachel\dbClass\dataModel\Traits;

use Pachel\dbClass\Traits\getMethods;

trait EqMethods
{
    public function __call($name, $arguments)
    {
        $arguments = array_merge([$name],$arguments);
        return $this->class->_eq(...$arguments);
    }
    use getMethods;
}