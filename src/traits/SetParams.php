<?php

namespace Pachel\db;

trait SetParams
{

    /**
     * @return dbClass
     */
    public function setparams($params):dbClass
    {
        $this->parameters = $params;
        return $this;
    }
}