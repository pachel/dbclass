<?php

namespace Pachel\dbClass\dataModel\callBacks;


use Pachel\dbClass\Callbacks\CallbackBase;

class DMupdateCallback extends CallbackBase
{
    public function id(int $id)
    {
        return $this->class->_update([$this->class->_primary=>$id]);
    }

    /**
     * @param array|object $params
     * @return mixed
     */
    public function where($params)
    {
        return $this->class->_update($params);
    }
    public function __call($name, $arguments)
    {
        return $this->class->_update([$name=>$arguments[0]]);
    }
}