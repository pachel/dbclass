<?php

namespace Pachel\dbClass\Models;

class cacheData extends \stdClass
{
    public function __construct($data,$expire = 60)
    {
        $this->data = $data;
        $this->saved = time();
        $this->expire = $expire+$this->saved;
    }
    public $data;
    public $saved;
    public $expire;
}