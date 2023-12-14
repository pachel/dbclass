<?php

namespace Pachel\dbClass\Callbacks;
use Pachel\dbClass\Traits\callMethod;

abstract class CallbackBase
{
    protected $class = "";
//    protected $arguments = [];

    public function __construct($class)
    {
        $this->class = $class;
    }
    public function __call(string $name, array $arguments)
    {
        return $this->class->$name(...$arguments);
    }
}