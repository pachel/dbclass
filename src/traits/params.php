<?php

namespace Pachel\dbClass\Traits;

use Pachel\dbClass\Callbacks\paramsCallback;

trait params
{
    /**
     * @return paramsCallback
     */
    public function params($params):paramsCallback
    {
        return $this->class->_params($params);
    }
}