<?php

namespace Pachel\dbClass\dataModel\Traits;

use Pachel\dbClass\Traits\getMethods;

trait UpMethods
{
    public function __call($name, $arguments)
    {
        $arguments = array_merge([$name],$arguments);
        return $this->class->_up(...$arguments);
    }
    public function where(){
        return $this->class->_where();
    }
    public function exec(){
        return $this->class->_exec();
    }
}