<?php

namespace Pachel\dbClass\Traits;

use Pachel\dbClass\Callbacks\paramsCallback;

trait params
{
    /**
     * @return paramsCallback
     */
    public function params():paramsCallback
    {
        $params = func_get_args();
        return $this->class->_params(...$params);
    }
}