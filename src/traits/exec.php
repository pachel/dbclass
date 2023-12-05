<?php

namespace Pachel\dbClass\Traits;

trait exec
{
    public function exec()
    {
        return $this->class->_exec();
    }
}