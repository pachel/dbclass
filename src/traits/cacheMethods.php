<?php

namespace Pachel\dbClass\Traits;

use Pachel\dbClass\Callbacks\cacheCallback;

trait cacheMethods
{
    /**
     * @return cacheCallback
     */
    public function cache($expire)
    {
        return $this->class->_cache($expire);
    }
}